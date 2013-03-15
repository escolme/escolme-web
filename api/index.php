<?php
//include ("conexion.php");
require 'Slim/Slim.php';

$app = new Slim();

$app->get('/academico/modalidad/listar', 'listarModalidades');
$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});
//$app->get('/wines/:id',	'getWine');


$app->run();

function listarModalidades() {
	//$sql = "select * FROM academico.modalidad";
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


/*
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"wine": ' . json_encode($wines) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}*/
}

?>