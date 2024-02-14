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
    public function getAll() {
        $connection = DBManager::getInstance()->getConnection();
        return VestDAO::getInstance()->getAll($connection);
    }
    public function getArticlesByPage($page, $articlesPerPage) {
        $connection = DBManager::getInstance()->getConnection();
        return VestDAO::getInstance()->getArticlesByPage($connection ,$page, $articlesPerPage);
    }
    public function getAllFromKorisnik($id_korisnik) {
        $connection = DBManager::getInstance()->getConnection();
        return VestDAO::getInstance()->getAllFromKorisnik($connection, $id_korisnik);
    }
    public function getAllFromRubrika($id_rub) {
        $connection = DBManager::getInstance()->getConnection();
        return VestDAO::getInstance()->getAllFromRubrika($connection, $id_rub);
    }
    public function countAll() {
        $connection = DBManager::getInstance()->getConnection();
        return VestDAO::getInstance()->countAll($connection);
    }
    public function countAllFromKorisnik($id_korisnik) {
        $connection = DBManager::getInstance()->getConnection();
        return VestDAO::getInstance()->countAllFromKorisnik($connection, $id_korisnik);
    }
    public function countAllFromRubrika($id_rub) {
        $connection = DBManager::getInstance()->getConnection();
        return VestDAO::getInstance()->countAllFromRubrika($connection, $id_rub);
    }

    public function createVest(Vest $vest) {
        $connection = DBManager::getInstance()->getConnection();
        return VestDAO::getInstance()->addVest($connection, $vest);
    }
    public function likeVest($vest_id) {
        $vest = self::getVestById($vest_id);
        $vest->setLajkovi($vest->getLajkovi() + 1);
        return self::updateVest($vest);
    }
    public function unLikeVest($vest_id) {
        $vest = self::getVestById($vest_id);
        $vest->setLajkovi($vest->getLajkovi() - 1);
        return self::updateVest($vest);
    }
    public function dislikeVest($vest_id) {
        $vest = self::getVestById($vest_id);
        $vest->setDislajkovi($vest->getDislajkovi() + 1);
        return self::updateVest($vest);
    }
    public function unDislikeVest($vest_id) {
        $vest = self::getVestById($vest_id);
        $vest->setDislajkovi($vest->getDislajkovi() - 1);
        return self::updateVest($vest);
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
