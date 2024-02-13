<?php
declare(strict_types=1);
require_once 'data/Vest.php';
class VestDAO {
    private static $instance = null;
    private function __construct() {
        // Prevent instantiation
    }
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new VestDAO();
        }
        return self::$instance;
    }

    public function getVestById($dbConnection, $id) {
        $query = "SELECT * FROM Vest WHERE idVest = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Vest($row['idVest'], $row['Naslov'], $row['Tekst'], $row['Tagovi'], $row['Datum'], $row['Lajkovi'], $row['Dislajkovi'], $row['Status'], $row['idRubrika'], $row['idKorisnik']);
        }

        return null;
    }

    public function addVest($dbConnection, Vest $vest) {
        $query = "INSERT INTO Vest (Naslov, Tekst, Tagovi, Datum, Lajkovi, Dislajkovi, Status, idRubrika, idKorisnik) VALUES (:naslov, :tekst, :tagovi, :datum, :lajkovi, :dislajkovi, :status, :idRubrika, :idKorisnik)";
        $stmt = $dbConnection->prepare($query);

        $stmt->bindValue(':naslov', $vest->getNaslov(), PDO::PARAM_STR);
        $stmt->bindValue(':tekst', $vest->getTekst(), PDO::PARAM_STR);
        $stmt->bindValue(':tagovi', $vest->getTagovi(), PDO::PARAM_STR);
        $stmt->bindValue(':datum', $vest->getDatum(), PDO::PARAM_STR);
        $stmt->bindValue(':lajkovi', $vest->getLajkovi(), PDO::PARAM_INT);
        $stmt->bindValue(':dislajkovi', $vest->getDislajkovi(), PDO::PARAM_INT);
        $stmt->bindValue(':status', $vest->getStatus(), PDO::PARAM_STR);
        $stmt->bindValue(':idRubrika', $vest->getIdRubrika(), PDO::PARAM_INT);
        $stmt->bindValue(':idKorisnik', $vest->getIdKorisnik(), PDO::PARAM_INT);
        $stmt->execute();
        return $dbConnection->lastInsertId();
    }
    

    public function updateVest($dbConnection, Vest $vest) {
        $query = "UPDATE Vest SET Naslov = :naslov, Tekst = :tekst, Tagovi = :tagovi, Datum = :datum, Lajkovi = :lajkovi, Dislajkovi = :dislajkovi, Status = :status, idRubrika = :idRubrika, idKorisnik = :idKorisnik WHERE idVest = :id";
        $stmt = $dbConnection->prepare($query);

        $stmt->bindValue(':id', $vest->getIdVest());
        $stmt->bindValue(':naslov', $vest->getNaslov(), PDO::PARAM_STR);
        $stmt->bindValue(':tekst', $vest->getTekst(), PDO::PARAM_STR);
        $stmt->bindValue(':tagovi', $vest->getTagovi(), PDO::PARAM_STR);
        $stmt->bindValue(':datum', $vest->getDatum(), PDO::PARAM_STR);
        $stmt->bindValue(':lajkovi', $vest->getLajkovi(), PDO::PARAM_INT);
        $stmt->bindValue(':dislajkovi', $vest->getDislajkovi(), PDO::PARAM_INT);
        $stmt->bindValue(':status', $vest->getStatus(), PDO::PARAM_STR);
        $stmt->bindValue(':idRubrika', $vest->getIdRubrika(), PDO::PARAM_INT);
        $stmt->bindValue(':idKorisnik', $vest->getIdKorisnik(), PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deleteVest($dbConnection, $id) {
        $query = "DELETE FROM Vest WHERE idVest = :id";
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
