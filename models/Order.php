<?php
class Order {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Obtener todas las órdenes
public function getOrders() {
    $query = "
        SELECT o.id AS order_id, o.table_id, o.type, o.created_at, o.status, 
            GROUP_CONCAT(CONCAT(m.name, ' (', oi.quantity, ')') SEPARATOR ', ') AS food_details
        FROM orders AS o
        LEFT JOIN order_items AS oi ON o.id = oi.order_id
        LEFT JOIN menu_items AS m ON oi.food_id = m.id
        GROUP BY o.id
        ORDER BY o.created_at DESC
    ";

    if ($result = $this->conexion->query($query)) {
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return []; // No hay órdenes
        }
    } else {
        // Manejo de error en caso de que la consulta falle
        error_log("Error en la consulta: " . $this->conexion->error); // Loguear el error
        return ["error" => "Error al obtener las órdenes."];
    }
}


    // Actualizar el estado de una orden
    public function updateOrderStatus($orderId, $status) {
        $query = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($query);

        if ($stmt) {
            $stmt->bind_param("si", $status, $orderId); 
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                return ["success" => true, "message" => "Estado del pedido actualizado a '$status'."];
            } else {
                return ["success" => false, "message" => "No se encontró el pedido o ya estaba en estado '$status'."];
            }

            $stmt->close(); // Cerrar la declaración
        } else {
            return ["success" => false, "message" => "Error al preparar la consulta."];
        }
    }
     public function createOrder($table_id, $type) {
        $query = "INSERT INTO orders (table_id, type, status) VALUES (?, ?, 'pending')";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("is", $table_id, $type);
        $stmt->execute();
        $order_id = $stmt->insert_id;
        $stmt->close();
        return $order_id;
    }

    public function addOrderItems($order_id, $items) {
        $query = "INSERT INTO order_items (order_id, food_id, quantity) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($query);
        
        foreach ($items as $item) {
            $food_id = $item['id'];
            $quantity = $item['quantity'];
            $stmt->bind_param("iii", $order_id, $food_id, $quantity);
            $stmt->execute();
        }

        $stmt->close();
    }

}
?>