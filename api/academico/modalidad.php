<?php
/**
 * User: Jose Luis Orozco
 * Date: 15/03/13
 * Time: 11:23
 * Funciones de Acceso a Datos con la tabla modalidad del esquema academico
 */

function modalidadListar(){
    $user="academico";
    $pass="ACA0369";
    $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.10.1.12)(PORT = 1521)))(CONNECT_DATA=(SID=ESCOLME)))";
    $conn=OCILogon($user, $pass, $db);
    if (!$conn){
        echo "Conexion es invalida" . var_dump (OCIError());
        die();
    }
    $query =OCIParse($conn, "Select * from GENERAL.ESTADOCIVILGENERAL");
    OCIExecute($query, OCI_DEFAULT);
    while (OCIFetch($query))
    {
        echo"Usuario ------" .ociresult($query, "ESCG_ID").
            "<br>Contraseña-----".ociresult($query,"ESCG_DESCRIPCION").
            "<br><br>";
    }
    OCICommit($conn);
    OCILogoff($conn);
}