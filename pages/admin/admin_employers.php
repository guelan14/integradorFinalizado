<?php
require_once '../../middlewares/session_check.php';

// Llama a la función de verificación de sesión
checkSession();
checkAdminRole();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados - Administrador</title>
    <link rel="stylesheet" href="../../css/admin/admin-employers.css">
    <link rel="stylesheet" href="../../css/admin/admin-header.css">
</head>
<body>
    <?php include 'admin_header.php'; ?>
    <main>
        <h1>Información de Empleados</h1>
        <!-- Botón para abrir el modal para crear un nuevo empleado -->
        <div class="create-user-btn-container">
            <button class="create-user-btn" id="openModalBtn">Crear Nuevo Empleado</button>
        </div>

        <!-- Modal para crear un nuevo empleado -->
        <div id="createUserModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" id="closeModalBtn">&times;</span>
                <h2>Crear Nuevo Empleado</h2>
                <form id="createUserForm">
                    <label for="username">Nombre de Usuario:</label>
                    <input type="text" id="username" name="username" required><br><br>

                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required><br><br>

                    <label for="first_name">Primer Nombre:</label>
                    <input type="text" id="first_name" name="first_name" required><br><br>

                    <label for="last_name">Apellido:</label>
                    <input type="text" id="last_name" name="last_name" required><br><br>

                    <label for="birth_date">Fecha de Nacimiento:</label>
                    <input type="date" id="birth_date" name="birth_date" required><br><br>

                    <label for="role">Rol:</label>
                    <input type="text" id="role" name="role" required><br><br>

                    <button type="submit" id="submitBtn">Crear Empleado</button>
                </form>
            </div>
        </div>


        <!-- Tabla para mostrar la información de los empleados -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Usuario</th>
                    <th>Nombre Completo</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Rol</th>
                    <th>Editar</th>                  
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody id="employee-list">
                <!-- Aquí se llenarán los empleados desde el servidor -->
            </tbody>
        </table>

        
    </main>

    <script src="../../scripts/admin_user.js"></script> <!-- Archivo JS externo -->
</body>
</html>
