<?php
//Buscar existe aspirante
function BuscarExisteAspirante(){ //faltaria el parametro que recibe
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.ASPIRANTE.ASPI_NUMERODOCUMENTO, ACADEMICO.ASPIRANTE.ASPI_ID FROM ACADEMICO.ASPIRANTE";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "ASPI_NUMERODOCUMENTO" => ociresult($query, "ASPI_NUMERODOCUMENTO"),
                "ASPI_ID" => ociresult($query, "ASPI_ID")
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
//Buscar existe inscripcion
function BuscarExisteInscripcion(){ //faltaria el parametro que recibe
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.FORMULARIOINSCRIPCION.ASPI_ID, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID, ACADEMICO.PROGRAMAXFORMULARIO.PRXF_ID, ACADEMICO.PROGRAMAXFORMULARIO.COIN_ID FROM ACADEMICO.FORMULARIOINSCRIPCION INNER JOIN ACADEMICO.PROGRAMAXFORMULARIO ON ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID = ACADEMICO.PROGRAMAXFORMULARIO.FOIN_ID";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "ASPI_ID" => ociresult($query, "ASPI_ID")
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

//Insertar en Tabla ASPIRANTENEW
function InsertarAspirante(){
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO ACADEMICO.ASPIRANTENEW (ASPI_PRIMERAPELLIDO, ASPI_SEGUNDOAPELLIDO, ASPI_PRIMERNOMBRE, ASPI_SEGUNDONOMBRE, ASPI_TIPODOCUMENTO, ASPI_NUMERODOCUMENTO, ASPI_SEXO, ASPI_PAISRESIDENCIA, ASPI_DPTORESIDENCIA, ASPI_MPIORESIDENCIA, ASPI_TELEFONORESIDENCIA, ASPI_TELEFONOCELULAR, ASPI_EMAIL, ASPI_FECHANACIMIENTO, ASPI_PAISNACIMIENTO, ASPI_DPTONACIMIENTO, ASPI_MPIONACIMIENTO, ASPI_FECHACAMBIO, ESCG_ID, ASPI_REGISTRADOPOR, MEDI_IDCONOCEINSTITUCION, JORN_ID) VALUES(:dato1, :dato2, :dato3, :dato4, :dato5, :dato6, :dato7, :dato8, :dato9, :dato10, :dato11, :dato12, :dato13, :dato14, :dato15, :dato16, :dato17, :dato18, :dato19, :dato20, :dato21, :dato22, :dato23)";
        $query =OCIParse($conn, $sql);
        OCIBindByName($query, ":dato1",'');
        OCIBindByName($query, ":dato2",'');
        OCIBindByName($query, ":dato3",'');
        OCIBindByName($query, ":dato4",'');
        OCIBindByName($query, ":dato5",'inscripcion.TIDG_ID');
        OCIBindByName($query, ":dato6",'');
        OCIBindByName($query, ":dato7",'');
        OCIBindByName($query, ":dato8",'inscripcion.PAGE_ID2');
        OCIBindByName($query, ":dato9",'inscripcion.DEGE_ID2');
        OCIBindByName($query, ":dato10",'inscripcion.CIGE_ID2');
        OCIBindByName($query, ":dato11",'');
        OCIBindByName($query, ":dato12",'');
        OCIBindByName($query, ":dato13",'');
        OCIBindByName($query, ":dato14",'');
        OCIBindByName($query, ":dato15",'inscripcion.PAGE_ID');
        OCIBindByName($query, ":dato16",'inscripcion.DEGE_ID');
        OCIBindByName($query, ":dato17",'inscripcion.CIGE_ID');
        OCIBindByName($query, ":dato18",'');
        OCIBindByName($query, ":dato19",'inscripcion.ESCG_ID');
        OCIBindByName($query, ":dato20",'');
        OCIBindByName($query, ":dato21",'inscripcion.OMED_ID');
        OCIBindByName($query, ":dato22",'inscripcion.JORN_ID');
        OCIBindByName($query, ":dato23",'inscripcion.JORN_ID2');
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}