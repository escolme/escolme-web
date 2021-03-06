<?php
//Buscar existe aspirante

function ProgramasOrganizar(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO FROM (ACADEMICO.SERVICIOPERIODO INNER JOIN (ACADEMICO.SERVICIOPROGRAMA INNER JOIN ACADEMICO.PERIODOPROGRAMAUNIDAD ON ACADEMICO.SERVICIOPROGRAMA.PEPU_ID = ACADEMICO.PERIODOPROGRAMAUNIDAD.PEPU_ID) ON ACADEMICO.SERVICIOPERIODO.SEPE_ID = ACADEMICO.SERVICIOPROGRAMA.SEPE_ID) INNER JOIN (ACADEMICO.PERIODOUNIVERSIDAD INNER JOIN ((ACADEMICO.CONVOCATORIAINSCRIPCION INNER JOIN (((ACADEMICO.UNIDADPROGRAMA INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.UNIDADPROGRAMA.PROG_ID = ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.METODOLOGIA ON ACADEMICO.PROGRAMA.METO_ID = ACADEMICO.METODOLOGIA.METO_ID) INNER JOIN ACADEMICO.MODALIDAD ON ACADEMICO.PROGRAMA.MODA_ID = ACADEMICO.MODALIDAD.MODA_ID) ON ACADEMICO.CONVOCATORIAINSCRIPCION.UNPR_ID = ACADEMICO.UNIDADPROGRAMA.UNPR_ID) INNER JOIN (ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA INNER JOIN ACADEMICO.CIRCUNSCRIPCION ON ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA.CIRC_ID = ACADEMICO.CIRCUNSCRIPCION.CIRC_ID) ON ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ID = ACADEMICO.CIRCUNSCRIPCIONXUNIDADPROGRAMA.COIN_ID) ON ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.PEUN_ID) ON (ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.SERVICIOPERIODO.PEUN_ID) AND (ACADEMICO.PERIODOPROGRAMAUNIDAD.UNPR_ID = ACADEMICO.UNIDADPROGRAMA.UNPR_ID)  WHERE (((ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO)='ABIERTA')) ORDER BY ACADEMICO.PROGRAMA.PROG_NOMBRE";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "PROG_ID" => ociresult($query, "PROG_ID"),
                "PROG_NOMBRE" => ociresult($query, "PROG_NOMBRE"),
                "COIN_ESTADO" => ociresult($query, "COIN_ESTADO"),
                "PREINSCRITOS" => 0,
                "INSCRITOS" => 0,
                "ADMITIDOS" => 0,
                "TOTALES" => 0
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

function ContarPreinscritos(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION, ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO, Count(ACADEMICO.PROGRAMA.PROG_ID) AS CUENTAPROG_ID FROM (ACADEMICO.PERIODOUNIVERSIDAD INNER JOIN (((((ACADEMICO.FORMULARIOINSCRIPCION INNER JOIN ACADEMICO.ASPIRANTE ON ACADEMICO.FORMULARIOINSCRIPCION.ASPI_ID = ACADEMICO.ASPIRANTE.ASPI_ID) INNER JOIN ACADEMICO.PROGRAMAXFORMULARIO ON ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID = ACADEMICO.PROGRAMAXFORMULARIO.FOIN_ID) INNER JOIN ACADEMICO.UNIDADPROGRAMA ON ACADEMICO.PROGRAMAXFORMULARIO.UNPR_ID = ACADEMICO.UNIDADPROGRAMA.UNPR_ID) INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.UNIDADPROGRAMA.PROG_ID = ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.CONVOCATORIAINSCRIPCION ON ACADEMICO.UNIDADPROGRAMA.UNPR_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.UNPR_ID) ON ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.PEUN_ID) INNER JOIN ACADEMICO.SERVICIOPERIODO ON (ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.SERVICIOPERIODO.PEUN_ID) AND (ACADEMICO.FORMULARIOINSCRIPCION.SEPE_ID = ACADEMICO.SERVICIOPERIODO.SEPE_ID) GROUP BY ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION, ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO HAVING (((ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION)='PREINSCRITO') AND ((ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD)='1') AND ((ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO)='ABIERTA')) ORDER BY ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION DESC";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "PROG_NOMBRE" => ociresult($query, "PROG_NOMBRE"),
                "PROG_ID" => ociresult($query, "PROG_ID"),
                "FOIN_ESTADOADMISION" => ociresult($query, "FOIN_ESTADOADMISION"),
                "CUENTAPROG_ID" => ociresult($query, "CUENTAPROG_ID")
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

function ContarInscritos(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION, ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO, Count(ACADEMICO.PROGRAMA.PROG_ID) AS CUENTAPROG_ID FROM (ACADEMICO.PERIODOUNIVERSIDAD INNER JOIN (((((ACADEMICO.FORMULARIOINSCRIPCION INNER JOIN ACADEMICO.ASPIRANTE ON ACADEMICO.FORMULARIOINSCRIPCION.ASPI_ID = ACADEMICO.ASPIRANTE.ASPI_ID) INNER JOIN ACADEMICO.PROGRAMAXFORMULARIO ON ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID = ACADEMICO.PROGRAMAXFORMULARIO.FOIN_ID) INNER JOIN ACADEMICO.UNIDADPROGRAMA ON ACADEMICO.PROGRAMAXFORMULARIO.UNPR_ID = ACADEMICO.UNIDADPROGRAMA.UNPR_ID) INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.UNIDADPROGRAMA.PROG_ID = ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.CONVOCATORIAINSCRIPCION ON ACADEMICO.UNIDADPROGRAMA.UNPR_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.UNPR_ID) ON ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.PEUN_ID) INNER JOIN ACADEMICO.SERVICIOPERIODO ON (ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.SERVICIOPERIODO.PEUN_ID) AND (ACADEMICO.FORMULARIOINSCRIPCION.SEPE_ID = ACADEMICO.SERVICIOPERIODO.SEPE_ID) GROUP BY ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION, ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO HAVING (((ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION)='INSCRITO') AND ((ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD)='1') AND ((ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO)='ABIERTA')) ORDER BY ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION DESC";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "PROG_NOMBRE" => ociresult($query, "PROG_NOMBRE"),
                "PROG_ID" => ociresult($query, "PROG_ID"),
                "FOIN_ESTADOADMISION" => ociresult($query, "FOIN_ESTADOADMISION"),
                "CUENTAPROG_ID" => ociresult($query, "CUENTAPROG_ID")
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

function ContarAdmitidos(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION, ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO, Count(ACADEMICO.PROGRAMA.PROG_ID) AS CUENTAPROG_ID FROM (ACADEMICO.PERIODOUNIVERSIDAD INNER JOIN (((((ACADEMICO.FORMULARIOINSCRIPCION INNER JOIN ACADEMICO.ASPIRANTE ON ACADEMICO.FORMULARIOINSCRIPCION.ASPI_ID = ACADEMICO.ASPIRANTE.ASPI_ID) INNER JOIN ACADEMICO.PROGRAMAXFORMULARIO ON ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID = ACADEMICO.PROGRAMAXFORMULARIO.FOIN_ID) INNER JOIN ACADEMICO.UNIDADPROGRAMA ON ACADEMICO.PROGRAMAXFORMULARIO.UNPR_ID = ACADEMICO.UNIDADPROGRAMA.UNPR_ID) INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.UNIDADPROGRAMA.PROG_ID = ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.CONVOCATORIAINSCRIPCION ON ACADEMICO.UNIDADPROGRAMA.UNPR_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.UNPR_ID) ON ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.PEUN_ID) INNER JOIN ACADEMICO.SERVICIOPERIODO ON (ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.SERVICIOPERIODO.PEUN_ID) AND (ACADEMICO.FORMULARIOINSCRIPCION.SEPE_ID = ACADEMICO.SERVICIOPERIODO.SEPE_ID) GROUP BY ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION, ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO HAVING (((ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION)='ADMITIDO') AND ((ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD)='1') AND ((ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO)='ABIERTA')) ORDER BY ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION DESC";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "PROG_NOMBRE" => ociresult($query, "PROG_NOMBRE"),
                "PROG_ID" => ociresult($query, "PROG_ID"),
                "FOIN_ESTADOADMISION" => ociresult($query, "FOIN_ESTADOADMISION"),
                "CUENTAPROG_ID" => ociresult($query, "CUENTAPROG_ID")
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

function DetalleProgramaEstado($PROG_ID, $ESTADO){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION, ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO, ACADEMICO.JORNADANEW.JORN_DESCRIPCION, Count(ACADEMICO.JORNADANEW.JORN_DESCRIPCION) AS CUENTAJORNADA FROM ACADEMICO.JORNADANEW INNER JOIN ((ACADEMICO.PERIODOUNIVERSIDAD INNER JOIN (((((ACADEMICO.FORMULARIOINSCRIPCION INNER JOIN ACADEMICO.ASPIRANTE ON ACADEMICO.FORMULARIOINSCRIPCION.ASPI_ID = ACADEMICO.ASPIRANTE.ASPI_ID) INNER JOIN ACADEMICO.PROGRAMAXFORMULARIO ON ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID = ACADEMICO.PROGRAMAXFORMULARIO.FOIN_ID) INNER JOIN ACADEMICO.UNIDADPROGRAMA ON ACADEMICO.PROGRAMAXFORMULARIO.UNPR_ID = ACADEMICO.UNIDADPROGRAMA.UNPR_ID) INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.UNIDADPROGRAMA.PROG_ID = ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.CONVOCATORIAINSCRIPCION ON ACADEMICO.UNIDADPROGRAMA.UNPR_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.UNPR_ID) ON ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.PEUN_ID) INNER JOIN ACADEMICO.SERVICIOPERIODO ON (ACADEMICO.FORMULARIOINSCRIPCION.SEPE_ID = ACADEMICO.SERVICIOPERIODO.SEPE_ID) AND (ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.SERVICIOPERIODO.PEUN_ID)) ON ACADEMICO.JORNADANEW.JORN_ID = ACADEMICO.PROGRAMAXFORMULARIO.JORN_ID GROUP BY ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION, ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO, ACADEMICO.JORNADANEW.JORN_DESCRIPCION HAVING (((ACADEMICO.PROGRAMA.PROG_ID)=".$PROG_ID.") AND ((ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION)='".$ESTADO."') AND ((ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD)='1') AND ((ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO)='ABIERTA')) ORDER BY ACADEMICO.JORNADANEW.JORN_DESCRIPCION";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "PROG_NOMBRE" => ociresult($query, "PROG_NOMBRE"),
                "PROG_ID" => ociresult($query, "PROG_ID"),
                "FOIN_ESTADOADMISION" => ociresult($query, "FOIN_ESTADOADMISION"),
                "JORN_DESCRIPCION" => ociresult($query, "JORN_DESCRIPCION"),
                "CUENTAJORNADA" => ociresult($query, "CUENTAJORNADA"),
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

function DetalleProgramaEstadoListar($PROG_ID, $ESTADO){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION, ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD, ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO, ACADEMICO.JORNADANEW.JORN_DESCRIPCION, ACADEMICO.ASPIRANTE.ASPI_ID, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID, ACADEMICO.ASPIRANTE.ASPI_PRIMERAPELLIDO||' '|| ACADEMICO.ASPIRANTE.ASPI_SEGUNDOAPELLIDO ||' '|| ACADEMICO.ASPIRANTE.ASPI_PRIMERNOMBRE ||' '|| ACADEMICO.ASPIRANTE.ASPI_SEGUNDONOMBRE as NOMBRE, ACADEMICO.ASPIRANTE.ASPI_TELEFONORESIDENCIA, ACADEMICO.ASPIRANTE.ASPI_TELEFONOCELULAR, ACADEMICO.FORMULARIOINSCRIPCION.FOIN_FECHACAMBIO, ACADEMICO.REQUISITOASPIRANTENEW.REAS_FECHAREGISTRO, ACADEMICO.ENTREVISTANEW.ENTRE_FECHA FROM ((ACADEMICO.JORNADANEW INNER JOIN ((ACADEMICO.PERIODOUNIVERSIDAD INNER JOIN (((((ACADEMICO.FORMULARIOINSCRIPCION INNER JOIN ACADEMICO.ASPIRANTE ON ACADEMICO.FORMULARIOINSCRIPCION.ASPI_ID = ACADEMICO.ASPIRANTE.ASPI_ID) INNER JOIN ACADEMICO.PROGRAMAXFORMULARIO ON ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID = ACADEMICO.PROGRAMAXFORMULARIO.FOIN_ID) INNER JOIN ACADEMICO.UNIDADPROGRAMA ON ACADEMICO.PROGRAMAXFORMULARIO.UNPR_ID = ACADEMICO.UNIDADPROGRAMA.UNPR_ID) INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.UNIDADPROGRAMA.PROG_ID = ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.CONVOCATORIAINSCRIPCION ON ACADEMICO.UNIDADPROGRAMA.UNPR_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.UNPR_ID) ON ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.CONVOCATORIAINSCRIPCION.PEUN_ID) INNER JOIN ACADEMICO.SERVICIOPERIODO ON (ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.SERVICIOPERIODO.PEUN_ID) AND (ACADEMICO.FORMULARIOINSCRIPCION.SEPE_ID = ACADEMICO.SERVICIOPERIODO.SEPE_ID)) ON ACADEMICO.JORNADANEW.JORN_ID = ACADEMICO.PROGRAMAXFORMULARIO.JORN_ID) LEFT JOIN ACADEMICO.ENTREVISTANEW ON ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID = ACADEMICO.ENTREVISTANEW.FOIN_ID) LEFT JOIN ACADEMICO.REQUISITOASPIRANTENEW ON ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ID = ACADEMICO.REQUISITOASPIRANTENEW.FOIN_ID WHERE (((ACADEMICO.PROGRAMA.PROG_ID)=".$PROG_ID.") AND ((ACADEMICO.FORMULARIOINSCRIPCION.FOIN_ESTADOADMISION)='".$ESTADO."') AND ((ACADEMICO.PROGRAMAXFORMULARIO.PRXF_PRIORIDAD)='1') AND ((ACADEMICO.CONVOCATORIAINSCRIPCION.COIN_ESTADO)='ABIERTA')) ORDER BY ACADEMICO.PROGRAMA.PROG_NOMBRE";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "PROG_NOMBRE" => ociresult($query, "PROG_NOMBRE"),
                "PROG_ID" => ociresult($query, "PROG_ID"),
                "FOIN_ESTADOADMISION" => ociresult($query, "FOIN_ESTADOADMISION"),
                "JORN_DESCRIPCION" => ociresult($query, "JORN_DESCRIPCION"),
                "NOMBRE" => ociresult($query, "NOMBRE"),
                "ASPI_TELEFONORESIDENCIA" => ociresult($query, "ASPI_TELEFONORESIDENCIA"),
                "ASPI_TELEFONOCELULAR" => ociresult($query, "ASPI_TELEFONOCELULAR"),
                "FOIN_FECHACAMBIO" => ociresult($query, "FOIN_FECHACAMBIO"),
                "REAS_FECHAREGISTRO" => ociresult($query, "REAS_FECHAREGISTRO"),
                "ENTRE_FECHA" => ociresult($query, "ENTRE_FECHA"),
                "FECHA" => ''
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

function ProgramasMatriculaListar(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.MATRICULAACADEMICA.MAAC_ESTADO FROM ACADEMICO.CATEGORIA INNER JOIN (ACADEMICO.PERIODOUNIVERSIDAD INNER JOIN ((((ACADEMICO.PENSUM INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.PENSUM.PROG_ID = ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.ESTUDIANTEPENSUM ON ACADEMICO.PENSUM.PENS_ID = ACADEMICO.ESTUDIANTEPENSUM.PENS_ID) INNER JOIN ACADEMICO.MATRICULAACADEMICA ON ACADEMICO.ESTUDIANTEPENSUM.ESTP_ID = ACADEMICO.MATRICULAACADEMICA.ESTP_ID) INNER JOIN (GENERAL.PERSONAGENERAL INNER JOIN GENERAL.PERSONANATURALGENERAL ON GENERAL.PERSONAGENERAL.PEGE_ID = GENERAL.PERSONANATURALGENERAL.PEGE_ID) ON ACADEMICO.ESTUDIANTEPENSUM.PEGE_ID = GENERAL.PERSONANATURALGENERAL.PEGE_ID) ON ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.MATRICULAACADEMICA.PEUN_ID) ON ACADEMICO.CATEGORIA.CATE_ID = ACADEMICO.ESTUDIANTEPENSUM.CATE_ID GROUP BY ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.MATRICULAACADEMICA.MAAC_ESTADO HAVING ACADEMICO.MATRICULAACADEMICA.MAAC_ESTADO='ACTIVA' ORDER BY ACADEMICO.PROGRAMA.PROG_NOMBRE";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "PROG_ID" => ociresult($query, "PROG_ID"),
                "PROG_NOMBRE" => ociresult($query, "PROG_NOMBRE"),
                "NUEVOS" => 0,
                "ANTIGUOS" => 0,
                "REINGRESOS" => 0,
                "CANCELADOS" => 0,
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

function MatriculaNuevosPrograma(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.MATRICULAACADEMICA.MAAC_ESTADO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ANO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_PERIODO, ACADEMICO.CATEGORIA.CATE_ID, ACADEMICO.CATEGORIA.CATE_DESCRIPCION, Count(ACADEMICO.ESTUDIANTEPENSUM.ESTP_ID) AS CUENTA FROM ACADEMICO.CATEGORIA INNER JOIN (ACADEMICO.PERIODOUNIVERSIDAD INNER JOIN ((((ACADEMICO.PENSUM INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.PENSUM.PROG_ID = ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.ESTUDIANTEPENSUM ON ACADEMICO.PENSUM.PENS_ID = ACADEMICO.ESTUDIANTEPENSUM.PENS_ID) INNER JOIN ACADEMICO.MATRICULAACADEMICA ON ACADEMICO.ESTUDIANTEPENSUM.ESTP_ID = ACADEMICO.MATRICULAACADEMICA.ESTP_ID) INNER JOIN (GENERAL.PERSONAGENERAL INNER JOIN GENERAL.PERSONANATURALGENERAL ON GENERAL.PERSONAGENERAL.PEGE_ID = GENERAL.PERSONANATURALGENERAL.PEGE_ID) ON ACADEMICO.ESTUDIANTEPENSUM.PEGE_ID = GENERAL.PERSONANATURALGENERAL.PEGE_ID) ON ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.MATRICULAACADEMICA.PEUN_ID) ON ACADEMICO.CATEGORIA.CATE_ID = ACADEMICO.ESTUDIANTEPENSUM.CATE_ID GROUP BY ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.MATRICULAACADEMICA.MAAC_ESTADO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ANO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_PERIODO, ACADEMICO.CATEGORIA.CATE_ID, ACADEMICO.CATEGORIA.CATE_DESCRIPCION HAVING (((ACADEMICO.MATRICULAACADEMICA.MAAC_ESTADO)='ACTIVA') AND ((ACADEMICO.CATEGORIA.CATE_DESCRIPCION)='NUEVO REGULAR')) ORDER BY ACADEMICO.PROGRAMA.PROG_NOMBRE";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "PROG_ID" => ociresult($query, "PROG_ID"),
                "CUENTA" => ociresult($query, "CUENTA")
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

function MatriculaAntiguosPrograma(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.MATRICULAACADEMICA.MAAC_ESTADO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ANO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_PERIODO, ACADEMICO.CATEGORIA.CATE_ID, ACADEMICO.CATEGORIA.CATE_DESCRIPCION, Count(ACADEMICO.ESTUDIANTEPENSUM.ESTP_ID) AS CUENTA FROM ACADEMICO.CATEGORIA INNER JOIN (ACADEMICO.PERIODOUNIVERSIDAD INNER JOIN ((((ACADEMICO.PENSUM INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.PENSUM.PROG_ID = ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.ESTUDIANTEPENSUM ON ACADEMICO.PENSUM.PENS_ID = ACADEMICO.ESTUDIANTEPENSUM.PENS_ID) INNER JOIN ACADEMICO.MATRICULAACADEMICA ON ACADEMICO.ESTUDIANTEPENSUM.ESTP_ID = ACADEMICO.MATRICULAACADEMICA.ESTP_ID) INNER JOIN (GENERAL.PERSONAGENERAL INNER JOIN GENERAL.PERSONANATURALGENERAL ON GENERAL.PERSONAGENERAL.PEGE_ID = GENERAL.PERSONANATURALGENERAL.PEGE_ID) ON ACADEMICO.ESTUDIANTEPENSUM.PEGE_ID = GENERAL.PERSONANATURALGENERAL.PEGE_ID) ON ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.MATRICULAACADEMICA.PEUN_ID) ON ACADEMICO.CATEGORIA.CATE_ID = ACADEMICO.ESTUDIANTEPENSUM.CATE_ID GROUP BY ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.MATRICULAACADEMICA.MAAC_ESTADO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ANO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_PERIODO, ACADEMICO.CATEGORIA.CATE_ID, ACADEMICO.CATEGORIA.CATE_DESCRIPCION HAVING (((ACADEMICO.MATRICULAACADEMICA.MAAC_ESTADO)='ACTIVA') AND ((ACADEMICO.CATEGORIA.CATE_DESCRIPCION)='ANTIGUO')) ORDER BY ACADEMICO.PROGRAMA.PROG_NOMBRE";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "PROG_ID" => ociresult($query, "PROG_ID"),
                "CUENTA" => ociresult($query, "CUENTA")
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

function MatriculaReingresosPrograma(){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.MATRICULAACADEMICA.MAAC_ESTADO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ANO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_PERIODO, ACADEMICO.CATEGORIA.CATE_ID, ACADEMICO.CATEGORIA.CATE_DESCRIPCION, Count(ACADEMICO.ESTUDIANTEPENSUM.ESTP_ID) AS CUENTA FROM ACADEMICO.CATEGORIA INNER JOIN (ACADEMICO.PERIODOUNIVERSIDAD INNER JOIN ((((ACADEMICO.PENSUM INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.PENSUM.PROG_ID = ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.ESTUDIANTEPENSUM ON ACADEMICO.PENSUM.PENS_ID = ACADEMICO.ESTUDIANTEPENSUM.PENS_ID) INNER JOIN ACADEMICO.MATRICULAACADEMICA ON ACADEMICO.ESTUDIANTEPENSUM.ESTP_ID = ACADEMICO.MATRICULAACADEMICA.ESTP_ID) INNER JOIN (GENERAL.PERSONAGENERAL INNER JOIN GENERAL.PERSONANATURALGENERAL ON GENERAL.PERSONAGENERAL.PEGE_ID = GENERAL.PERSONANATURALGENERAL.PEGE_ID) ON ACADEMICO.ESTUDIANTEPENSUM.PEGE_ID = GENERAL.PERSONANATURALGENERAL.PEGE_ID) ON ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.MATRICULAACADEMICA.PEUN_ID) ON ACADEMICO.CATEGORIA.CATE_ID = ACADEMICO.ESTUDIANTEPENSUM.CATE_ID GROUP BY ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.MATRICULAACADEMICA.MAAC_ESTADO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ANO, ACADEMICO.PERIODOUNIVERSIDAD.PEUN_PERIODO, ACADEMICO.CATEGORIA.CATE_ID, ACADEMICO.CATEGORIA.CATE_DESCRIPCION HAVING (((ACADEMICO.MATRICULAACADEMICA.MAAC_ESTADO)='ACTIVA') AND ((ACADEMICO.CATEGORIA.CATE_DESCRIPCION)='NUEVO REINGRESO')) ORDER BY ACADEMICO.PROGRAMA.PROG_NOMBRE";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "PROG_ID" => ociresult($query, "PROG_ID"),
                "CUENTA" => ociresult($query, "CUENTA")
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

function MatriculaDetallePrograma($PROG_ID, $CATE_ID){
    try{
        $resultados = array();
        $conexion = new conexionBD();
        $conn = $conexion->conectar();
        $sql = "SELECT ACADEMICO.PROGRAMA.PROG_ID, ACADEMICO.CATEGORIA.CATE_ID, ACADEMICO.CATEGORIA.CATE_DESCRIPCION, ACADEMICO.PROGRAMA.PROG_NOMBRE, ACADEMICO.MATRICULAACADEMICA.MAAC_ESTADO, ACADEMICO.ESTUDIANTEPENSUM.ESTP_ID, GENERAL.PERSONANATURALGENERAL.PENG_PRIMERAPELLIDO ||' '|| GENERAL.PERSONANATURALGENERAL.PENG_SEGUNDOAPELLIDO ||' '|| GENERAL.PERSONANATURALGENERAL.PENG_PRIMERNOMBRE ||' '||GENERAL.PERSONANATURALGENERAL.PENG_SEGUNDONOMBRE as NOMBRE, GENERAL.PERSONAGENERAL.PEGE_MAIL, GENERAL.PERSONAGENERAL.PEGE_TELEFONOCELULAR, GENERAL.PERSONAGENERAL.PEGE_TELEFONO FROM ACADEMICO.CATEGORIA INNER JOIN (ACADEMICO.PERIODOUNIVERSIDAD INNER JOIN ((((ACADEMICO.PENSUM INNER JOIN ACADEMICO.PROGRAMA ON ACADEMICO.PENSUM.PROG_ID = ACADEMICO.PROGRAMA.PROG_ID) INNER JOIN ACADEMICO.ESTUDIANTEPENSUM ON ACADEMICO.PENSUM.PENS_ID = ACADEMICO.ESTUDIANTEPENSUM.PENS_ID) INNER JOIN ACADEMICO.MATRICULAACADEMICA ON ACADEMICO.ESTUDIANTEPENSUM.ESTP_ID = ACADEMICO.MATRICULAACADEMICA.ESTP_ID) INNER JOIN (GENERAL.PERSONAGENERAL INNER JOIN GENERAL.PERSONANATURALGENERAL ON GENERAL.PERSONAGENERAL.PEGE_ID = GENERAL.PERSONANATURALGENERAL.PEGE_ID) ON ACADEMICO.ESTUDIANTEPENSUM.PEGE_ID = GENERAL.PERSONANATURALGENERAL.PEGE_ID) ON ACADEMICO.PERIODOUNIVERSIDAD.PEUN_ID = ACADEMICO.MATRICULAACADEMICA.PEUN_ID) ON ACADEMICO.CATEGORIA.CATE_ID = ACADEMICO.ESTUDIANTEPENSUM.CATE_ID WHERE (((ACADEMICO.PROGRAMA.PROG_ID)=".$PROG_ID.") AND ((ACADEMICO.CATEGORIA.CATE_ID)=".$CATE_ID.") AND ((ACADEMICO.MATRICULAACADEMICA.MAAC_ESTADO)='ACTIVA')) ORDER BY NOMBRE";
        $query =OCIParse($conn, $sql);
        OCIExecute($query, OCI_DEFAULT);
        while (OCIFetch($query))
        {
            $fila = array(
                "CATE_DESCRIPCION" => ociresult($query, "CATE_DESCRIPCION"),
                "PROG_NOMBRE" => ociresult($query, "PROG_NOMBRE"),
                "NOMBRE" => ociresult($query, "NOMBRE"),
                "PEGE_MAIL" => ociresult($query, "PEGE_MAIL"),
                "PEGE_TELEFONOCELULAR" => ociresult($query, "PEGE_TELEFONOCELULAR"),
                "PEGE_TELEFONO" => ociresult($query, "PEGE_TELEFONO")
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