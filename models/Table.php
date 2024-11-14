<?php
require_once '../database/conexion.php'; // Asegúrate de que la ruta sea correcta

class Table {
    private $conexion;

    public function __construct() {
        global $conexion;
        $this->conexion = $conexion;
    }

    // Crear Table
    public function insertTable($status) {
    $query = "INSERT INTO tables (status) VALUES (?)";
    $stmt = $this->conexion->prepare($query);
    $stmt->bind_param("s", $status); // Parámetro de estado (libre u ocupada)
    
    return $stmt->execute(); // Ejecutar la consulta
    }

    public function deleteTable($id) {
        // Asegurarse de que el ID sea válido
        if (empty($id) || !is_numeric($id)) {
            return false; // No hacer nada si el ID no es válido
        }

        $sql = "UPDATE tables SET activo = FALSE WHERE id = $id"; // Inserta el valor del ID directamente en la consulta
        $result = mysqli_query($this->conexion, $sql); // Se asume que $this->conexion es la conexión a la base de datos

        // Verificar si la eliminación fue exitosa
        if ($result) {
            return true; // Si la eliminación fue exitosa
        } else {
            return false; // Si hubo un error al intentar eliminar
        }
    }
    // Obtener todas las mesas
    public function getTables() {
        $query = "SELECT * FROM tables where activo=true "; // Consulta para obtener las mesas
        $result = $this->conexion->query($query);

        if ($result->num_rows > 0) {
            $tables = [];
            while ($row = $result->fetch_assoc()) {
                $tables[] = $row; // Guardar cada mesa en un array
            }
            return $tables;
        } else {
            return []; // Retorna un array vacío si no hay resultados
        }
    }

    // Cambiar el estado de una mesa
    public function updateTableStatus($id, $status) {
        $query = "UPDATE tables SET status = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("si", $status, $id); // "si" indica tipos (string, integer)

        return $stmt->execute(); // Retorna true o false según el resultado
    }
}
?>
