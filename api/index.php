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
require 'modelo/aspirantenew.php';
require 'modelo/formularioinscripcionnew.php';
require 'modelo/programaxformulario.php';
require 'modelo/estudiossecundarios.php';
require 'modelo/caracterizacion.php';
require 'modelo/informacionsocioeconomica.php';

require 'modeloinventarios/productos.php';
require 'modeloinventarios/categoria_productos.php';

$app = new Slim();
/*
RUTAS DE ACADEMUSOFT
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
$app->get('/programas/adicional/:PROG_ID', 'programasAdicional');
$app->get('/buscar/aspiid/:ASPI_NUMERODOCUMENTO', 'BuscarExisteAspirante');
$app->get('/buscar/formulario/:ASPI_ID', 'BuscarExisteFormulario');

$app->post('/insertar/aspirantenew','InsertarAspirante');
$app->post('/insertar/formularioinscripcionnew','InsertarFormulario');
$app->post('/insertar/programaxformulario','InsertarPrograma');
$app->post('/insertar/estudiossecundariosnew','InsertarEstudiosSecundarios');
$app->post('/insertar/caracterizacionnew','InsertarCaracterizacion');
$app->post('/insertar/socioeconomica','InsertarInformacionSocioeconomica');
/*
RUTAS DE INVENTARIOS
*/
$app->get('/inventarios/productos/listar', 'productosListar');
$app->get('/pedidos/categoria/listar', 'categoriaListar');
$app->get('/pedidos/proxcate/listar/:id_categoria_producto', 'productosCategoria');
$app->run();