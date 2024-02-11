<?php
declare(strict_types=1);
class UserRubrikaDAO {
    private static $instance = null;

    private function __construct() {
        // Prevent instantiation
    }
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new UserRubrikaDAO();
        }
        return self::$instance;
    }

    public function addUserToRubrika($dbConnection, $idKorisnik, $idRubrika) {
        $query = "INSERT INTO UserRubrika (idKorisnik, idRubrika) VALUES (:idKorisnik, :idRubrika)";
        $stmt = $dbConnection->prepare($query);

        $stmt->bindValue(':idKorisnik', $idKorisnik, PDO::PARAM_INT);
        $stmt->bindValue(':idRubrika', $idRubrika, PDO::PARAM_INT);

        $stmt->execute();
        return $dbConnection->lastInsertId();
    }

    public function deleteUserFromRubrika($dbConnection, $idKorisnik, $idRubrika) {
        $query = "DELETE FROM UserRubrika WHERE idKorisnik = :idKorisnik AND idRubrika = :idRubrika";
        $stmt = $dbConnection->prepare($query);

        $stmt->bindValue(':idKorisnik', $idKorisnik, PDO::PARAM_INT);
        $stmt->bindValue(':idRubrika', $idRubrika, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount();
    }
    public function purgeUser($dbConnection, $idKorisnik) {
        $query = "DELETE FROM UserRubrika WHERE idKorisnik = :idKorisnik";
        $stmt = $dbConnection->prepare($query);

        $stmt->bindValue(':idKorisnik', $idKorisnik, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function getUserRubrikas($dbConnection, $idKorisnik) {
        $query = "SELECT * FROM UserRubrika WHERE idKorisnik = :idKorisnik";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':idKorisnik', $idKorisnik, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $userRubrikas = [];

        foreach ($rows as $row) {
            $userRubrikas[] = new UserRubrika(
                $row['idKorisnik'],
                $row['idRubrika']
            );
        }

        return $userRubrikas;
    }

    public function getAllUsersByRub($dbConnection, $idRubrika) {
        $query = "SELECT * FROM UserRubrika WHERE idRubrika = :idRubrika";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindValue(':idRubrika', $idRubrika, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $userRubrikasByRub = [];

        foreach ($rows as $row) {
            $userRubrikasByRub[] = new UserRubrika(
                $row['idKorisnik'],
                $row['idRubrika']
            );
        }

        return $userRubrikasByRub;
    }

    // Prevent cloning and unserialization
    private function __clone() { }
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}
