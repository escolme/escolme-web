<?php
/**
 * User: Jose Luis Orozco
 * Date: 15/03/13
 * Time: 11:23
 * Funciones de Acceso a Datos con la tabla modalidad del esquema modelo
 */

function modalidadListar(){
    //echo "Holas como estas";
    $user="modelo";
    $pass="ACA0369";
    $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.10.1.12)(PORT = 1521)))(CONNECT_DATA=(SID=ESCOLME)))";
    $conn=OCILogon($user, $pass, $db);
    if (!$conn){
        echo "Conexion es invalida" . var_dump (OCIError());
        die();
    }
    $query =OCIParse($conn, "Select * from ACADEMICO.MODALIDAD");
    OCIExecute($query, OCI_DEFAULT);
    while (OCIFetch($query))
    {
        echo"Id ------" .ociresult($query, "MODA_ID").
            "<br>Modalidad-----".ociresult($query,"MODA_DESCRIPCION").
            "<br><br>";
    }
    OCICommit($conn);
    OCILogoff($conn);
}