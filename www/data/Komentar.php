<?php
declare(strict_types=1);
class Komentar {
    private $idKomentar;
    private $ime;
    private $tekst;
    private $lajkovi;
    private $dislajkovi;
    private $idVest;

    // Constructor
    public function __construct($idKomentar, $ime, $tekst, $lajkovi, $dislajkovi, $idVest) {
        $this->idKomentar = $idKomentar;
        $this->ime = $ime;
        $this->tekst = $tekst;
        $this->lajkovi = $lajkovi;
        $this->dislajkovi = $dislajkovi;
        $this->idVest = $idVest;
    }

    // Getters and Setters
    public function getIdKomentar() {
        return $this->idKomentar;
    }

    public function getIme() {
        return $this->ime;
    }

    public function getTekst() {
        return $this->tekst;
    }

    public function getLajkovi() {
        return $this->lajkovi;
    }

    public function getDislajkovi() {
        return $this->dislajkovi;
    }

    public function getIdVest() {
        return $this->idVest;
    }

    public function setIdKomentar($idKomentar) {
        $this->idKomentar = $idKomentar;
    }

    public function setIme($ime) {
        $this->ime = $ime;
    }

    public function setTekst($tekst) {
        $this->tekst = $tekst;
    }

    public function setLajkovi($lajkovi) {
        $this->lajkovi = $lajkovi;
    }

    public function setDislajkovi($dislajkovi) {
        $this->dislajkovi = $dislajkovi;
    }

    public function setIdVest($idVest) {
        $this->idVest = $idVest;
    }

    // toJson method
    public function toJson() {
        $data = [
            'idKomentar' => $this->idKomentar,
            'ime' => $this->ime,
            'tekst' => $this->tekst,
            'lajkovi' => $this->lajkovi,
            'dislajkovi' => $this->dislajkovi,
            'idVest' => $this->idVest
        ];

        return json_encode($data);
    }
}
