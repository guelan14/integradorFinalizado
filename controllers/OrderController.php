<?php
include_once "../database/conexion.php"; // Incluye tu archivo de conexión
include_once "../models/Order.php"; // Incluye el modelo

global $conexion;

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Instanciar el modelo
$orderModel = new Order($conexion);

// Procesar la solicitud
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener todas las órdenes
    $orders = $orderModel->getOrders();
    echo json_encode($orders);}
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true); // Obtener datos enviados en JSON

    // Verificar si es una solicitud para crear una nueva orden
    if (isset($data['items']) && isset($data['deliveryMode'])) {
        // Iniciar la transacción para crear una nueva orden
        mysqli_begin_transaction($conexion);

        try {
            // Crear una nueva orden
            $table_id = $data['selectedTable'];
            $type = $data['deliveryMode'];
            $order_id = $orderModel->createOrder($table_id, $type);

            // Insertar los artículos de la orden
            $orderModel->addOrderItems($order_id, $data['items']);

            // Confirmar la transacción
            mysqli_commit($conexion);

            // Devolver el ID de la orden
            echo json_encode(['success' => true, 'orderId' => $order_id]);

        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            mysqli_rollback($conexion);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }

    } elseif (isset($data['orderId'])) {
        // Actualizar el estado de una orden existente
        $orderId = $data['orderId'];
        $response = $orderModel->updateOrderStatus($orderId, 'paid'); // Llama a la función para actualizar el estado
        echo json_encode($response);

    } else {
        // Respuesta en caso de datos incompletos
        echo json_encode(["success" => false, "message" => "Datos incompletos para crear o actualizar la orden."]);
    }
}

// Cerrar la conexión
$conexion->close();
?>
