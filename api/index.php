<?php header('Content-Type: text/html; charset=utf-8');
require 'Slim/Slim.php';
require 'modelo/conexionBD.php';
require 'modelo/metodologia.php';
require 'modelo/programas.php';
require 'modelo/tipodocumento.php';
require 'modelo/pais.php';
require 'modelo/departamento.php';
require 'modelo/ciudad.php';
require 'modelo/estadocivil.php';
require 'modelo/estrato.php';
require 'modelo/medio.php';
require 'modelo/institucion.php';
require 'modelo/horario.php';

require 'modeloInventarios/productos.php';

$app = new Slim();

/*
RUTAS DE ACADEMUSOT
*/
$app->contentType('application/json;charset=utf-8');
$app->get('/metodologias/listar', 'metodologiaListar');
$app->get('/programas/listar/:METO_ID', 'programasListar');
$app->get('/tipodocumento/listar', 'tipodocumentoListar');
$app->get('/pais/listar', 'paisListar');
$app->get('/departamento/listar/:PAGE_ID', 'departamentoListar');
$app->get('/ciudad/listar/:DEGE_ID', 'ciudadListar');
$app->get('/estadocivil/listar', 'estadocivilListar');
$app->get('/estrato/listar', 'estratoListar');
$app->get('/medio/listar', 'medioListar');
$app->get('/institucion/listar', 'institucionListar');
$app->get('/institucion/listarporfiltro/:filtro', 'institucionListarPorFiltro');
$app->get('/horario/listar', 'horarioListar');


/*
RUTAS DE INVENTARIOS
*/
$app->get('/inventarios/productos/listar', 'productosListar');

$app->run();
