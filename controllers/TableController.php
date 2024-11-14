<?php
require_once '../models/Table.php'; // Importar la clase

class TableController {
    private $table;

    public function __construct() {
        // Corregir la referencia a la variable
        $this->table = new Table(); 
    }

    // Crear una nueva mesa
    public function createTable($status) {
        if (isset($status)) {
            if ($this->table->insertTable($status)) {
                echo json_encode(["message" => "Mesa creada correctamente."]);
            } else {
                echo json_encode(["message" => "Error al crear la mesa."]);
            }
        } else {
            echo json_encode(["message" => "Error: El estado de la mesa es requerido."]);
        }
    }

    // Obtener todas las mesas y devolver en formato JSON
    public function obtenerMesas() {
        // Corregir la referencia a la variable
        $mesas = $this->table->getTables();
        echo json_encode($mesas);
    }

    // Cambiar el estado de una mesa
    public function cambiarEstadoMesa($id, $status) {
        if ($this->table->updateTableStatus($id, $status)) {
            echo json_encode(["message" => "Estado actualizado correctamente."]);
        } else {
            echo json_encode(["message" => "Error al actualizar el estado."]);
        }
    }

    // Eliminar una mesa por su ID
    public function eliminarMesa($id) {
    if ($this->table->deleteTable($id)) {
        echo json_encode(["message" => "Mesa eliminada correctamente."]);
    } else {
        echo json_encode(["message" => "Error al eliminar la mesa."]);
    }
    }
}

    // Verificar si la solicitud es GET (para obtener mesas)
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller = new TableController(); // Crear el controlador
        $controller->obtenerMesas(); // Llamar al método obtenerMesas
    }

    // Verificar si la solicitud es POST (para cambiar estado o crear nueva mesa)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new TableController(); // Crear el controlador
    $data = json_decode(file_get_contents('php://input'), true); // Obtener los datos enviados en JSON

   // Verificar si la acción es para cambiar el estado de una mesa
    if (isset($data['action']) && $data['action'] === 'updateStatus') {
        $controller->cambiarEstadoMesa($data['id'], $data['status']);
    } 
    // Verificar si la acción es para crear una nueva mesa
    elseif (isset($data['action']) && $data['action'] === 'create') {
        $controller->createTable($data['status']);
    } 
    // Verificar si la acción es para eliminar una mesa
    elseif (isset($data['action']) && $data['action'] === 'delete') {
        $controller->eliminarMesa($data['id']);
    } 
    else {
        echo json_encode(["message" => "Acción no válida."]);
    }
    
    }
?>
