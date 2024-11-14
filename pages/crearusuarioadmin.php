<?php
// Configuración de conexión a la base de datos
$conexion = new mysqli("localhost", "root", "1234", "pixfood");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Crear el hash de la contraseña
$password = password_hash("admin", PASSWORD_DEFAULT);

// Insertar un usuario administrador
$sql = "INSERT INTO users (username, password, first_name, last_name, birth_date, role)
        VALUES ('admin', '$password', 'admin', 'admin', '200-02-14', 'admin')";

if ($conexion->query($sql) === TRUE) {
    echo "Usuario administrador creado exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}

$conexion->close();
?>