<?php
class RubrikaDAO {
    private $dbConnection;
    private static $instance = null;
    private function __construct($dbConnection) {
        $this->dbConnection = $dbConnection;
    }
    public static function getInstance($dbConnection) {
        if (self::$instance === null) {
            self::$instance = new RubrikaDAO($dbConnection);
        }
        return self::$instance;
    }

    public function getRubrikaById($id) {
        $query = "SELECT * FROM Rubrika WHERE idRubrika = :id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Rubrika($row['idRubrika'], $row['Ime']);
        }

        return null;
    }

    public function addRubrika(Rubrika $rubrika) {
        $query = "INSERT INTO Rubrika (Ime) VALUES (:ime)";
        $stmt = $this->dbConnection->prepare($query);

        $stmt->bindValue(':ime', $rubrika->getIme(), PDO::PARAM_STR);

        $stmt->execute();
        return $this->dbConnection->lastInsertId();
    }

    public function updateRubrika(Rubrika $rubrika) {
        $query = "UPDATE Rubrika SET Ime = :ime WHERE idRubrika = :id";
        $stmt = $this->dbConnection->prepare($query);

        $stmt->bindValue(':id', $rubrika->getIdRubrika(), PDO::PARAM_INT);
        $stmt->bindValue(':ime', $rubrika->getIme(), PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deleteRubrika($id) {
        $query = "DELETE FROM Rubrika WHERE idRubrika = :id";
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
