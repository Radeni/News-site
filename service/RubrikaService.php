<?php
declare(strict_types=1);
require_once 'dao/RubrikaDAO.php';
class RubrikaService {
    private static $instance = null;
    private function __construct() {
        // Prevent instantiation
    }
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new RubrikaService();
        }
        return self::$instance;
    }

    public function getRubrikaById($id) {
        $connection = DBManager::getInstance()->getConnection();
        return RubrikaDAO::getInstance()->getRubrikaById($connection, $id);
    }
    
    public function getAllRubrikas() {
        $connection = DBManager::getInstance()->getConnection();
        return RubrikaDAO::getInstance()->getAllRubrikas($connection);
    }

    public function createRubrika(Rubrika $rubrika) {
        $connection = DBManager::getInstance()->getConnection();
        return RubrikaDAO::getInstance()->addRubrika($connection, $rubrika);
    }

    public function updateRubrika(Rubrika $rubrika) {
        $connection = DBManager::getInstance()->getConnection();
        return RubrikaDAO::getInstance()->updateRubrika($connection, $rubrika);
    }

    public function deleteRubrika($id) {
        $connection = DBManager::getInstance()->getConnection();
        return RubrikaDAO::getInstance()->deleteRubrika($connection, $id);
    }

    // Prevent cloning and unserialization
    private function __clone() { }
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}
