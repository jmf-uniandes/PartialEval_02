<?php
include_once('../config/config.php');

class usersModel
{
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM users";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    public function uno($idUsers)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM users WHERE idUsers = $idUsers";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    public function insertar($user_name, $user_password, $user_status, $roles_idRoles)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "INSERT INTO users (user_name, user_password, user_status, roles_idRoles) VALUES ('$user_name', '" . md5($user_user_password) . "', $user_status, $roles_idRoles)";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    public function actualizar($idUsers, $user_name, $user_password, $user_status, $roles_idRoles)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "UPDATE users SET user_name = '$user_name', user_password = '" . md5($user_password) . "', user_status = $user_status, roles_idRoles = $roles_idRoles WHERE idUsers = $idUsers";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    public function eliminar($idUsers)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "DELETE FROM users WHERE idUsers = $idUsers";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    public function login($user_name, $user_password)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM users WHERE user_name = '$user_name' and user_status = 1"; // ' or 1=1 -- 
        $datos = mysqli_query($con, $cadena);
        if ($datos && mysqli_num_rows($datos) > 0) {
            $usuario = mysqli_fetch_assoc($datos);
            if ((md5($user_password) == $usuario['user_password'])) {
                return $usuario;
            } else {
                return false;
            }
        }
    }
}
