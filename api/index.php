<?php
//include ("conexion.php");
require 'Slim/Slim.php';
require 'academico/modalidad.php';

$app = new Slim();

$app->get('/academico/modalidad/listar', 'modalidadListar');


$app->get('/prueba/:name', function ($name) {
    echo "Hello, $name";
});


$app->run();

?>