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
    $request = Slim::getInstance()->request();
    $inscripcion = json_decode($request->getBody());
    $fecha=date("d-m-Y");


    /*try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "INSERT INTO ACADEMICO.ZPRUEBAS(ASPI_ID,ASPI_NUMERODOCUMENTO) VALUES (6,'".$inscripcion->ASPI_SEGUNDOAPELLIDO."')";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
        echo utf8_encode('{"datos": ' . json_encode($sql) . '}');
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }

    //echo utf8_encode('{"datos": ' . json_encode("sa") . '}');
    //echo utf8_encode($inscripcion[0]->ASPI_NUMERODOCUMENTO);
     //var_dump($inscripcion);
   // echo utf8_encode('{"datos": ' . json_encode($inscripcion) . '}');
   // echo ($inscripcion.'ASPI_PRIMERAPELLIDO');
    //console.dir('$inscripcion.ASPI_PRIMERAPELLIDO');
    //console.dir($inscripcion.ASPI_NUMERODOCUMENTO);*/
    try{
        $conexion = new conexionBD();
        $conn = $conexion->conectar();

     //$sql = "INSERT INTO ACADEMICO.ASPIRANTENEW (ASPI_PRIMERAPELLIDO,ASPI_SEGUNDOAPELLIDO,ASPI_PRIMERNOMBRE,ASPI_SEGUNDONOMBRE,ASPI_TIPODOCUMENTO, ASPI_NUMERODOCUMENTO,ASPI_FECHACAMBIO,ASPI_REGISTRADOPOR)
     //VALUES('asdfas','asdf','asdfsaf','asdfasfd','adsfasf',1,'5435435','25-01-2013','prueba')";

    //$sql = "INSERT INTO ACADEMICO.ASPIRANTENEW (ASPI_PRIMERAPELLIDO,ASPI_SEGUNDOAPELLIDO,ASPI_PRIMERNOMBRE,ASPI_SEGUNDONOMBRE,ASPI_TIPODOCUMENTO, ASPI_NUMERODOCUMENTO,ASPI_FECHACAMBIO,ASPI_REGISTRADOPOR)
    //VALUES('asdf','asdfsaf','asdfasfd','adsfasf',1,'5435435',TO_DATE('25/01/13','DD/MM/RR'),'prueba')";

        //$sql = "INSERT INTO ACADEMICO.ASPIRANTENEW (ASPI_PRIMERAPELLIDO,ASPI_SEGUNDOAPELLIDO,ASPI_PRIMERNOMBRE,ASPI_SEGUNDONOMBRE,ASPI_TIPODOCUMENTO, ASPI_NUMERODOCUMENTO,ASPI_SEXO,ASPI_PAISRESIDENCIA,ASPI_DPTORESIDENCIA,ASPI_MPIORESIDENCIA,ASPI_TELEFONORESIDENCIA,ASPI_TELEFONOCELULAR,ASPI_EMAIL,ASPI_FECHANACIMIENTO,ASPI_PAISNACIMIENTO,ASPI_DPTONACIMIENTO,ASPI_MPIONACIMIENTO,ASPI_FECHACAMBIO,ESCG_ID,ASPI_REGISTRADOPOR,MEDI_IDCONOCEINSTITUCION,JORN_ID,JORN_ID2)
        //VALUES(:dato1, :dato2, :dato3, :dato4, :dato5, :dato6, :dato7, :dato8, :dato9, :dato10, :dato11, :dato12, :dato13, :dato14, :dato15, :dato16, :dato17, :dato18, :dato19, :dato20, :dato21, :dato22, :dato23)";

        //$sql = "INSERT INTO ACADEMICO.ASPIRANTENEW (ASPI_PRIMERAPELLIDO,ASPI_SEGUNDOAPELLIDO,ASPI_PRIMERNOMBRE,ASPI_SEGUNDONOMBRE,ASPI_TIPODOCUMENTO, ASPI_NUMERODOCUMENTO,ASPI_FECHACAMBIO,ASPI_REGISTRADOPOR)
        //VALUES('".$inscripcion.ASPI_PRIMERAPELLIDO."','".$inscripcion.ASPI_SEGUNDOAPELLIDO."','".$inscripcion.ASPI_PRIMERNOMBRE."','".$inscripcion.ASPI_SEGUNDONOMBRE."',".$inscripcion.TIDG_ID.
        //",'".$inscripcion.ASPI_NUMERODOCUMENTO."',TO_DATE('".$inscripcion.ASPI_FECHANACIMIENTO."','DD/MM/RR'),'".$inscripcion.ASPI_NUMERODOCUMENTO."')";

        //$sql = "INSERT INTO ACADEMICO.ASPIRANTENEW (ASPI_PRIMERAPELLIDO,ASPI_SEGUNDOAPELLIDO,ASPI_PRIMERNOMBRE,ASPI_SEGUNDONOMBRE,ASPI_TIPODOCUMENTO, ASPI_NUMERODOCUMENTO,ASPI_FECHACAMBIO,ASPI_REGISTRADOPOR)
        //VALUES('".$inscripcion->ASPI_PRIMERAPELLIDO."','".$inscripcion->ASPI_SEGUNDOAPELLIDO."','".$inscripcion->ASPI_PRIMERNOMBRE."','".$inscripcion->ASPI_SEGUNDONOMBRE."',".$inscripcion->TIDG_ID.
        //",'".$inscripcion->ASPI_NUMERODOCUMENTO."','25/01/13','".$inscripcion->ASPI_NUMERODOCUMENTO."')";


        $sql = "INSERT INTO ACADEMICO.ASPIRANTENEW (ASPI_PRIMERAPELLIDO,ASPI_SEGUNDOAPELLIDO,ASPI_PRIMERNOMBRE,ASPI_SEGUNDONOMBRE,ASPI_TIPODOCUMENTO, ASPI_NUMERODOCUMENTO,ASPI_SEXO,ASPI_PAISRESIDENCIA,ASPI_DPTORESIDENCIA,ASPI_MPIORESIDENCIA,ASPI_TELEFONORESIDENCIA,ASPI_TELEFONOCELULAR,ASPI_EMAIL,ASPI_FECHANACIMIENTO,ASPI_PAISNACIMIENTO,ASPI_DPTONACIMIENTO,ASPI_MPIONACIMIENTO,ASPI_FECHACAMBIO,ESCG_ID,ASPI_REGISTRADOPOR,MEDI_IDCONOCEINSTITUCION,JORN_ID,JORN_ID2, CIRC_ID,NIED_ID)
        VALUES('".$inscripcion->ASPI_PRIMERAPELLIDO."','".$inscripcion->ASPI_SEGUNDOAPELLIDO."','".$inscripcion->ASPI_PRIMERNOMBRE."','".$inscripcion->ASPI_SEGUNDONOMBRE."',".$inscripcion->TIDG_ID.
        ",'".$inscripcion->ASPI_NUMERODOCUMENTO."','".$inscripcion->ASPI_SEXO."','".$inscripcion->PAGE_ID2."','".$inscripcion->DEGE_ID2."','".$inscripcion->CIGE_ID2."','".$inscripcion->ASPI_TELEFONORESIDENCIA.
        "','".$inscripcion->ASPI_TELEFONOCELULAR."','".$inscripcion->ASPI_EMAIL."','".$inscripcion->ASPI_FECHANACIMIENTO_S."','".$inscripcion->PAGE_ID."','".$inscripcion->DEGE_ID."','".$inscripcion->CIGE_ID.
        "','".$fecha."',".$inscripcion->ESCG_ID.",'".$inscripcion->ASPI_NUMERODOCUMENTO."',".$inscripcion->OMED_ID.",".$inscripcion->JORN_ID.",".$inscripcion->JORN_ID2.",".$inscripcion->CIRC_ID.",".$inscripcion->NIED_ID.")";
        echo utf8_encode('{"datos": ' . json_encode($sql) . '}');

     /*OCIBindByName($query, ":dato1",'$inscripcion.ASPI_PRIMERAPELLIDO');
        OCIBindByName($query, ":dato2",'$inscripcion.ASPI_SEGUNDOAPELLIDO');
        OCIBindByName($query, ":dato3",'$inscripcion.ASPI_PRIMERNOMBRE');
        OCIBindByName($query, ":dato4",'$inscripcion.ASPI_SEGUNDONOMBRE');
        OCIBindByName($query, ":dato5",'$inscripcion.TIDG_ID');
        OCIBindByName($query, ":dato6",'$inscripcion.ASPI_NUMERODOCUMENTO');
        OCIBindByName($query, ":dato7",'$inscripcion.ASPI_SEXO');
        OCIBindByName($query, ":dato8",'$inscripcion.PAGE_ID2');
        OCIBindByName($query, ":dato9",'$inscripcion.DEGE_ID2');
        OCIBindByName($query, ":dato10",'$inscripcion.CIGE_ID2');
        OCIBindByName($query, ":dato11",'$inscripcion.ASPI_TELEFONORESIDENCIA');
        OCIBindByName($query, ":dato12",'$inscripcion.ASPI_TELEFONOCELULAR');
        OCIBindByName($query, ":dato13",'$inscripcion.ASPI_EMAIL');
        OCIBindByName($query, ":dato14",'$inscripcion.ASPI_FECHANACIMIENTO');
        OCIBindByName($query, ":dato15",'$inscripcion.PAGE_ID');
        OCIBindByName($query, ":dato16",'$inscripcion.DEGE_ID');
        OCIBindByName($query, ":dato17",'$inscripcion.CIGE_ID');
        OCIBindByName($query, ":dato18",'$inscripcion.ASPI_FECHANACIMIENTO');
        OCIBindByName($query, ":dato19",'$inscripcion.ESCG_ID');
        OCIBindByName($query, ":dato20",'$inscripcion.ASPI_NUMERODOCUMENTO');
        OCIBindByName($query, ":dato21",'$inscripcion.OMED_ID');
        OCIBindByName($query, ":dato22",'$inscripcion.JORN_ID');
        OCIBindByName($query, ":dato23",'$inscripcion.JORN_ID2');
        OCIBindByName($query, ":dato23",'$inscripcion.CIRC_ID'
        OCIBindByName($query, ":dato23",'$inscripcion.NIED_ID'*/
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        OCICommit($conn);
        OCILogoff($conn);
    }
    catch(Exception $e){
        OCILogoff($conn);
        echo '{"error: ":' . $e->getMessage() . '}';
    }
}