<?php
include_once "../database/conexion.php";


if (isset($_POST['name'], $_POST['category'], $_POST['price'], $_POST['description'], $_FILES['image'])) {
    // Recibir los datos del formulario
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Manejar la subida de la imagen
    $image = $_FILES['image'];
    $imageName = $image['name'];
    $imageTmpName = $image['tmp_name'];
    $imageSize = $image['size'];
    $imageError = $image['error'];
    
    if ($imageError === 0) {
        // Validar la imagen (por ejemplo, permitir solo imágenes JPG, PNG)
        $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
        $imageExt = strtolower($imageExt);

        if (in_array($imageExt, ['jpg', 'jpeg', 'png'])) {
            // Generar un nombre único para la imagen
            $newImageName = uniqid('', true) . "." . $imageExt;
            $imageDestination = '../images/' . $newImageName;

            // Mover la imagen a la carpeta de destino
            if (move_uploaded_file($imageTmpName, $imageDestination)) {
                // Preparar la consulta SQL para insertar los datos
                $sql = "INSERT INTO menu_items (name, category, price, description, image) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("ssdss", $name, $category, $price, $description, $newImageName);

                if ($stmt->execute()) {
                    echo "<script>alert('Nuevo ítem agregado correctamente'); window.location.href = '../pages/admin/admin_menu.php';</script>";

                } else {
                    echo "Error al agregar el ítem: " . $conexion->error;
                }

                $stmt->close();
            } else {
                echo "Error al subir la imagen.";
            }
        } else {
            echo "Solo se permiten imágenes JPG, JPEG y PNG.";
        }
    } else {
        echo "Error en la carga de la imagen.";
    }
} else {
    echo "Por favor, complete todos los campos del formulario.";
}
?>
