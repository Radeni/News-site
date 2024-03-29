<?php
declare(strict_types=1);

require_once 'service/UserService.php';
class UserManager
{
    private $_data,
            $_sessionName,
            $_isLoggedIn;

    public function __construct($user = null)
    {
        $this->_sessionName = Config::get('session/session_name');

        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);
                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    $this->logout();
                }
            }
        } else {
            $this->find($user);
        }
    }
    public function update(User $user)
    {
        if (!in_array($user->getTip(), array('urednik', 'novinar'))) {
            throw new Exception('Nepostojeci tip korisnika');
        }
        UserService::getInstance()->updateUser($user);
    }
    public function find($username = null)
    {
        if ($username) {
            $userService = UserService::getInstance();
            $user = $userService->getUserByUsername($username);
            if(!$user) {
                return false;
            }
            $this->_data = $user;
            return true;
        }
        return false;
    }
    public function login($username = null, $password = null)
    {
        // check if username has been defined
        if (!$username && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->username);
        } else {
            $user = $this->find($username);
            if ($user) {
                if (password_verify($password, $this->data()->getPassword())) {
                    Session::put($this->_sessionName, $this->data()->getUsername());
                    $this->_isLoggedIn = true;
                    return true;
                }
            }
        }
        return false;
    }
    public function exists()
    {
        return (!empty($this->_data)) ? true : false;
    }
    public function logout()
    {
        $this->_isLoggedIn = false;
        $this->_data = null;
        Session::delete($this->_sessionName);
    }
    public function data()
    {
        return $this->_data;
    }
    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }
}
