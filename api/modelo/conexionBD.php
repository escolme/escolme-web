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
            $enlace =  mysql_connect('10.10.1.47', 'root', 'Esc$2009');
            mysql_select_db('inventarios', $enlace) or die('Could not select database.');
            if (!$enlace) {
                echo 'No pudo conectarse: ' . mysql_error();
                die();
            }
            return $enlace;
        }
        catch(Exception $e){
            return null;
        }
    }
}