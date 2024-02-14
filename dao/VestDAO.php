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
    public function getAll($dbConnection) {
        $query = "SELECT * FROM Vest";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $vesti = array();
        foreach ($rows as $row) {
           array_push($vesti, new Vest($row['idVest'], $row['Naslov'], $row['Tekst'], $row['Tagovi'], $row['Datum'], $row['Lajkovi'], $row['Dislajkovi'], $row['Status'], $row['idRubrika'], $row['idKorisnik']));
        }
        return $vesti;
    }
    public function getArticlesByPage($dbConnection, $page, $articlesPerPage) {
        // Calculate offset based on the current page and articles per page
        $offset = ($page - 1) * $articlesPerPage;
        
        // SQL query with LIMIT and OFFSET
        $query = "SELECT * FROM Vest LIMIT :limit OFFSET :offset";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':limit', $articlesPerPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        // Fetch articles
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $vesti = array();
        foreach ($rows as $row) {
            array_push($vesti, new Vest($row['idVest'], $row['Naslov'], $row['Tekst'], $row['Tagovi'], $row['Datum'], $row['Lajkovi'], $row['Dislajkovi'], $row['Status'], $row['idRubrika'], $row['idKorisnik']));
        }
        return $vesti;
    }
    public function getArticlesByPageFromKorisnik($dbConnection, $page, $articlesPerPage, $id) {
        $offset = ($page - 1) * $articlesPerPage;
        
        $query = "SELECT * FROM Vest WHERE idKorisnik=:id LIMIT :limit OFFSET :offset";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $articlesPerPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $vesti = array();
        foreach ($rows as $row) {
            array_push($vesti, new Vest($row['idVest'], $row['Naslov'], $row['Tekst'], $row['Tagovi'], $row['Datum'], $row['Lajkovi'], $row['Dislajkovi'], $row['Status'], $row['idRubrika'], $row['idKorisnik']));
        }
        return $vesti;
    }
    public function getArticlesByPageFromRubrika($dbConnection, $page, $articlesPerPage, $id) {
        $offset = ($page - 1) * $articlesPerPage;
        
        $query = "SELECT * FROM Vest WHERE idRubrika=:id LIMIT :limit OFFSET :offset";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $articlesPerPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $vesti = array();
        foreach ($rows as $row) {
            array_push($vesti, new Vest($row['idVest'], $row['Naslov'], $row['Tekst'], $row['Tagovi'], $row['Datum'], $row['Lajkovi'], $row['Dislajkovi'], $row['Status'], $row['idRubrika'], $row['idKorisnik']));
        }
        return $vesti;
    }
    public function getAllFromKorisnik($dbConnection, $id) {
        $query = "SELECT * FROM Vest WHERE idKorisnik=:id";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $vesti = array();
        foreach ($rows as $row) {
           array_push($vesti, new Vest($row['idVest'], $row['Naslov'], $row['Tekst'], $row['Tagovi'], $row['Datum'], $row['Lajkovi'], $row['Dislajkovi'], $row['Status'], $row['idRubrika'], $row['idKorisnik']));
        }
        return $vesti;
    }
    public function getAllFromRubrika($dbConnection, $id) {
        $query = "SELECT * FROM Vest WHERE idRubrika=:id";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $vesti = array();
        foreach ($rows as $row) {
           array_push($vesti, new Vest($row['idVest'], $row['Naslov'], $row['Tekst'], $row['Tagovi'], $row['Datum'], $row['Lajkovi'], $row['Dislajkovi'], $row['Status'], $row['idRubrika'], $row['idKorisnik']));
        }
        return $vesti;
    }
    public function countAll($dbConnection) {
        $query = "SELECT COUNT(*) FROM Vest";
        $stmt = $dbConnection->prepare($query);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_DEFAULT);
        return $count['COUNT(*)'];
    }
    public function countAllFromKorisnik($dbConnection, $id) {
        $query = "SELECT COUNT(*) FROM Vest WHERE idKorisnik=:id";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_DEFAULT);
        
        return $count['COUNT(*)'];
    }
    public function countAllFromRubrika($dbConnection, $id) {
        $query = "SELECT COUNT(*) FROM Vest WHERE idRubrika=:id";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_DEFAULT);
        
        return $count['COUNT(*)'];
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
