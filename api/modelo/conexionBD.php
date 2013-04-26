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
<<<<<<< HEAD
            $enlace =  mysql_connect('10.10.1.47', 'root', 'Esc$2009');
            mysql_select_db('inventario', $enlace) or die('Could not select database.');
            if (!$enlace) {
                echo 'No pudo conectarse: ' . mysql_error();
=======

            //$enlace =  mysql_connect('10.10.1.47', 'root', 'Esc$2009');
            //mysql_select_db('inventario', $enlace) or die('Could not select database.');
            //if (!$enlace) {

              //  echo 'No pudo conectarse: ' . mysql_error();

>>>>>>> 8afb64ab4b43efdf36192482497eec1acd572b3b
            $conexion = mysqli_connect("10.10.1.47","root","Esc$2009","inventario");
            }
            if (mysqli_connect_errno())
            {
                echo "Conexión es invalida: " . mysqli_connect_error();
<<<<<<< HEAD
=======

>>>>>>> 8afb64ab4b43efdf36192482497eec1acd572b3b
                die();
            }
           return $conexion;
        }
        catch(Exception $e){
            return null;
        }
    }

    function conectarPosgresql(){

        #Conectamos con PostgreSQL
        try{
            $conexion = pg_connect("host=10.10.1.12 dbname=escolme user=postgres password=Escolme2008") or die ("Fallo en el establecimiento de la conexión");
            return $conexion;
        }
        catch(Exception $e){
            return null;

        }

    }
}