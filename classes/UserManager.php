<?php
declare(strict_types=1);

require_once 'functions/user_type.php';
class UserManager
{
    private $_db,
            $_data,
            $_sessionName,
            $_isLoggedIn,
            $_permissionLevel;

    public function __construct($user = null)
    {
        $this->_db = DB::getInstance();

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
    public function create($tip_korisnika, $fields = array(), $db = '')
    {
        if ($db == ''){
            $db = $this->_db;
        }
        if (!is_array($fields)) {
            throw new Exception('Pogresni podaci');
        }
        if (count($fields) < 2) {
            throw new Exception('Nedovoljno polja');
        }
        if (!in_array($tip_korisnika, array('urednik', 'novinar'))) {
            throw new Exception('Nepostojeci tip korisnika');
        }
        if (!$db->insert('user', array('tip' => $tip_db))) {
            throw new Exception('Desio se problem tokom kreiranja naloga.');
        }
        $id = $db->query('SELECT * FROM user ORDER BY idKorisnik DESC LIMIT 1')->first()->idKorisnik;
        $fields['idKorisnik'] = $id;
        if (!$db->insert($tip_korisnika, $fields)) {
            throw new Exception('Desio se problem tokom kreiranja naloga.');
        }
    }
    public function update($table, $fields = array(), $id = null)
    {
        if (!$id && $this->isLoggedIn()) {
            if ($table == 'korisnik') {
                $id = $this->data()->korisnik_id;
            }
            elseif ($table == 'admin') {
                $id = $this->data()->admin_id;
            }
            else {
                throw new Exception('Nepoznat tip korisnika');
            }
        }
        if (!$this->_db->updateUser($table, $id, $fields)) {
            throw new Exception('Desio se problem tokom azuriranja.');
        }
    }
    public function find($user = null)
    {
        if ($user) {
            // if user had a numeric username this FAILS...
            $data = '';
            if (is_numeric($user)) {
                $field = 'idKorisnik';
                $this->_permissionLevel = $this->_db->get('user', array($field, '=', $user))->results()[0]->Tip;
                if ($this->_permissionLevel == 1) {
                    $data = $this->_db->get('korisnik', array($field, '=', $user))->results();
                }
                if ($this->_permissionLevel == 2) {
                    $data = $this->_db->get('admin', array($field, '=', $user))->results();
                }
                if ($data) {
                    $this->_data = $data[0];
                    return true;
                }
            } else {
                $field = 'email';
                $korisnik = $this->_db->get('korisnik', array($field, '=', $user))->results();
                $admin = $this->_db->get('admin', array($field, '=', $user))->results();
            }
            if (!is_numeric($user) && $korisnik) {
                $this->_data = $korisnik[0];
                $this->_permissionLevel = 1;
                return true;
            }
            if (!is_numeric($user) && $admin) {
                $this->_data = $admin[0];
                $this->_permissionLevel = 2;
                return true;
            }//THIS WHOLE THING IS DUMB BUT IT WORKS
        }
        return false;
    }
    public function login($email = null, $password = null)
    {
        // check if username has been defined
        if (!$email && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->idKorisnik);
        } else {
            $user = $this->find($email);
            if ($user) {
                if (password_verify($password, $this->data()->password)) {
                    Session::put($this->_sessionName, $this->data()->idKorisnik);
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
    public function permissionLevel()
    {
        return $this->_permissionLevel;
    }
}