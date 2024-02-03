<?php
declare(strict_types=1);
require_once 'dao/UserRubrikaDAO.php';
class UserRubrikaService {
    private static $instance = null;
    private function __construct() {
        // Prevent instantiation
    }
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new UserRubrikaService();
        }
        return self::$instance;
    }

    public function addUserToRubrika($idKorisnik, $idRubrika) {
        $connection = DBManager::getInstance()->getConnection();
        return UserRubrikaDAO::getInstance()->addUserToRubrika($connection, $idKorisnik, $idRubrika);
    }

    public function deleteUserFromRubrika($idKorisnik, $idRubrika) {
        $connection = DBManager::getInstance()->getConnection();
        return UserRubrikaDAO::getInstance()->deleteUserFromRubrika($connection, $idKorisnik, $idRubrika);
    }

    public function getUserRubrikas($idKorisnik) {
        $connection = DBManager::getInstance()->getConnection();
        return UserRubrikaDAO::getInstance()->getUserRubrikas($connection, $idKorisnik);
    }

    // Prevent cloning and unserialization
    private function __clone() { }
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}
