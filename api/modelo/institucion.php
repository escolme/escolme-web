<?php

//Listar Instituciones Educativas
function institucionListar(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.INSTITUCION.INST_CODIGOSNP, ACADEMICO.INSTITUCION.INST_NOMBREINSTITUCION, ACADEMICO.IEM.INST_CODIGOSNP, ACADEMICO.INSTITUCION.TIIN_ID, ACADEMICO.INSTITUCION.INST_JORNADA, ACADEMICO.INSTITUCION.MUNI_IDINSTITUCION FROM ACADEMICO.IEM INNER JOIN ACADEMICO.INSTITUCION ON ACADEMICO.IEM.INST_CODIGOSNP = ACADEMICO.INSTITUCION.INST_CODIGOSNP WHERE (((ACADEMICO.INSTITUCION.TIIN_ID)='1')) ORDER BY ACADEMICO.INSTITUCION.INST_NOMBREINSTITUCION";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "INST_CODIGOSNP" => ociresult($query, "INST_CODIGOSNP"),
                "INST_NOMBREINSTITUCION" => ociresult($query, "INST_NOMBREINSTITUCION"),
                "INST_JORNADA" => ociresult($query, "INST_JORNADA")
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

function institucionListarPorFiltro($filtro){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.INSTITUCION.INST_CODIGOSNP, ACADEMICO.INSTITUCION.INST_NOMBREINSTITUCION, ACADEMICO.IEM.INST_CODIGOSNP, ACADEMICO.INSTITUCION.TIIN_ID, ACADEMICO.INSTITUCION.INST_JORNADA, ACADEMICO.INSTITUCION.MUNI_IDINSTITUCION FROM ACADEMICO.IEM INNER JOIN ACADEMICO.INSTITUCION ON ACADEMICO.IEM.INST_CODIGOSNP = ACADEMICO.INSTITUCION.INST_CODIGOSNP WHERE (((ACADEMICO.INSTITUCION.TIIN_ID)='1')) AND ACADEMICO.INSTITUCION.INST_NOMBREINSTITUCION LIKE '%".strtoupper($filtro)."%' ORDER BY ACADEMICO.INSTITUCION.INST_NOMBREINSTITUCION";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "INST_CODIGOSNP" => ociresult($query, "INST_CODIGOSNP"),
                "INST_NOMBREINSTITUCION" => ociresult($query, "INST_NOMBREINSTITUCION"),
                "INST_JORNADA" => ociresult($query, "INST_JORNADA")
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