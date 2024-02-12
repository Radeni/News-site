<?php
declare(strict_types=1);
require_once 'dao/UserDAO.php';
require_once 'dao/UserRubrikaDAO.php';
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
        $return_value = null;
        $connection = DBManager::getInstance()->getConnection();
        if ($tip == '' && $rub == '') {
            $return_value =  UserDAO::getInstance()->getAllUsers($connection);
        } else if ($tip != '' && $rub == '') {
            $return_value = UserDAO::getInstance()->getAllUsersByType($connection, $tip);
        } else if ($tip == '' && $rub != '') {
            $userids = UserRubrikaDAO::getInstance()->getAllUsersByRub($connection, $rub);
            $users = array();
            foreach ($userids as $id) {
                array_push($users, UserDAO::getInstance()->getUserById($connection, $id));
            }
            $return_value = $users;
        } else {
            $userids = UserRubrikaDAO::getInstance()->getAllUsersByRub($connection, $rub);
            $users = array();
           
            foreach ($userids as $id) {
                $user = UserDAO::getInstance()->getUserById($connection, $id);
                $usertip = $user->getTip();
                if ($usertip == $tip) {
                    array_push($users, $user);
                }
            }
            $return_value = $users;
        }
        return $return_value;
    }
    public function getUserByUsername($username) {
        $connection = DBManager::getInstance()->getConnection();
        return UserDAO::getInstance()->getUserByUsername($connection, $username);
    }

    public function registerUser(User $user) {
        if (!$user) {
            throw new Exception('Pogresni podaci');
        }
        if (!in_array($user->getTip(), array('urednik', 'novinar'))) {
            throw new Exception('Nepostojeci tip korisnika');
        }
        $connection = DBManager::getInstance()->getConnection();
        $user_id = UserDAO::getInstance()->addUser($connection, $user);
        if (!$user_id) {
            throw new Exception('Desio se problem prilikom kreiranja naloga!');
        }
        return $user_id;
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
