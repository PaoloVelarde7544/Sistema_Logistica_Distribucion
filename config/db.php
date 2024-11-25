<?php

class Database {
    private $host = "localhost"; // Servidor donde está PostgreSQL
    private $db_name = "logisticadistribucion"; // Nombre de la base de datos en PostgreSQL
    private $username = "postgres"; // Usuario de PostgreSQL
    private $password = "10330239"; // Contraseña de PostgreSQL
    public $conn;
   
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("pgsql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
    
}

/*class Database {
    private $host = "localhost";
    private $db_name = "logisticadistribucion";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}*/
?>
