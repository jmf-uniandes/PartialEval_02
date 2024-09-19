<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

//TODO: controlador de clientes 

require_once('../models/clientes.model.php');
error_reporting(0);

$clientes = new ClientModel;

switch ($_GET["op"]) {
        //TODO: operaciones de clientes
    
        case 'buscar': // Procedimiento para cargar todos los datos de los clientes
        if (!isset($_POST["texto"])) {
            echo json_encode(["error" => "Client ID not specified."]);
            exit();
        }
        $texto = intval($_POST["texto"]);
        $datos = array();
        $datos = $clientes->buscar($texto);
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
   
        case 'todos': // Procedimiento para cargar todos los datos de los clientes
        $datos = array();
        $datos = $clientes->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno': // Procedimiento para obtener un registro de la base de datos
        if (!isset($_POST["idClients"])) {
            echo json_encode(["error" => "Client ID not specified."]);
            exit();
        }
        $idClients = intval($_POST["idClients"]);
        $datos = array();
        $datos = $clientes->uno($idClients);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar': // Procedimiento para insertar un cliente en la base de datos
        if (!isset($_POST["client_name"]) || !isset($_POST["client_surename"]) || !isset($_POST["client_email"]) || !isset($_POST["client_phonenumber"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $client_name = $_POST["client_name"];
        $client_surename = $_POST["client_surename"];
        $client_email = $_POST["client_email"];
        $client_phonenumber = $_POST["client_phonenumber"];
        

        $datos = array();
        $datos = $clientes->insertar($client_name, $client_surename, $client_email, $client_phonenumber);
        echo json_encode($datos);
        break;

    case 'actualizar': // Procedimiento para actualizar un cliente en la base de datos
        if (!isset($_POST["idClients"]) || !isset($_POST["client_name"]) || !isset($_POST["client_surename"]) || !isset($_POST["client_email"]) || !isset($_POST["client_phonenumber"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $idClients = intval($_POST["idClients"]);
        $client_name = $_POST["client_name"];
        $client_surename = $_POST["client_surename"];
        $client_email = $_POST["client_email"];
        $client_phonenumber = $_POST["client_phonenumber"];
        

        $datos = array();
        $datos = $clientes->actualizar($idClients, $client_name, $client_surename, $client_email, $client_phonenumber);
        echo json_encode($datos);
        break;

    case 'eliminar': // Procedimiento para eliminar un cliente en la base de datos
        if (!isset($_POST["idClients"])) {
            echo json_encode(["error" => "Client ID not specified."]);
            exit();
        }
        $idClients = intval($_POST["idClients"]);
        $datos = array();
        $datos = $clientes->eliminar($idClients);
        echo json_encode($datos);
        break;

    default:
        echo json_encode(["error" => "Invalid operation."]);
        break;
}
