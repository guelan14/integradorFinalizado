<?php
session_start();

// Elimina todas las variables de sesión
$_SESSION = [];

// Destruye la sesión
session_destroy();

echo "<script>
alert('Sesion cerrada');
window.location.href = '../pages/admin/admin.php';
</script>";
exit();
?>