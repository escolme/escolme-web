<?php header('Content-Type: text/html; charset=utf-8');
require 'Slim/Slim.php';
require 'modelo/conexionBD.php';
require 'modelo/metodologia.php';
require 'modelo/programas.php';
require 'modelo/tipodocumento.php';

$app = new Slim();
$app->contentType('application/json;charset=utf-8');

$app->get('/metodologias/listar', 'metodologiaListar');

$app->get('/programas/listar/:METO_ID', 'programasListar');

$app->get('/tipodocumento/listar', 'tipodocumentoListar');

$app->run();
