<?php
require_once __DIR__ . '/../conections/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public static function handleRequest() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $database = new Database();
        $db = $database->getConnection();

        if (!$db) {
            echo json_encode(["status" => "error", "message" => "Error de conexión a la Base de Datos"]);
            return;
        }

        $user = new User($db);
        $action = $_GET['action'] ?? '';
        $data = json_decode(file_get_contents("php://input"), true);

        if ($action === 'register') {
            if (!empty($data['nombre']) && !empty($data['email']) && !empty($data['contrasena'])) {
                if ($user->register($data['nombre'], $data['email'], $data['contrasena'])) {
                    echo json_encode(["status" => "success", "message" => "Usuario registrado correctamente"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "El correo ya está registrado o falló el registro"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios"]);
            }
        } elseif ($action === 'login') {
            if (!empty($data['email']) && !empty($data['contrasena'])) {
                $loggedInUser = $user->login($data['email'], $data['contrasena']);
                if ($loggedInUser) {
                    $_SESSION['user_id'] = $loggedInUser['id'];
                    $_SESSION['user_nombre'] = $loggedInUser['nombre'];
                    echo json_encode(["status" => "success", "message" => "Inicio de sesión exitoso"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Credenciales incorrectas"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios"]);
            }
        }
    }
}
?>