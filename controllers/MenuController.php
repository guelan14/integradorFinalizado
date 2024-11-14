<?php
include_once "../models/Menu.php";

class MenuController {

public function getAllMenuItems() {
    $menuModel = new Menu();
    $menuItems = $menuModel->getMenuItems();
    
    // Devolver el resultado como JSON
    header('Content-Type: application/json');
    echo json_encode($menuItems);
}

public function deleteMenuItem() {
    $menuModel = new Menu();  // Crear la instancia del modelo

    // Leer el cuerpo de la solicitud
    $input = json_decode(file_get_contents("php://input"), true);

    // Verificar si el id está presente en el cuerpo de la solicitud
    if (isset($input['id'])) {
        $id = $input['id'];

        // Llamar al método del modelo para eliminar el ítem
        if ($menuModel->deleteMenuItem($id)) {  // Cambiar a $menuModel
            echo json_encode(["message" => "Item eliminado exitosamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el ítem"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "ID no proporcionado"]);
    }
}


public function addMenuItem($data) {
    $menuModel = new Menu();

    // Obtener los datos del formulario
    $name = isset($data['name']) ? $data['name'] : '';
    $category = isset($data['category']) ? $data['category'] : '';
    $price = isset($data['price']) ? floatval($data['price']) : 0;
    $description = isset($data['description']) ? $data['description'] : '';

    // Procesar la imagen
    $imageName = '';
    $imageContent = null; // Contenido binario de la imagen (si deseas guardarlo como blob)

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Generar un nombre único para la imagen
        $imageName = explode('.', $_FILES['image']['name']);
        $imageName = time() . '.' . end($imageName); // Evitar conflictos de nombres

        // Mover la imagen a la carpeta de destino
        $imagePath = "../images/" . $imageName;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            header("Content-Type: application/json");
            echo json_encode(["message" => "Error al mover la imagen"]);
            return;
        }

        // Si deseas obtener el contenido binario de la imagen (como un blob)
        $imageContent = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    }

    // Llamar al método del modelo para agregar el ítem al menú
    $insertSuccess = $menuModel->insertMenuItem($name, $category, $price, $description, $imageName, $imageContent);

    // Responder al cliente
    header("Content-Type: application/json");
    if ($insertSuccess) {
        echo json_encode(["message" => "Item agregado exitosamente"]);
    } else {
        echo json_encode(["message" => "Error al agregar el ítem al menú"]);
    }
}

        // Obtener un ítem específico del menú
    public function getItem($id) {
        $menuModel = new Menu();

        // Llamar al modelo para obtener el ítem por su id
        $item = $menuModel->getMenuItemById($id);

        // Verificar si el ítem existe
        if ($item) {
            header('Content-Type: application/json');
            echo json_encode($item);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Ítem no encontrado"]);
        }
    }
}

// Verificar si es una llamada para listar items del menú
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
$controller = new MenuController();
$controller->getAllMenuItems();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new MenuController();
    // Decodificar el JSON de la solicitud
    $input = json_decode(file_get_contents("php://input"), true);

    // Verificar si la acción está definida
    if (isset($input['action'])) {
        switch ($input['action']) {
            case 'delete':
                // Si la acción es "delete", eliminar el ítem
                if (isset($input['id'])) {
                    $controller->deleteMenuItem($input['id']);
                } else {
                    echo json_encode(["message" => "ID no proporcionado para eliminar."]);
                }
                break;

            case 'create':
                // Código para agregar un nuevo ítem
                    $controller->addMenuItem($input);
                break;
                
            case 'update':
                // Actualizar un ítem
                $controller->updateMenuItem($input);
                break;

            case 'getItem':
                // Obtener un ítem específico
                if (isset($input['id'])) {
                    $controller->getItem($input['id']);
                } else {
                    echo json_encode(["message" => "ID no proporcionado para obtener el ítem."]);
                }
                break;

            default:
                echo json_encode(["message" => "Acción no definida."]);
                break;
        }
    }
}
?>
