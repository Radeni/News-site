<?php
declare(strict_types=1);
class UserService {
    private $userDAO;
    private static $instance = null;

    private function __construct($dbConnection) {
        $this->userDAO = UserDAO::getInstance($dbConnection);
    }

    public static function getInstance($dbConnection) {
        if (self::$instance === null) {
            self::$instance = new UserService($dbConnection);
        }
        return self::$instance;
    }

    public function getUserById($id) {
        return $this->userDAO->getUserById($id);
    }

    public function getUserByUsername($username) {
        return $this->userDAO->getUserByUsername($username);
    }

    public function createUser($username, $password, $tip) {
        $user = new User(null, $username, $password, $tip);
        return $this->userDAO->addUser($user);
    }

    public function updateUser($idKorisnik, $username, $password, $tip) {
        $user = new User($idKorisnik, $username, $password, $tip);
        return $this->userDAO->updateUser($user);
    }

    public function deleteUser($id) {
        return $this->userDAO->deleteUser($id);
    }
    public function loginUser($username, $password) {
        return $this->userDAO->loginUser($username, $password);
    }
    // Prevent cloning and unserialization
    private function __clone() { }
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}
