<?php
//Insertar en Tabla FORMULARIOINSCRIPCION
function InsertarFormulario(){
    $request = Slim::getInstance()->request();
    $inscripcion = json_decode($request->getBody());
    //echo utf8_encode('{"datos2": ' . json_encode($inscripcion) . '}');
    $fecha=date("d-m-Y");
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO ACADEMICO.FORMULARIOINSCRIPCION (ASPI_ID, FOIN_PROGRAMAADMITIDO, FOIN_MEDIOINSCRIPCION,FOIN_FECHAHORAVERIFICACION, FOIN_REGISTRADOPOR, FOIN_FECHACAMBIO, TIIN_ID,FOIN_ESTADOADMISION ,SEPE_ID)
        VALUES(".$inscripcion->ASPI_ID.",'0','ON LINE','".$fecha."','".$inscripcion->ASPI_NUMERODOCUMENTO."','".$fecha."',1,'PREINSCRITO',".$inscripcion->SEPE_ID.")";
        //echo utf8_encode('{"datos2-": ' . json_encode($sql) . '}');
        //$query =OCIParse($conn, $sql);
        //OCIExecute($query, OCI_DEFAULT);
        //OCICommit($conn);
        OCILogoff($conn);
        echo '{"mensaje: ":"Exito"}';
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}
function BuscarExisteFormulario($ASPI_ID){
        try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.FORMULARIOINSCRIPCION.ASPI_ID,ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID FROM ACADEMICO.FORMULARIOINSCRIPCION WHERE ASPI_ID=".$ASPI_ID;
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "ASPI_ID" => ociresult($query, "ASPI_ID"),
                "FOIN_ID" => ociresult($query, "FOIN_ID")
            );
            array_push($resultados, $fila);
        }
        echo utf8_encode('{"datos": ' . json_encode($resultados) . '}');
        OCILogoff($conn);
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}