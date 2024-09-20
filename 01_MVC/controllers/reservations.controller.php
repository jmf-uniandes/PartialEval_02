<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

//TODO: controlador de reservations 

require_once('../models/reservations.model.php');
error_reporting(0);

$reservations = new reservationsModel;

switch ($_GET["op"]) {
        //TODO: operaciones de reservations
    case 'buscar': // Procedimiento para cargar todos los datos de los reservations
        if (!isset($_POST["texto"])) {
            echo json_encode(["error" => "Reservation ID not specified."]);
            exit();
        }
        $texto = intval($_POST["texto"]);
        $datos = array();
        $datos = $reservations->buscar($texto);
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
    case 'todos': // Procedimiento para cargar todos los datos de los reservations
        $datos = array();
        $datos = $reservations->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno': // Procedimiento para obtener un registro de la base de datos
        if (!isset($_POST["idReservations"])) {
            echo json_encode(["error" => "Event ID not specified."]);
            exit();
        }
        $idReservations = intval($_POST["idReservations"]);
        $datos = array();
        $datos = $reservations->uno($idReservations);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar': // Procedimiento para insertar una reservacion en la base de datos
        if (!isset($_POST["clients_idClients"]) || !isset($_POST["events_IdEvents"]) || !isset($_POST["reservationStatus"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }
        $clients_idClients = $_POST["clients_idClients"];
        $events_IdEvents = $_POST["events_IdEvents"];
        $reservationStatus = $_POST["reservationStatus"];
        //$event_location = $_POST["event_location"];
        //$event_status = $_POST["event_status"];
        
        
        $datos = array();
        $datos = $reservations->insertar($clients_idClients, $events_IdEvents, $reservationStatus);
        echo json_encode($datos);
        break;

    case 'actualizar': // Procedimiento para actualizar un evento en la base de datos
        if (!isset($_POST["idReservations"]) || !isset($_POST["clients_idClients"]) || !isset($_POST["events_IdEvents"]) || !isset($_POST["reservationStatus"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $idReservations = intval($_POST["idReservations"]);
        $clients_idClients = $_POST["clients_idClients"];
        $events_IdEvents = $_POST["events_IdEvents"];
        $reservationStatus = intval($_POST["reservationStatus"]);
        //$event_location = $_POST["event_location"];
        //$event_status = intval($_POST["event_status"]);
        

        $datos = array();
        $datos = $reservations->actualizar($idReservations, $clients_idClients, $events_IdEvents, $reservationStatus);
        echo json_encode($datos);
        break;

    case 'eliminar': // Procedimiento para eliminar un evento en la base de datos
        if (!isset($_POST["idReservations"])) {
            echo json_encode(["error" => "Reservation ID not specified."]);
            exit();
        }
        $idReservations = intval($_POST["idReservations"]);
        $datos = array();
        $datos = $reservations->eliminar($idReservations);
        echo json_encode($datos);
        break;

    default:
        echo json_encode(["error" => "Invalid operation."]);
        break;
}
