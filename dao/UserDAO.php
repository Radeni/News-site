<?php
declare(strict_types=1);
require_once 'data/User.php';
class UserDAO {
    private static $instance = null;
    private function __construct() {
        // Prevent instantiation
    }
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new UserDAO();
        }
        return self::$instance;
    }

    public function getUserById($dbConnection, $id) {
        $query = "SELECT * FROM User WHERE idKorisnik = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new User($row['idKorisnik'], $row['Username'], $row['Password'], $row['Ime'],$row['Prezime'],$row['Telefon'], $row['Tip']);
        }

        return null;
    }

    public function getUserByUsername($dbConnection, $username) {
        $query = "SELECT * FROM User WHERE Username = :username";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new User($row['idKorisnik'], $row['Username'], $row['Password'], $row['Ime'],$row['Prezime'],$row['Telefon'], $row['Tip']);
        }

        return null;
    }

    public function loginUser($dbConnection, $username, $password) {
        $query = "SELECT * FROM User WHERE Username = :username";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && password_verify($password, $row['Password'])) {
            return new User($row['idKorisnik'], $row['Username'], $row['Password'], $row['Ime'],$row['Prezime'],$row['Telefon'], $row['Tip']);
        }

        return null;
    }

    public function addUser($dbConnection, User $user) {
        $query = "INSERT INTO User (Username, Password, Ime, Prezime, Telefon, Tip) VALUES (:username, :password, :ime, :prezime, :telefon, :tip)";
        $stmt = $dbConnection->prepare($query);

        $stmt->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash($user->getPassword(), PASSWORD_BCRYPT), PDO::PARAM_STR);
        $stmt->bindValue(':ime', $user->getIme(), PDO::PARAM_STR);
        $stmt->bindValue(':prezime', $user->getPrezime(), PDO::PARAM_STR);
        $stmt->bindValue(':telefon', $user->getTelefon(), PDO::PARAM_STR);
        $stmt->bindValue(':tip', $user->getTip(), PDO::PARAM_STR);

        $stmt->execute();
        return $dbConnection->lastInsertId();
    }

    public function updateUser($dbConnection, User $user) {
        $query = "UPDATE User SET Username = :username, Password = :password, Tip = :tip WHERE idKorisnik = :id";
        $stmt = $dbConnection->prepare($query);

        $stmt->bindValue(':id', $user->getIdKorisnik(), PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deleteUser($dbConnection, $id) {
        $query = "DELETE FROM User WHERE idKorisnik = :id";
        $stmt = $dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount();
    }

    // Prevent cloning and unserialization
    private function __clone() { }
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}
