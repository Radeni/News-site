<?php
declare(strict_types=1);
class KomentarService {
    private $komentarDAO;
    private static $instance = null;

    private function __construct($dbConnection) {
        $this->komentarDAO = KomentarDAO::getInstance($dbConnection);
    }

    public static function getInstance($dbConnection) {
        if (self::$instance === null) {
            self::$instance = new KomentarService($dbConnection);
        }
        return self::$instance;
    }

    public function getKomentarById($id) {
        return $this->komentarDAO->getKomentarById($id);
    }

    public function createKomentar($ime, $tekst, $lajkovi, $dislajkovi, $idVest) { 
        $komentar = new Komentar(null, $ime, $tekst, $lajkovi, $dislajkovi, $idVest);
        return $this->komentarDAO->addKomentar($komentar);
    }

    public function updateKomentar($idKomentar, $ime, $tekst, $lajkovi, $dislajkovi, $idVest) {
        $komentar = new Komentar($idKomentar, $ime, $tekst, $lajkovi, $dislajkovi, $idVest);
        return $this->komentarDAO->updateKomentar($komentar);
    }

    public function deleteKomentar($id) {
        return $this->komentarDAO->deleteKomentar($id);
    }

    // Prevent cloning and unserialization
    private function __clone() { }
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}
