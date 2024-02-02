<?php
declare(strict_types=1);
class Vest {
    private $idVest;
    private $naslov;
    private $tekst;
    private $tagovi;
    private $datum;
    private $lajkovi;
    private $dislajkovi;
    private $status;
    private $idRubrika;

    // Constructor
    public function __construct($idVest, $naslov, $tekst, $tagovi, $datum, $lajkovi, $dislajkovi, $status, $idRubrika) {
        $this->idVest = $idVest;
        $this->naslov = $naslov;
        $this->tekst = $tekst;
        $this->tagovi = $tagovi;
        $this->datum = $datum;
        $this->lajkovi = $lajkovi;
        $this->dislajkovi = $dislajkovi;
        $this->status = $status;
        $this->idRubrika = $idRubrika;
    }

    // Getters and Setters
    public function getIdVest() {
        return $this->idVest;
    }

    public function getNaslov() {
        return $this->naslov;
    }

    public function getTekst() {
        return $this->tekst;
    }

    public function getTagovi() {
        return $this->tagovi;
    }

    public function getDatum() {
        return $this->datum;
    }

    public function getLajkovi() {
        return $this->lajkovi;
    }

    public function getDislajkovi() {
        return $this->dislajkovi;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getIdRubrika() {
        return $this->idRubrika;
    }

    public function setIdVest($idVest) {
        $this->idVest = $idVest;
    }

    public function setNaslov($naslov) {
        $this->naslov = $naslov;
    }

    public function setTekst($tekst) {
        $this->tekst = $tekst;
    }

    public function setTagovi($tagovi) {
        $this->tagovi = $tagovi;
    }

    public function setDatum($datum) {
        $this->datum = $datum;
    }

    public function setLajkovi($lajkovi) {
        $this->lajkovi = $lajkovi;
    }

    public function setDislajkovi($dislajkovi) {
        $this->dislajkovi = $dislajkovi;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setIdRubrika($idRubrika) {
        $this->idRubrika = $idRubrika;
    }
    
    public function toJson() {
        $data = [
            'idVest' => $this->idVest,
            'naslov' => $this->naslov,
            'tekst' => $this->tekst,
            'tagovi' => $this->tagovi,
            'datum' => $this->datum,
            'lajkovi' => $this->lajkovi,
            'dislajkovi' => $this->dislajkovi,
            'status' => $this->status,
            'idRubrika' => $this->idRubrika
        ];

        return json_encode($data);
    }
}
