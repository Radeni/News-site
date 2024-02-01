<?php
class KomentarDAO {
    private static $instance = null;
    private $dbConnection;

    private function __construct($dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    public static function getInstance($dbConnection) {
        if (self::$instance === null) {
            self::$instance = new KomentarDAO($dbConnection);
        }
        return self::$instance;
    }

    public function getKomentarById($id) {
        $query = "SELECT * FROM Komentar WHERE idKomentar = :id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Komentar($row['idKomentar'], $row['Ime'], $row['Tekst'], $row['Lajkovi'], $row['Dislajkovi'], $row['idVest']);
        }

        return null;
    }

    public function addKomentar(Komentar $komentar) {
        $query = "INSERT INTO Komentar (Ime, Tekst, Lajkovi, Dislajkovi, idVest) VALUES (:ime, :tekst, :lajkovi, :dislajkovi, :idVest)";
        $stmt = $this->dbConnection->prepare($query);

        $stmt->bindValue(':ime', $komentar->getIme(), PDO::PARAM_STR);
        $stmt->bindValue(':tekst', $komentar->getTekst(), PDO::PARAM_STR);
        $stmt->bindValue(':lajkovi', $komentar->getLajkovi(), PDO::PARAM_INT);
        $stmt->bindValue(':dislajkovi', $komentar->getDislajkovi(), PDO::PARAM_INT);
        $stmt->bindValue(':idVest', $komentar->getIdVest(), PDO::PARAM_INT);

        $stmt->execute();
        return $this->dbConnection->lastInsertId();
    }

    public function updateKomentar(Komentar $komentar) {
        $query = "UPDATE Komentar SET Ime = :ime, Tekst = :tekst, Lajkovi = :lajkovi, Dislajkovi = :dislajkovi WHERE idKomentar = :id";
        $stmt = $this->dbConnection->prepare($query);

        $stmt->bindValue(':id', $komentar->getIdKomentar(), PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deleteKomentar($id) {
        $query = "DELETE FROM Komentar WHERE idKomentar = :id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount();
    }
    // Prevent cloning and unserialization
    private function __clone() { }
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}
