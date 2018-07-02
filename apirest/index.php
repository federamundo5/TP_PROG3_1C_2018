<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../composer/vendor/autoload.php';
require 'clases/AccesoDatos.php';
require 'clases/empleadoApi.php';
require 'clases/encuestaApi.php';
require 'clases/ingresoApi.php';

require 'clases/pedidoApi.php';
require 'clases/mesaApi.php';
require 'clases/MWparaAutentificar.php';
require 'clases/AutentificadorJWT.php';
require 'clases/operacionesApi.php';




$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*
¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/

$app = new \Slim\App(["settings" => $config]);






$app->post('/login', function (Request $request, Response $response) {
  //$datos = array('usuario' => 'rogelio@agua.com','perfil' => 'profe', 'alias' => "PinkBoy");
  $ArrayDeParametros = $request->getParsedBody();
  $nombre= $ArrayDeParametros['nombre'];
  $clave= $ArrayDeParametros['clave'];
 
   $token= AutentificadorJWT::Login($nombre,$clave); 
   $newResponse = $response->withJson($token, 200); 
   return $newResponse;
 });



/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
$app->group('/empleado', function () {
 
  $this->get('/', \empleadoApi::class . ':traerTodos');
 
  $this->get('/{id}', \empleadoApi::class . ':traerUno');

  $this->post('/', \empleadoApi::class . ':CargarUno')->add(\MWparaAutentificar::class . ':VerificarSocio');


  $this->delete('/{id}', \empleadoApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarSocio');

  $this->delete('/Suspender/{id}', \empleadoApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':Suspension');


  $this->put('/{id}/{nombre}/{apellido}/{sector}/{clave}', \empleadoApi::class . ':ModificarUno');
     
});


/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
$app->group('/operaciones', function () {
 
  $this->get('/PorSector', \operacionesApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':OperacionesPorSector');

  $this->get('/', \operacionesApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':OperacionesEmpleados');

  $this->get('/PorSectorYEmpleado', \operacionesApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':OperacionesPorSectorYEmpleado');

     
})->add(\MWparaAutentificar::class . ':VerificarSocio');





/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
$app->group('/mesa', function () {
 
  $this->get('/', \mesaApi::class . ':traerTodos');

  $this->get('/traerMasUsadas', \mesaApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':MesasMasUsadas');


  $this->get('/traerMenosUsadas', \mesaApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':MesasMenosUsadas');


  $this->get('/{id}', \mesaApi::class . ':traerUno');

  $this->post('/', \mesaApi::class . ':CargarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');

  $this->post('/cambiarEstado', \mesaApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');

  $this->delete('/{id}', \mesaApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');

  $this->put('/{id}/{clave}/{idMozo}/{estado}', \mesaApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');
     
});


$app->group('/pedido', function () {
 
  $this->get('/', \pedidoApi::class . ':traerTodos');
 

  $this->get('/{clave}', \pedidoApi::class . ':traerUno');

  $this->get('/masVendidos/', \pedidoApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':MasVendidos');


  $this->get('/menosVendidos/', \pedidoApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':MenosVendidos');

  $this->get('/cancelados/', \pedidoApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':Cancelados');


  $this->post('/', \pedidoApi::class . ':CargarUno');


  $this->post('/cambiarEstado', \pedidoApi::class . ':ModificarUno');


  $this->delete('/{id}', \pedidoApi::class . ':BorrarUno');

  $this->put('/{id}/{estado}/{clave}/{horaPedido}/{idMesa}/{idEmpleado}/{tiempo}/{nombreEmpleado}', \pedidoApi::class . ':ModificarUno');
     
})->add(\MWparaAutentificar::class . ':VerificarUsuario');


$app->group('/encuesta', function () {
 
  $this->get('/', \encuestaApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':VerificarUsuario');
 
  $this->get('/{id}', \encuestaApi::class . ':traerUno');

  $this->post('/', \encuestaApi::class . ':CargarUno');

  $this->delete('/{id}', \encuestaApi::class . ':BorrarUno');

  $this->put('/{id}/{estado}/{clave}/{horaPedido}/{idMesa}/{idEmpleado}/{tiempo}/{nombreEmpleado}', \encuestaApi::class . ':ModificarUno');
     
});


$app->group('/ingreso', function () {
 
  $this->get('/', \ingresoApi::class . ':traerTodos');
 
  $this->get('/{id}', \ingresoApi::class . ':traerUno');

  $this->post('/', \ingresoApi::class . ':CargarUno');
     
})->add(\MWparaAutentificar::class . ':VerificarSocio');




$app->run();