<?php

class conexionBD {

    function conectar() {
        $user="ACADEMICO";
        $pass="ACA0369";
        $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.10.1.12)(PORT = 1521)))(CONNECT_DATA=(SID=ESCOLME)))";
        try{
            $conn=OCILogon($user, $pass, $db);
            if (!$conn){
                echo "Conexion es invalida" . var_dump (OCIError());
                die();
            }

            return $conn;
        }
        catch(Exception $e){
            return null;
        }
    }

    function conectarInventarios(){
        try{
            $conexion = mysqli_connect("10.10.1.47","root","Esc$2009","inventario");
            if (mysqli_connect_errno())
            {
                echo "Conexion es invalida: " . mysqli_connect_error();
                die();
            }
            return $conexion;
        }
        catch(Exception $e){
            return null;
        }
    }
}