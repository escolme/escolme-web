<?php
//Insertar en Tabla PROGRAMAXFORMULARIO
function InsertarPrograma($inscripcion){
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO PROGRAMAXFORMULARIONEW (PRXF_PRIORIDAD, FOIN_ID, PRXF_PUNTAJEOBTENIDO, PRXF_PUESTO, PRXF_FECHACAMBIO, UNPR_ID, COIN_ID, PRXF_REGISTRADOPOR) VALUES(:dato1, :dato2, :dato3, :dato4, :dato5, :dato6, :dato7, :dato8)";
        $query =OCIParse($conn, $sql);
        OCIBindByName($query, ":dato1",'');
        OCIBindByName($query, ":dato2",'');
        OCIBindByName($query, ":dato3",'');
        OCIBindByName($query, ":dato4",'');
        OCIBindByName($query, ":dato5",'');
        OCIBindByName($query, ":dato6",'');
        OCIBindByName($query, ":dato7",'');
        OCIBindByName($query, ":dato8",'');
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}