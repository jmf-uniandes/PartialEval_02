<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}
include_once('../models/usuarios.model.php');
error_reporting(0);
$usuario = new usersModel();
switch ($_GET["op"]) {
    case 'todos':
        $datos = array();
        $datos = $usuario->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
    case 'uno':
        if (!isset($_POST["idUsers"])) {
            echo json_encode(["error" => "Seleccione un usuario"]);
        }
        $idUsers = $_POST["idUsers"];
        $datos = array();
        $datos = $usuario->uno($idUsers);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
    case 'insertar':
        echo md5('1234');
        return;
        if (!isset($_POST["user_name"]) || !isset($_POST["user_password"]) || !isset($_POST["user_status"]) || !isset($_POST["roles_idRoles"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $nombreUsuario = $_POST["user_name"];
        $user_password = $_POST["user_password"];
        $user_status = intval($_POST["user_status"]);
        $rolesIdRoles = intval($_POST["roles_idRoles"]);

        $datos = array();
        $datos = $usuarios->insertar($nombreUsuario, $user_password, $user_status, $rolesIdRoles);
        echo json_encode($datos);
        break;

    case 'actualizar':
        if (!isset($_POST["idUsers"]) || !isset($_POST["user_name"]) || !isset($_POST["user_password"]) || !isset($_POST["user_status"]) || !isset($_POST["roles_idRoles"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $idUsers = intval($_POST["idUsers"]);
        $nombreUsuario = $_POST["user_name"];
        $user_password = $_POST["user_password"];
        $user_status = intval($_POST["user_status"]);
        $rolesIdRoles = intval($_POST["roles_idRoles"]);

        $datos = array();
        $datos = $usuarios->actualizar($idUsers, $nombreUsuario, $user_password, $user_status, $rolesIdRoles);
        echo json_encode($datos);
        break;

    case 'eliminar':
        if (!isset($_POST["idUsers"])) {
            echo json_encode(["error" => "User ID not specified."]);
            exit();
        }
        $idUsers = intval($_POST["idUsers"]);
        $datos = array();
        $datos = $usuarios->eliminar($idUsers);
        echo json_encode($datos);
        break;

    case 'login':
        if (!isset($_POST["user_name"]) || !isset($_POST["user_password"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }
        $nombreUsuario = $_POST["user_name"];
        $user_password = $_POST["user_password"];
        $result = $usuario->login($nombreUsuario, $user_password);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(["success" => false, "error" => "Invalid credentials."]);
        }
        break;

    default:
        # code...
        break;
}
