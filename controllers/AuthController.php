<?php
session_start();
require_once "../models/User.php"; 

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

$userModel = new UserModel();

if ($user = $userModel->authenticateUser($username, $password)) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['username'] = $username;

    echo json_encode(["success" => true, "message" => "Inicio de sesión exitoso"]);
} else {
    echo json_encode(["success" => false, "message" => "Usuario o contraseña incorrectos"]);
}
?>
