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
require 'modelo/niveleducativo.php';
require 'modelo/circusncripcion.php';
require 'modelo/usuario.php';


require 'modeloInventarios/productos.php';
require 'modeloInventarios/categoria_productos.php';


$app = new Slim();
/*
RUTAS DE ACADEMUSOFT
*/
$app->contentType('application/json;charset=utf-8');
$app->get('/metodologias/listar', 'metodologiaListar');
$app->get('/programas/listar/:METO_ID/:NIED_ID', 'programasListar');
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
$app->get('/niveleducativo/listar/:METO_ID', 'niveleducativoListar');
$app->get('/programas/adicional/:PROG_ID', 'programasAdicional');
$app->get('/buscar/aspiid/:ASPI_NUMERODOCUMENTO/:NIED_ID', 'BuscarExisteAspirante');
$app->get('/buscar/formulario/:ASPI_ID', 'BuscarExisteFormulario');
$app->get('/buscar/inscripcion/:ASPI_NUMERODOCUMENTO', 'BuscarExisteInscripcion');
$app->get('/actualizar/circunscripcion/:CIRC_ID/:ASPI_ID', 'ActualizarCircunscripcion');
$app->get('/usuario/buscar/:usua_usuario/:usua_contrasena', 'BuscarUsuario');

$app->post('/insertar/aspirantenew','InsertarAspirante');
$app->post('/insertar/formularioinscripcionnew','InsertarFormulario');
$app->post('/insertar/programaxformulario','InsertarPrograma');
$app->post('/insertar/estudiossecundariosnew','InsertarEstudiosSecundarios');
$app->post('/insertar/caracterizacionnew','InsertarCaracterizacion');
$app->post('/insertar/socioeconomica','InsertarInformacionSocioeconomica');


/*
RUTAS DE INVENTARIOS
*/


//$app->get('/inventarios/productos/listar', 'productosListar');
//$app->get('/pedidos/categoria/listar', 'categoriaListar');
//$app->get('/pedidos/proxcate/listar/:id_categoria_producto', 'productosCategoria');


//RUTAS DE INVENTARIOS



//$app->get('/productos/quitarporid/:id_producto', 'productosQuitarPorId');
//$app->get('/productos/cargarporid/:id_producto', 'productosCargarPorId');
//$app->get('/inventarios/productos/listar', 'productosListar');
//$app->get('/pedidos/categoria/listar', 'categoriaListar');
//$app->get('/pedidos/proxcate/listar/:id_categoria_producto', 'productosCategoria');
//$app->get('/registro/proxcate/listar/:id_categoria_producto', 'productosCategoria');
//$app->get('/registro/categoria2/listar', 'categoriaListar');


$app->get('/inventarios/productos/listar', 'productosListar');
$app->get('/pedidos/categoria/listar', 'categoriaListar');
$app->get('/pedidos/proxcate/listar/:id_categoria_producto', 'productosCategoria');
$app->get('/productos/quitarporid/:id_producto', 'productosQuitarPorId');
$app->get('/productos/cargarporid/:id_producto', 'productosCargarPorId');
$app->get('/registro/proxcate/listar/:id_categoria_producto', 'productosCategoria');
$app->get('/registro/categoria2/listar', 'categoriaListar');
$app->run();