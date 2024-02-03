<?php
declare(strict_types=1);
require_once 'dao/UserDAO.php';
class UserService {
    private static $instance = null;
    private function __construct() {
        // Prevent instantiation
    }
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new UserService();
        }
        return self::$instance;
    }

    public function getUserById($id) {
        $connection = DBManager::getInstance()->getConnection();
        return UserDAO::getInstance()->getUserById($connection, $id);
    }

    public function getUserByUsername($username) {
        $connection = DBManager::getInstance()->getConnection();
        return UserDAO::getInstance()->getUserByUsername($connection, $username);
    }

    public function registerUser(User $user) {
        $connection = DBManager::getInstance()->getConnection();
        return UserDAO::getInstance()->addUser($connection, $user);
    }

    public function updateUser(User $user) {
        $connection = DBManager::getInstance()->getConnection();
        return UserDAO::getInstance()->updateUser($connection, $user);
    }

    public function deleteUser($id) {
        $connection = DBManager::getInstance()->getConnection();
        return UserDAO::getInstance()->deleteUser($connection, $id);
    }
    public function loginUser($username, $password) {
        $connection = DBManager::getInstance()->getConnection();
        return UserDAO::getInstance()->loginUser($connection, $username, $password);
    }
    // Prevent cloning and unserialization
    private function __clone() { }
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}
