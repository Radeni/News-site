<?php
class UserRubrikaDAO {
    private $dbConnection;
    private static $instance = null;

    // Private constructor for Singleton pattern
    private function __construct($dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    // Method to get the Singleton instance of UserRubrikaDAO
    public static function getInstance($dbConnection) {
        if (self::$instance === null) {
            self::$instance = new UserRubrikaDAO($dbConnection);
        }
        return self::$instance;
    }

    public function addUserToRubrika($idKorisnik, $idRubrika) {
        $query = "INSERT INTO UserRubrika (idKorisnik, idRubrika) VALUES (:idKorisnik, :idRubrika)";
        $stmt = $this->dbConnection->prepare($query);

        $stmt->bindValue(':idKorisnik', $idKorisnik, PDO::PARAM_INT);
        $stmt->bindValue(':idRubrika', $idRubrika, PDO::PARAM_INT);

        $stmt->execute();
        return $this->dbConnection->lastInsertId();
    }

    public function deleteUserFromRubrika($idKorisnik, $idRubrika) {
        $query = "DELETE FROM UserRubrika WHERE idKorisnik = :idKorisnik AND idRubrika = :idRubrika";
        $stmt = $this->dbConnection->prepare($query);

        $stmt->bindValue(':idKorisnik', $idKorisnik, PDO::PARAM_INT);
        $stmt->bindValue(':idRubrika', $idRubrika, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function getUserRubrikas($idKorisnik) {
        $query = "SELECT * FROM UserRubrika WHERE idKorisnik = :idKorisnik";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindValue(':idKorisnik', $idKorisnik, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows; // Returns an array of associations
    }

    // Prevent cloning and unserialization
    private function __clone() { }
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}
