<?php
declare(strict_types=1);
class User {
    private $idKorisnik;
    private $username;
    private $password;
    private $ime;
    private $prezime;
    private $telefon;
    private $tip;

    // Constructor
    public function __construct($idKorisnik, $username, $password, $ime, $prezime, $telefon, $tip) {
        $this->idKorisnik = $idKorisnik;
        $this->username = $username;
        $this->password = $password;
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->telefon = $telefon;
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
    
    public function getIme() {
        return $this->ime;
    }

    public function getPrezime() {
        return $this->prezime;
    }

    public function getTelefon() {
        return $this->telefon;
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

    public function setIme($ime) {
        $this->ime = $ime;
    }

    public function setPrezime($prezime) {
        $this->prezime = $prezime;
    }

    public function setTelefon($telefon) {
        $this->telefon = $telefon;
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
