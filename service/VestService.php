<?php
class VestService {
    private $vestDAO;
    private static $instance = null;
    private function __construct($dbConnection) {
        $this->vestDAO = VestDAO::getInstance($dbConnection);
    }
    public static function getInstance($dbConnection) {
        if (self::$instance === null) {
            self::$instance = new VestService($dbConnection);
        }
        return self::$instance;
    }

    public function getVestById($id) {
        return $this->vestDAO->getVestById($id);
    }

    public function createVest($naslov, $tekst, $tagovi, $datum, $lajkovi, $dislajkovi, $status, $idRubrika) {
        $vest = new Vest(null, $naslov, $tekst, $tagovi, $datum, $lajkovi, $dislajkovi, $status, $idRubrika);
        return $this->vestDAO->addVest($vest);
    }

    public function updateVest($idVest, $naslov, $tekst, $tagovi, $datum, $lajkovi, $dislajkovi, $status, $idRubrika) {
        $vest = new Vest($idVest, $naslov, $tekst, $tagovi, $datum, $lajkovi, $dislajkovi, $status, $idRubrika);
        return $this->vestDAO->updateVest($vest);
    }

    public function deleteVest($id) {
        return $this->vestDAO->deleteVest($id);
    }

    // Prevent cloning and unserialization
    private function __clone() { }
    public function __wakeup() { 
        throw new Exception("Cannot unserialize a singleton.");
    }
}
