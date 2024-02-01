<?php
class UserDAO {
    private $dbConnection;
    private static $instance = null;
    private function __construct($dbConnection) {
        $this->dbConnection = $dbConnection;
    }
    public static function getInstance($dbConnection) {
        if (self::$instance === null) {
            self::$instance = new UserDAO($dbConnection);
        }
        return self::$instance;
    }

    public function getUserById($id) {
        $query = "SELECT * FROM User WHERE idKorisnik = :id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new User($row['idKorisnik'], $row['Username'], $row['Password'], $row['Tip']);
        }

        return null;
    }

    public function addUser(User $user) {
        $query = "INSERT INTO User (Username, Password, Tip) VALUES (:username, :password, :tip)";
        $stmt = $this->dbConnection->prepare($query);

        $stmt->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $user->getPassword(), PDO::PARAM_STR); // Remember to hash passwords in real applications
        $stmt->bindValue(':tip', $user->getTip(), PDO::PARAM_STR);

        $stmt->execute();
        return $this->dbConnection->lastInsertId();
    }

    public function updateUser(User $user) {
        $query = "UPDATE User SET Username = :username, Password = :password, Tip = :tip WHERE idKorisnik = :id";
        $stmt = $this->dbConnection->prepare($query);

        $stmt->bindValue(':id', $user->getIdKorisnik(), PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deleteUser($id) {
        $query = "DELETE FROM User WHERE idKorisnik = :id";
        $stmt = $this->dbConnection->prepare($query);
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