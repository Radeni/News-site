<?php
declare(strict_types=1);
class UserRubrikaService {
    private $userRubrikaDAO;
    private static $instance = null;

    private function __construct($dbConnection) {
        $this->userRubrikaDAO = UserRubrikaDAO::getInstance($dbConnection);
    }

    public static function getInstance($dbConnection) {
        if (self::$instance === null) {
            self::$instance = new UserRubrikaService($dbConnection);
        }
        return self::$instance;
    }

    public function addUserToRubrika($idKorisnik, $idRubrika) {
        return $this->userRubrikaDAO->addUserToRubrika($idKorisnik, $idRubrika);
    }

    public function deleteUserFromRubrika($idKorisnik, $idRubrika) {
        return $this->userRubrikaDAO->deleteUserFromRubrika($idKorisnik, $idRubrika);
    }

    public function getUserRubrikas($idKorisnik) {
        return $this->userRubrikaDAO->getUserRubrikas($idKorisnik);
    }

    // Prevent cloning and unserialization
    private function __clone() { }
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}
