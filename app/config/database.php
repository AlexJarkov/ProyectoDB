<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $host = 'localhost';
        $dbname = 'freelance_system';
        $user = 'root';
        $pass = '';

        try {
            $this->connection = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch(PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->connection; // devuelve PDO directamente
    }
}
?>
