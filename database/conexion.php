<?php
//$conexion = new mysqli("fra1.clusters.zeabur.com", "root", "3SRdH0ge6JQz21tCG7mXbkVq4O9ov85u", "pixfood", 32005);
$conexion = new mysqli("localhost", "root", "1234", "pixfood");


// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");
?>