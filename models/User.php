<?php
include_once "../database/conexion.php";

class UserModel {
    private $conexion;

    public function __construct() {
        global $conexion;
        $this->conexion = $conexion;
    }

    public function getEmployees() {
        $stmt = $this->conexion->prepare("SELECT id, username, first_name, last_name, birth_date, role FROM users WHERE activo = TRUE");
        $stmt->execute();
        $result = $stmt->get_result();
        
        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }
        
        return $employees;
    }

    public function authenticateUser($username, $password) {
        $stmt = $this->conexion->prepare("SELECT id, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }

        return false;
    }

        // Función para eliminar un usuario lógicamente
    public function deleteUser($id) {
        $stmt = $this->conexion->prepare($query = "UPDATE users SET active = false WHERE id = :id "); // Asegurarse de que el usuario no haya sido eliminado ya
        $stmt->bindParam(':id', $id);
         if ($stmt->execute()) {            
            return true;
        } else {
            return false;
        }
    }

    public function createUser($username, $password, $firstName, $lastName, $birthDate, $role) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conexion->prepare("INSERT INTO users (username, password, first_name, last_name, birth_date, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $hashedPassword, $firstName, $lastName, $birthDate, $role);

        return $stmt->execute();
    }
}
