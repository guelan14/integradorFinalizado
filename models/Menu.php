<?php
include_once "../database/conexion.php";

class Menu {
    private $conexion;

    public function __construct() {
        global $conexion;
        $this->conexion = $conexion;
    }

    private $imagePath = '../images/'; 
    
    public function getMenuItems() {
        $sql = $this->conexion->query("SELECT * FROM menu_items WHERE activo = true");
        $menuItems = [
            'entradas' => [],
            'principales' => [],
            'bebidas' => [],
            'postres' => []
        ];

        while ($datos = $sql->fetch_object()) {
            // Agrupar por categoría
            $category = strtolower($datos->category); // categoría en minúsculas
            if (array_key_exists($category, $menuItems)) {
                $menuItems[$category][] = [
                    'id' => $datos->id,
                    'name' => $datos->name,
                    'image' => $this->imagePath . $datos->image,
                    'description' => $datos->description,
                    'price' =>floatval($datos->price)
                ];
            }
        }
        return $menuItems;
    }

        // Obtener un ítem específico del menú por ID (si lo necesitas)
    public function getMenuItemById($id) {
        $query = "SELECT * FROM menu_items WHERE id = $id";
        $result = $this->conexion->query($query);
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function getSpecialDishes() {
        // Consulta para obtener los platos especiales, uniendo las tablas `menu_items` y `special_dishes`
        $query = "SELECT m.id, m.name, m.image, m.category, m.price, m.description, sd.alt, sd.ingredients, sd.youtube_link 
            FROM menu_items AS m
            INNER JOIN special_dishes AS sd ON m.id = sd.food_id";

        $stmt = $this->conexion->prepare($query);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $specialDishes = [];

        while ($row = $result->fetch_assoc()) {
            $specialDishes[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'price' => floatval($row['price']),
                'description' => $row['description'],
                'image' => $this->imagePath . $row['image'],
                'alt' => $row['alt'],
                'ingredients' => $row['ingredients'],
                'youtube_link' => $row['youtube_link']
            ];
        }
        return $specialDishes;
    }

public function insertMenuItem($name, $category, $price, $description, $imageName) {
    // Preparar la consulta para insertar un nuevo ítem
    $sql = "INSERT INTO menu_items (name, category, price, description, image) VALUES (?, ?, ?, ?, ?)";

    // Preparar la consulta
    $stmt = $this->conexion->prepare($sql);

    // Verificar si la preparación fue exitosa
    if ($stmt === false) {
        die('Error al preparar la consulta: ' . $this->conexion->error);
    }

    // Asignar los parámetros
    $stmt->bind_param("sssss", $name, $category, $price, $description, $imageName);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        return true; // Si la ejecución fue exitosa
    } else {
        return false; // Si hubo un error al ejecutar la consulta
    }
}

    public function updateMenuItem($id, $name, $category, $price, $description, $imageName) {
    // Verifica si los parámetros son válidos y si no está vacío alguno
    if (empty($id) || empty($name) || empty($category) || empty($price) || empty($description)) {
        throw new Exception('Datos incompletos para actualizar el ítem');
    }

    // Lógica para actualizar el ítem en la base de datos
    // Ejemplo de consulta SQL
    $query = "UPDATE menu_items SET name = ?, category = ?, price = ?, description = ?, image = ? WHERE id = ?";
    $stmt = $this->conexion->prepare($query);
    $stmt->bind_param('sssssi', $name, $category, $price, $description, $imageName, $id);

    if (!$stmt->execute()) {
        throw new Exception('Error al actualizar el ítem: ' . $stmt->error);
    }

    return true;
    }

    // Función para eliminar un ítem del menú
    public function deleteMenuItem($id) {
        $sql = "UPDATE menu_items SET activo = false WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);

            // Ejecutar y verificar si la consulta fue exitosa
    if ($stmt->execute()) {
        // Verificar si se eliminó alguna fila
        if ($stmt->affected_rows > 0) {
            return true;  // Se eliminó el ítem
        } else {
            return false; // No se encontró ningún ítem con ese ID
        }
    } else {
        return false; // Error en la ejecución
    }
    }


}
?>