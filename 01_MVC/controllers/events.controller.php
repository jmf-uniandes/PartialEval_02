<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

//TODO: controlador de events 

require_once('../models/events.model.php');
error_reporting(0);

$events = new eventsModel;

switch ($_GET["op"]) {
        //TODO: operaciones de events
    case 'buscar': // Procedimiento para cargar todos los datos de los events
        if (!isset($_POST["texto"])) {
            echo json_encode(["error" => "Event ID not specified."]);
            exit();
        }
        $texto = intval($_POST["texto"]);
        $datos = array();
        $datos = $events->buscar($texto);
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
    case 'todos': // Procedimiento para cargar todos los datos de los events
        $datos = array();
        $datos = $events->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno': // Procedimiento para obtener un registro de la base de datos
        if (!isset($_POST["idEvents"])) {
            echo json_encode(["error" => "Event ID not specified."]);
            exit();
        }
        $idEvents = intval($_POST["idEvents"]);
        $datos = array();
        $datos = $events->uno($idEvents);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar': // Procedimiento para insertar un evento en la base de datos
        if (!isset($_POST["event_name"]) || !isset($_POST["event_description"]) || !isset($_POST["event_date"]) || !isset($_POST["event_location"])|| !isset($_POST["event_status"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $event_name = $_POST["event_name"];
        $event_description = $_POST["event_description"];
        $event_date = $_POST["event_date"];
        $event_location = $_POST["event_location"];
        $event_status = $_POST["event_status"];
        
        
        $datos = array();
        $datos = $events->insertar($event_name, $event_description, $event_date, $event_location,$event_status);
        echo json_encode($datos);
        break;

    case 'actualizar': // Procedimiento para actualizar un evento en la base de datos
        if (!isset($_POST["idEvents"]) || !isset($_POST["event_name"]) || !isset($_POST["event_description"]) || !isset($_POST["event_date"]) || !isset($_POST["event_location"])|| !isset($_POST["event_status"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $idEvents = intval($_POST["idEvents"]);
        $event_name = $_POST["event_name"];
        $event_description = $_POST["event_description"];
        $event_date = $_POST["event_date"];
        $event_location = $_POST["event_location"];
        $event_status = intval($_POST["event_status"]);
        

        $datos = array();
        $datos = $events->actualizar($idEvents, $event_name, $event_description, $event_date, $event_location,$event_status);
        echo json_encode($datos);
        break;

    case 'eliminar': // Procedimiento para eliminar un evento en la base de datos
        if (!isset($_POST["idEvents"])) {
            echo json_encode(["error" => "Event ID not specified."]);
            exit();
        }
        $idEvents = intval($_POST["idEvents"]);
        $datos = array();
        $datos = $events->eliminar($idEvents);
        echo json_encode($datos);
        break;

    default:
        echo json_encode(["error" => "Invalid operation."]);
        break;
}
