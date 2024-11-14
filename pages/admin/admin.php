<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/admin/admin-header.css">
    <link rel="stylesheet" href="../../css/admin/admin-login.css">

    <title>Navbar</title>
</head>
<body>
    <?php include 'admin_header.php'; ?>
    <div class="login-container">
        <form id="login-form">
            <div class="form-group">
                <label for="username">Nombre de Usuario</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Ingresar</button>
        </form>
    </div>
    <script src="../../scripts/auth_manager.js"></script>
</body>
</html>
