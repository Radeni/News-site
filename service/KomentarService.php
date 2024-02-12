<?php
declare(strict_types=1);
require_once 'dao/KomentarDAO.php';
class KomentarService {
    private static $instance = null;
    private function __construct() {
        // Prevent instantiation
    }
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new KomentarService();
        }
        return self::$instance;
    }

    public function getKomentarById($id) {
        $connection = DBManager::getInstance()->getConnection();
        return KomentarDAO::getInstance()->getKomentarById($connection, $id);
    }

    public function createKomentar(Komentar $komentar) {
        $connection = DBManager::getInstance()->getConnection();
        return KomentarDAO::getInstance()->addKomentar($connection, $komentar);
    }

    public function updateKomentar(Komentar $komentar) {
        $connection = DBManager::getInstance()->getConnection();
        return KomentarDAO::getInstance()->updateKomentar($connection, $komentar);
    }

    public function deleteKomentar($id) {
        $connection = DBManager::getInstance()->getConnection();
        return KomentarDAO::getInstance()->deleteKomentar($connection, $id);
    }

    // Prevent cloning and unserialization
    private function __clone() { }
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}
