<?php
declare(strict_types=1);
require_once 'dao/UserRubrikaDAO.php';
require_once 'dao/RubrikaDAO.php';
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
    public function purgeUser($idKorisnik) {
        $connection = DBManager::getInstance()->getConnection();
        return UserRubrikaDAO::getInstance()->purgeUser($connection, $idKorisnik);
    }

    public function getUserRubrikas($idKorisnik) {
        $connection = DBManager::getInstance()->getConnection();
        $userRubrikas =  UserRubrikaDAO::getInstance()->getUserRubrikas($connection, $idKorisnik);
        $rubrike = array();
        foreach ($userRubrikas as $userRubrika) {
            $rubrika = RubrikaDAO::getInstance()->getRubrikaById($connection, $userRubrika->getIdRubrika());
            array_push($rubrike, $rubrika);
        }
        return $rubrike;
    }
    public function userInRubrika($idKorisnik, $idRubrika) {
        $connection = DBManager::getInstance()->getConnection();
        $rubrikas =  UserRubrikaDAO::getInstance()->getUserRubrikas($connection, $idKorisnik);
        foreach ($rubrikas as $rubrika) {
            if ($rubrika->getIdRubrika() == $idRubrika) {
                return true;
             }
        }
        return false;
    }
    // Prevent cloning and unserialization
    private function __clone() { }
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}
