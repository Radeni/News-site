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
    public function getAllKomentariByVestId($vest_id) {
        $connection = DBManager::getInstance()->getConnection();
        return KomentarDAO::getInstance()->getAllKomentariByVestId($connection, $vest_id);
    }

    public function likeKomentar($komentar_id) {
        $komentar = self::getKomentarById($komentar_id);
        $komentar->setLajkovi($komentar->getLajkovi() + 1);
        return self::updateKomentar($komentar);
    }
    public function unLikeKomentar($komentar_id) {
        $komentar = self::getKomentarById($komentar_id);
        $komentar->setLajkovi($komentar->getLajkovi() - 1);
        return self::updateKomentar($komentar);
    }
    public function dislikeKomentar($komentar_id) {
        $komentar = self::getKomentarById($komentar_id);
        $komentar->setDislajkovi($komentar->getDislajkovi() + 1);
        return self::updateKomentar($komentar);
    }
    public function unDislikeKomentar($komentar_id) {
        $komentar = self::getKomentarById($komentar_id);
        $komentar->setDislajkovi($komentar->getDislajkovi() - 1);
        return self::updateKomentar($komentar);
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
