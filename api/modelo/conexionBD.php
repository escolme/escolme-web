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
            mysql_select_db('inventario', $enlace) or die('Could not select database.');
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

    function conectarPosgresql(){
        // Conectando y seleccionado la base de datos  
        $dbconn = pg_connect("host=localhost dbname=publishing user=www password=foo")
            or die('No se ha podido conectar: ' . pg_last_error());

        // Realizando una consulta SQL
        $query = 'SELECT * FROM authors';
        $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());

        // Imprimiendo los resultados en HTML
        echo "<table>\n";
        while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
            echo "\t<tr>\n";
            foreach ($line as $col_value) {
                echo "\t\t<td>$col_value</td>\n";
            }
            echo "\t</tr>\n";
        }
        echo "</table>\n";

        // Liberando el conjunto de resultados
        pg_free_result($result);

        // Cerrando la conexión
        pg_close($dbconn);        
    }
}