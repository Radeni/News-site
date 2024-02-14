<?php
declare(strict_types=1);
class UserRubrika {
    private $idKorisnik;
    private $idRubrika;

    // Constructor
    public function __construct($idKorisnik, $idRubrika) {
        $this->idKorisnik = $idKorisnik;
        $this->idRubrika = $idRubrika;
    }

    // Getters and Setters
    public function getIdKorisnik() {
        return $this->idKorisnik;
    }

    public function getIdRubrika() {
        return $this->idRubrika;
    }

    public function setIdKorisnik($idKorisnik) {
        $this->idKorisnik = $idKorisnik;
    }

    public function setIdRubrika($idRubrika) {
        $this->idRubrika = $idRubrika;
    }

    // toJson method
    public function toJson() {
        $data = [
            'idKorisnik' => $this->idKorisnik,
            'idRubrika' => $this->idRubrika
        ];

        return json_encode($data);
    }
}
