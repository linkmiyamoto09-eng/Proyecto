<?php
class Database {
    private $host = "127.0.0.1"; // Usa 127.0.0.1 en lugar de localhost para evitar retardos de conexión
    private $db_name = "task_manager";
    private $username = "root"; 
    private $password = "TU_CONTRASEÑA_DE_MYSQL_AQUI"; // <-- Pon tu contraseña de MySQL aquí
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(["status" => "error", "message" => "Error BD: " . $exception->getMessage()]);
            exit();
        }
        return $this->conn;
    }
}
?>