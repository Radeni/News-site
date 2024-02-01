<?php
class User {
    private $idKorisnik;
    private $username;
    private $password;
    private $tip;

    // Constructor
    public function __construct($idKorisnik, $username, $password, $tip) {
        $this->idKorisnik = $idKorisnik;
        $this->username = $username;
        $this->password = $password;
        $this->tip = $tip;
    }

    // Getters and Setters
    public function getIdKorisnik() {
        return $this->idKorisnik;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getTip() {
        return $this->tip;
    }

    public function setIdKorisnik($idKorisnik) {
        $this->idKorisnik = $idKorisnik;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setTip($tip) {
        $this->tip = $tip;
    }

    // toJson method
    public function toJson() {
        $data = [
            'idKorisnik' => $this->idKorisnik,
            'username' => $this->username,
            'password' => $this->password, // Note: Be cautious about exposing passwords
            'tip' => $this->tip
        ];

        return json_encode($data);
    }
}
