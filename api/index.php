<?php
require 'Slim/Slim.php';
require 'modelo/modalidad.php';

$app = new Slim();

$app->get('/listar', 'modalidadListar');


$app->get('/prueba/:name', function ($name) {
    echo "Hello, $name";
});


$app->run();
