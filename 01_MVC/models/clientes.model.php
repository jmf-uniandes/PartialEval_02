<?php
// TODO: Clase de clients Tienda Cel@g
require_once('../config/config.php');

class ClientModel
{
    // TODO: Implementar los métodos de la clase


    public function buscar($textp) // select * from clients
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `clients` where client_name='$textp'";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }
    
    public function todos() // select * from clients
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `clients`";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function uno($idClients) // select * from clients where id = $idClients
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `clients` WHERE `idClients` = $idClients";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function insertar($client_name,$client_surename,$client_email, $client_phonenumber ) // INSERT INTO `clients`(`idClients`, `client_name`, `client_surename`, `client_email`, `client_phonenumber`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "INSERT INTO `clients`( `client_name`, `client_surename`, `client_email`, `client_phonenumber`) 
                       VALUES ($client_name, $client_surename, $client_email, $client_phonenumber)";
            
            if (mysqli_query($con, $cadena)) {
                return $con->insert_id; // Return the inserted ID
                //console.log('guardo:' + $cadena);
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function actualizar($idClients, $client_name,$client_surename,$client_email, $client_phonenumber) //UPDATE `clients` SET `idClients`='[value-1]',`client_name`='[value-2]',`client_surename`='[value-3]',`client_email`='[value-4]',`client_phonenumber`='[value-5]' WHERE 1
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "UPDATE `clients` SET 
                       `client_name`='$client_name',
                       `client_surename`='$client_surename',
                       `client_email`='$client_email',
                       `client_phonenumber`=$client_phonenumber                     
                       WHERE `idClients` = $idClients";
            
            if (mysqli_query($con, $cadena)) {
                return $idClients; // Return the updated ID
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function eliminar($idClients) // delete from clients where id = $idClients
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "DELETE FROM `clients` WHERE `idClients`= $idClients";
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
