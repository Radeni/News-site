<?php
declare(strict_types=1);

class DBManager
{
    private static $instance = null;
    private $pdo = null;

    private function __construct()
    {
        try {
            $this->pdo = new PDO(
                'mysql:host=' . Config::get('mysql/host') . 
                ';dbname=' . Config::get('mysql/db') . 
                ';port=' . Config::get('mysql/port'), 
                Config::get('mysql/username'), 
                Config::get('mysql/password')
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception("Database connection could not be established.");
        }
    }

    public static function getInstance(): DBManager
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    // Prevent cloning and unserialization of the instance
    private function __clone() { }

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }
}

