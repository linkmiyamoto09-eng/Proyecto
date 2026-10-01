<?php
class User {
    private $conn;
    private $table = "Usuario";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($nombre, $email, $contrasena) {
        $query = "INSERT INTO " . $this->table . " (nombre, email, contrasena) VALUES (:nombre, :email, :contrasena)";
        $stmt = $this->conn->prepare($query);
        $hash = password_hash($contrasena, PASSWORD_BCRYPT);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":contrasena", $hash);
        return $stmt->execute();
    }

    public function login($email, $contrasena) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($contrasena, $user['contrasena'])) {
            return $user;
        }
        return false;
    }
}
?>
