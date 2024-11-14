<?php
require_once '../models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function createUser($username, $password, $firstName, $lastName, $birthDate, $role) {
        try {
            if ($this->userModel->createUser($username, $password, $firstName, $lastName, $birthDate, $role)) {
                echo json_encode(["message" => "Usuario creado exitosamente."]);
            } else {
                echo json_encode(["message" => "Error al crear el usuario."]);
            }
        } catch (Exception $e) {
            error_log("Error en createUser: " . $e->getMessage()); // Registrar en el log de errores
            echo json_encode(["error" => "Ocurrió un error al crear el usuario."]);
        }
    }

    public function getEmployees() {
        try {
            $employees = $this->userModel->getEmployees();
            echo json_encode($employees);
        } catch (Exception $e) {
            error_log("Error en getEmployees: " . $e->getMessage());
            echo json_encode(["error" => "Ocurrió un error al obtener los empleados."]);
        }
    }
}


    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller = new UserController();
        $controller->getEmployees();
    }

    // Manejo de solicitud POST 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $controller = null; // Inicializamos la variable del controlador

    // Verificamos si existe la acción
    if (isset($input['action'])) {
        switch ($input['action']) {
            case 'delete':
                // Acción para eliminar el ítem
                $controller = new MenuController();
                if (isset($input['id'])) {
                    $controller->deleteMenuItem($input['id']);
                } else {
                    echo json_encode(["message" => "ID no proporcionado para eliminar."]);
                }
                break;

            case 'create':
                // Acción para crear un usuario
                if (isset($input['username'], $input['password'], $input['first_name'], $input['last_name'], $input['birth_date'], $input['role'])) {
                    $controller = new UserController();
                    $controller->createUser(
                        $input['username'],
                        $input['password'],
                        $input['first_name'],
                        $input['last_name'],
                        $input['birth_date'],
                        $input['role']
                    );
                } else {
                    echo json_encode(["message" => "Datos incompletos para la creación del usuario."]);
                }
                break;

            default:
                // Si no es ni 'delete' ni 'create'
                echo json_encode(["message" => "Acción no válida."]);
                break;
        }
    } else {
        echo json_encode(["message" => "Acción no especificada."]);
    }
    }

?>
