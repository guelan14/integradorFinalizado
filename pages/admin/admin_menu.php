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
    <title>Gestión del Menú - Administrador</title>
    <link rel="stylesheet" href="../../css/admin/admin-menu.css">
    <link rel="stylesheet" href="../../css/admin/admin-header.css">


</head>
<body>
    <?php include 'admin_header.php'; ?>
    <main>
        <h1>Items Del Menu</h1>

        <div class="create-user-btn-container">
            <button class="create-user-btn" id="add-menu-item-button">Crear Nuevo Item</button>
        </div>
        <div id="add-menu-item-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Agregar Nuevo Item del Menú</h2>
        <form id="add-menu-item-form" action="../../controllers/add_menu_item.php?accion=guardar_insertar" method="POST" enctype="multipart/form-data">
            <input type="text" id="name" name="name" placeholder="Nombre del plato" required>
            <select id="category" name="category" required>
                <option value="">Elige una categoría</option>
                <option value="entradas">Entradas</option>
                <option value="principales">Principales</option>
                <option value="bebidas">Bebidas</option>
                <option value="postres">Postres</option>
            </select>                    
            <input type="number" id="price" name="price" placeholder="Precio" step="0.01" required>
            <textarea id="description" name="description" placeholder="Descripción" required></textarea>
            <input type="file" id="image" name="image" accept="image/*" required>
            <button type="submit">Agregar Ítem</button>
        </form>
    </div>
</div>
        <!-- Modal para editar un ítem del menú -->
        <div id="edit-menu-item-modal" style="display: none;">
            <form id="edit-menu-item-form">
                <label for="edit-name">Nombre:</label>
                <input type="text" id="edit-name" name="name" required />

                <label for="edit-category">Categoría:</label>
                <select id="edit-category" name="category" required>
                    <option value="entradas">Entradas</option>
                    <option value="principales">Principales</option>
                    <option value="postres">Postres</option>
                    <option value="bebidas">Bebidas</option>
                </select>

                <label for="edit-price">Precio:</label>
                <input type="number" id="edit-price" name="price" required step="0.01" />

                <label for="edit-description">Descripción:</label>
                <textarea id="edit-description" name="description"></textarea>

                <label for="edit-image">Imagen:</label>
                <input type="file" id="edit-image" name="image" />

                <button type="submit" id="save-edit-button">Guardar cambios</button>
                <button type="button" onclick="closeEditModal()">Cancelar</button>
            </form>
        </div>

        <div id="menu-list">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody id="menu-list-body">
                    <!-- Aquí se llenarán los items del menú -->
                </tbody>
            </table>
        </div>
    </main>

    <script src="../../scripts/admin_menu.js"></script>
</body>
</html>
