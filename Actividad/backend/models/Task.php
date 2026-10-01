<?php
class Task {
    private $conn;
    private $table = "Tarea";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllByUser($userId) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_creador = :id_creador ORDER BY f_termino ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_creador", $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($id_creador, $titulo, $descripcion, $f_termino, $prioridad, $categoria) {
        $query = "INSERT INTO " . $this->table . " (id_creador, titulo, descripcion, f_termino, prioridad, categoria) VALUES (:id_creador, :titulo, :descripcion, :f_termino, :prioridad, :categoria)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_creador", $id_creador);
        $stmt->bindParam(":titulo", $titulo);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":f_termino", $f_termino);
        $stmt->bindParam(":prioridad", $prioridad);
        $stmt->bindParam(":categoria", $categoria);
        return $stmt->execute();
    }

    public function updateStatus($id, $estado) {
        $query = "UPDATE " . $this->table . " SET estado = :estado WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":estado", $estado);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>