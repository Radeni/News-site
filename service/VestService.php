<?php
declare(strict_types=1);
require_once 'dao/VestDAO.php';
class VestService {
    private static $instance = null;
    private function __construct() {
        // Prevent instantiation
    }
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new VestService();
        }
        return self::$instance;
    }

    public function getVestById($id) {
        $connection = DBManager::getInstance()->getConnection();
        return VestDAO::getInstance()->getVestById($connection, $id);
    }

    public function createVest(Vest $vest) {
        $connection = DBManager::getInstance()->getConnection();
        return VestDAO::getInstance()->addVest($connection, $vest);
    }

    public function updateVest(Vest $vest) {
        $connection = DBManager::getInstance()->getConnection();
        return VestDAO::getInstance()->updateVest($connection, $vest);
    }

    public function deleteVest($id) {
        $connection = DBManager::getInstance()->getConnection();
        return VestDAO::getInstance()->deleteVest($connection, $id);
    }

    // Prevent cloning and unserialization
    private function __clone() { }
    public function __wakeup() { 
        throw new Exception("Cannot unserialize a singleton.");
    }
}
