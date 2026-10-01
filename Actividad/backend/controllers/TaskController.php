<?php
require_once '../conections/database.php';
require_once '../models/Task.php';

class TaskController {
    public static function handleRequest() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Asigna el usuario en sesión o el ID 1 por defecto para pruebas
        $userId = $_SESSION['user_id'] ?? 1;

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            echo json_encode(["status" => "error", "message" => "Error de conexión a la Base de Datos"]);
            return;
        }

        $task = new Task($db);
        $action = $_GET['action'] ?? '';
        
        // Lee los datos JSON enviados por JavaScript (fetch)
        $data = json_decode(file_get_contents("php://input"), true);

        if ($action === 'get') {
            $result = $task->getAllByUser($userId);
            echo json_encode($result ? $result : []);
            
        } elseif ($action === 'create') {
            if (!empty($data['titulo'])) {
                $titulo = $data['titulo'];
                $descripcion = $data['descripcion'] ?? '';
                $f_termino = !empty($data['f_termino']) ? $data['f_termino'] : null;
                $prioridad = $data['prioridad'] ?? 'Media';
                $categoria = $data['categoria'] ?? 'General';

                if ($task->create($userId, $titulo, $descripcion, $f_termino, $prioridad, $categoria)) {
                    echo json_encode(["status" => "success", "message" => "Tarea creada exitosamente"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "No se pudo insertar en la base de datos"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "El título es obligatorio"]);
            }
            
        } elseif ($action === 'delete') {
            if (!empty($data['id'])) {
                if ($task->delete($data['id'])) {
                    echo json_encode(["status" => "success"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "No se pudo eliminar"]);
                }
            }
        }
    }
}
?>