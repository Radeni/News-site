<?php
class VestDAO {
    private static $instance = null;
    private $dbConnection;

    private function __construct($dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    public static function getInstance($dbConnection) {
        if (self::$instance === null) {
            self::$instance = new VestDAO($dbConnection);
        }
        return self::$instance;
    }

    public function getVestById($id) {
        $query = "SELECT * FROM Vest WHERE idVest = :id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Vest($row['idVest'], $row['Naslov'], $row['Tekst'], $row['Tagovi'], $row['Datum'], $row['Lajkovi'], $row['Dislajkovi'], $row['Status'], $row['idRubrika']);
        }

        return null;
    }

    public function addVest(Vest $vest) {
        $query = "INSERT INTO Vest (Naslov, Tekst, Tagovi, Datum, Lajkovi, Dislajkovi, Status, idRubrika) VALUES (:naslov, :tekst, :tagovi, :datum, :lajkovi, :dislajkovi, :status, :idRubrika)";
        $stmt = $this->dbConnection->prepare($query);
    
        // Bind values with explicit data types
        $stmt->bindValue(':naslov', $vest->getNaslov(), PDO::PARAM_STR);
        $stmt->bindValue(':tekst', $vest->getTekst(), PDO::PARAM_STR);
        $stmt->bindValue(':tagovi', $vest->getTagovi(), PDO::PARAM_STR);
        $stmt->bindValue(':datum', $vest->getDatum(), PDO::PARAM_STR);
        $stmt->bindValue(':lajkovi', $vest->getLajkovi(), PDO::PARAM_INT);
        $stmt->bindValue(':dislajkovi', $vest->getDislajkovi(), PDO::PARAM_INT);
        $stmt->bindValue(':status', $vest->getStatus(), PDO::PARAM_STR);
        $stmt->bindValue(':idRubrika', $vest->getIdRubrika(), PDO::PARAM_INT);
    
        $stmt->execute();
        return $this->dbConnection->lastInsertId();
    }
    

    public function updateVest(Vest $vest) {
        $query = "UPDATE Vest SET Naslov = :naslov, Tekst = :tekst, Tagovi = :tagovi, Datum = :datum, Lajkovi = :lajkovi, Dislajkovi = :dislajkovi, Status = :status WHERE idVest = :id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindValue(':id', $vest->getIdVest());

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deleteVest($id) {
        $query = "DELETE FROM Vest WHERE idVest = :id";
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
