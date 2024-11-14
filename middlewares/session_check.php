<?php
session_start();

function checkSession() {
    // Verifica si las variables de sesión de autenticación están configuradas
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
        // Si no están configuradas, redirige al usuario a la página de inicio de sesión
        echo "<script>
        alert('Acceso denegado');
        window.location.href = '../admin/admin.php';
    </script>";
        exit();
    }
}

function checkAdminRole() {
if ($_SESSION['role'] !== 'admin') {
    echo "<script>
        alert('Se requiere inicio de sension');
        window.location.href = '../admin/admin.php';
    </script>";
    exit();
}
}
?>