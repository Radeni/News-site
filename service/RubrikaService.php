<?php
class RubrikaService {
    private $rubrikaDAO;
    private static $instance = null;

    private function __construct($dbConnection) {
        $this->rubrikaDAO = RubrikaDAO::getInstance($dbConnection);
    }

    public static function getInstance($dbConnection) {
        if (self::$instance === null) {
            self::$instance = new RubrikaService($dbConnection);
        }
        return self::$instance;
    }

    public function getRubrikaById($id) {
        return $this->rubrikaDAO->getRubrikaById($id);
    }

    public function createRubrika($ime) {
        $rubrika = new Rubrika(null, $ime);
        return $this->rubrikaDAO->addRubrika($rubrika);
    }

    public function updateRubrika($idRubrika, $ime) {
        $rubrika = new Rubrika($idRubrika, $ime);
        return $this->rubrikaDAO->updateRubrika($rubrika);
    }

    public function deleteRubrika($id) {
        return $this->rubrikaDAO->deleteRubrika($id);
    }

    // Prevent cloning and unserialization
    private function __clone() { }
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}
