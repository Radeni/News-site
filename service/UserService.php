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
    public function getAllUsers() {
        $connection = DBManager::getInstance()->getConnection();
        return UserDAO::getInstance()->getAllUsers($connection);
    }
    public function getAllUsersBy($tip,$rub) {
        $connection = DBManager::getInstance()->getConnection();
        if ($tip == '' && $rub == '') {
            return UserDAO::getInstance()->getAllUsers($connection);
        } else if ($tip != '' && $rub == '') {
            return UserDAO::getInstance()->getAllUsersByType($connection, $tip);
        } else if ($tip == '' && $rub != '') {
            $userids = UserRubrikaDAO::getInstance()->getAllUsersByRub($connection, $rub);
            $users = array();
            foreach ($userids as $id) {
                array_push($users, UserDAO::getInstance()->getUserById($id));
            }
            return $users;
        } else {
            $userids = UserRubrikaDAO::getInstance()->getAllUsersByRub($connection, $rub);
            $users = array();
           
            foreach ($userids as $id) {
                $user = UserDAO::getInstance()->getUserById($id);
                $usertip = $user->getTip();
                if ($usertip == $tip) {
                    array_push($users, $user);
                }
            }
            return $users;
        }
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
