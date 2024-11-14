<?php
require_once '../../middlewares/session_check.php';

// Llama a la función de verificación de sesión
checkSession();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Órdenes de Pedido - Administrador</title>
    <link rel="stylesheet" href="../../css/admin/admin-tables.css">
    <link rel="stylesheet" href="../../css/admin/admin-header.css">
</head>
<body>
    <?php include 'admin_header.php'; ?>
    <main>
        <h1>Información Mesas</h1>

        <div class="create-user-btn-container">
        <button class="create-user-btn" id="openModalBtn">Crear Nueva Mesa</button>
        </div>
        <!-- Modal para crear nueva mesa -->
            <div id="createTableModal" class="modal">
                <div class="modal-content">
                    <span id="closeModalBtn" class="close">&times;</span>
                    <h2>Crear Nueva Mesa</h2>
                    <form id="createTableForm">
                        <label>
                            Estado:
                            <input type="radio" name="status" value="free" checked> Libre
                            <input type="radio" name="status" value="occupied"> Ocupada
                        </label>
                        <br>
                        <button type="submit">Crear Mesa</button>
                    </form>
                </div>
            </div>
        <table>
            <thead>
                <tr>
                    <th>Numero de Mesa</th>
                    <th>Estado</th>
                    <th>Eliminar</th>

                </tr>
            </thead>
            <tbody id="order-list">
                <!-- Aquí se llenarán las órdenes desde el servidor -->
            </tbody>
        </table>
    </main>
    <script src="../../scripts/admin_tables.js"></script> 
</body>
</html>
