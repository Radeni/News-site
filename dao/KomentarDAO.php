<?php
declare(strict_types=1);
class KomentarDAO {
    private static $instance = null;
    private function __construct() {
        // Prevent instantiation
    }
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new KomentarDAO();
        }
        return self::$instance;
    }

    public function getKomentarById($dbConnection, $id) {
        $query = "SELECT * FROM Komentar WHERE idKomentar = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Komentar($row['idKomentar'], $row['Ime'], $row['Tekst'], $row['Lajkovi'], $row['Dislajkovi'], $row['idVest']);
        }

        return null;
    }

    public function addKomentar($dbConnection, Komentar $komentar) {
        $query = "INSERT INTO Komentar (Ime, Tekst, Lajkovi, Dislajkovi, idVest) VALUES (:ime, :tekst, :lajkovi, :dislajkovi, :idVest)";
        $stmt = $dbConnection->prepare($query);

        $stmt->bindValue(':ime', $komentar->getIme(), PDO::PARAM_STR);
        $stmt->bindValue(':tekst', $komentar->getTekst(), PDO::PARAM_STR);
        $stmt->bindValue(':lajkovi', $komentar->getLajkovi(), PDO::PARAM_INT);
        $stmt->bindValue(':dislajkovi', $komentar->getDislajkovi(), PDO::PARAM_INT);
        $stmt->bindValue(':idVest', $komentar->getIdVest(), PDO::PARAM_INT);

        $stmt->execute();
        return $dbConnection->lastInsertId();
    }

    public function updateKomentar($dbConnection, Komentar $komentar) {
        $query = "UPDATE Komentar SET Ime = :ime, Tekst = :tekst, Lajkovi = :lajkovi, Dislajkovi = :dislajkovi WHERE idKomentar = :id";
        $stmt = $dbConnection->prepare($query);

        $stmt->bindValue(':id', $komentar->getIdKomentar(), PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deleteKomentar($dbConnection, $id) {
        $query = "DELETE FROM Komentar WHERE idKomentar = :id";
        $stmt = $dbConnection->prepare($query);
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
