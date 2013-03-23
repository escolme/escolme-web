<?php
require 'Slim/Slim.php';
require 'modelo/conexionBD.php';
require 'modelo/metodologia.php';
require 'modelo/programas.php';

$app = new Slim();

$app->get('/metodologias/listar', 'metodologiaListar');

$app->get('/programas/listar/:METO_ID', 'programasListar');

$app->run();
