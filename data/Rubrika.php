<?php
declare(strict_types=1);
class Rubrika {
    private $idRubrika;
    private $ime;

    // Constructor
    public function __construct($idRubrika, $ime) {
        $this->idRubrika = $idRubrika;
        $this->ime = $ime;
    }

    // Getters and Setters
    public function getIdRubrika() {
        return $this->idRubrika;
    }

    public function getIme() {
        return $this->ime;
    }

    public function setIdRubrika($idRubrika) {
        $this->idRubrika = $idRubrika;
    }

    public function setIme($ime) {
        $this->ime = $ime;
    }

    // toJson method
    public function toJson() {
        $data = [
            'idRubrika' => $this->idRubrika,
            'ime' => $this->ime
        ];

        return json_encode($data);
    }
}
