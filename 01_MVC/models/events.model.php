<?php
// TODO: Clase de events Tienda Cel@g
require_once('../config/config.php');

class eventsModel
{
    // TODO: Implementar los métodos de la clase


    public function buscar($textp) // select * from events
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `events` where event_name='$textp'";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }
    public function todos() // select * from events
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `events`";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function uno($idEvents) // select * from events where id = $idEvents
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `events` WHERE `idEvents` = $idEvents";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function insertar($event_name,$event_description,$event_date, $event_location,$event_satus ) // INSERT INTO `events`(`idEvents`, `event_name`, `event_description`, `event_date`, `event_location`,`event_status`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "INSERT INTO `events`(`event_name`, `event_description`, `event_date`, `event_location`, `event_status`) 
                       VALUES ($event_name,$event_description,$event_date, $event_location,$event_satus)";
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

    public function actualizar($idEvents, $event_name,$event_description,$event_date, $event_location,$event_satus) //UPDATE `events` SET `idEvents`='[value-1]',`event_name`='[value-2]',`event_description`='[value-3]',`event_date`='[value-4]',`event_location`='[value-5]' WHERE 1
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "UPDATE `events` SET 
                       `event_name`='$event_name',
                       `event_description`='$event_description',
                       `event_date`='$event_date',
                       `event_location`='$event_location'
                       `event_satus`='$event_satus'                     
                       WHERE `idEvents` = $idEvents";
            if (mysqli_query($con, $cadena)) {
                return $idEvents; // Return the updated ID
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function eliminar($idEvents) // delete from events where id = $idEvents
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "DELETE FROM `events` WHERE `idEvents`= $idEvents";
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
