<?php
declare(strict_types=1);
class RubrikaDAO {
    private static $instance = null;
    private function __construct() {
        // Prevent instantiation
    }
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new RubrikaDAO();
        }
        return self::$instance;
    }

    public function getRubrikaById($dbConnection, $id) {
        $query = "SELECT * FROM Rubrika WHERE idRubrika = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Rubrika($row['idRubrika'], $row['Ime']);
        }

        return null;
    }

    public function addRubrika($dbConnection, Rubrika $rubrika) {
        $query = "INSERT INTO Rubrika (Ime) VALUES (:ime)";
        $stmt = $dbConnection->prepare($query);

        $stmt->bindValue(':ime', $rubrika->getIme(), PDO::PARAM_STR);

        $stmt->execute();
        return $dbConnection->lastInsertId();
    }

    public function updateRubrika($dbConnection, Rubrika $rubrika) {
        $query = "UPDATE Rubrika SET Ime = :ime WHERE idRubrika = :id";
        $stmt = $dbConnection->prepare($query);

        $stmt->bindValue(':id', $rubrika->getIdRubrika(), PDO::PARAM_INT);
        $stmt->bindValue(':ime', $rubrika->getIme(), PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deleteRubrika($dbConnection, $id) {
        $query = "DELETE FROM Rubrika WHERE idRubrika = :id";
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
