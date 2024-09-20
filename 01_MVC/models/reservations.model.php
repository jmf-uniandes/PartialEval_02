<?php
// TODO: Clase de Factura Tienda Cel@g
require_once('../config/config.php');

class reservationsModel
{
    public function todos() // select * from reservatoins
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT reservations.*, 
       clients.idClients, 
       clients.client_name, 
       clients.client_surename, 
       clients.client_email, 
       events.event_name, 
       events.idEvents 
        FROM reservations 
        INNER JOIN clients ON reservations.clients_idClients = clients.idClients 
        INNER JOIN events ON reservations.events_idEvents = events.idEvents;
        ";
        
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function uno($idReservations) // select * from factura where id = $idReservations
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * 
        FROM reservations 
        INNER JOIN clients ON reservations.clients_idClients = clients.idClients 
        INNER JOIN events ON reservations.events_idEvents = events.idEvents 
        WHERE reservations.idReservations = $idReservations";
       
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function insertar($clients_idClients, $events_IdEvents, $reservationStatus) // insert into factura (Fecha, Sub_total, Sub_total_iva, Valor_IVA, Clientes_idClientes) values (...)
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "INSERT INTO reservations (clients_idClients, events_idEvents, reservationStatus) 
            VALUES ('$clients_idClients', '$events_IdEvents', '$reservationStatus')";
            //echo $cadena;
            if (mysqli_query($con, $cadena)) {
                return $con->insert_id; // Return the inserted ID
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function actualizar($idReservations, $clients_idClients, $events_IdEvents, $reservationStatus) // update factura set ... where id = $idReservations
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "UPDATE reservations 
            SET clients_idClients = '$clients_idClients', events_idEvents = '$events_IdEvents', reservationStatus = '$reservationStatus' 
            WHERE idReservations = '$idReservations'";
            if (mysqli_query($con, $cadena)) {
                return $idReservations; // Return the updated ID
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function eliminar($idReservations) // delete from factura where id = $idReservations
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "DELETE FROM `reservations` WHERE `idReservations`= $idReservations";
            if (mysqli_query($con, $cadena)) {
                return 1; // Success
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }
}
