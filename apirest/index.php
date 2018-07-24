<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../composer/vendor/autoload.php';
require 'clases/AccesoDatos.php';
require 'clases/empleadoApi.php';
require 'clases/encuestaApi.php';
require 'clases/ingresoApi.php';
require 'clases/itemPedidoApi.php';

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

  $this->get('/MesasMenosImporte', \mesaApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':MesasMenosImporte');

  $this->get('/MesasMasImporte', \mesaApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':MesasMasImporte');

  $this->get('/MesaMayorFactura', \mesaApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':MesaMayorFactura');

  $this->get('/MesaMenorFactura', \mesaApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':MesaMenorFactura');

  $this->get('/PeoresComentarios', \mesaApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':PeoresComentarios');

  $this->get('/MejoresComentarios', \mesaApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':MejoresComentarios');

  $this->post('/PorMeses', \mesaApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':PorMeses');






  $this->get('/{id}', \mesaApi::class . ':traerUno');

  $this->post('/', \mesaApi::class . ':CargarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');

  $this->post('/cambiarEstado', \mesaApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');

  $this->delete('/{id}', \mesaApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');

  $this->put('/{id}/{clave}/{idMozo}/{estado}', \mesaApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');
     
});


$app->group('/pedido', function () {
 
  $this->get('/', \pedidoApi::class . ':traerTodos');

  $this->get('/{clave}/{claveMesa}', \pedidoApi::class . ':traerUno')->add(\MWparaAutentificar::class . ':TiempoRestante');

 

  $this->get('/{clave}', \pedidoApi::class . ':traerUno');

  $this->get('/masVendidos/', \pedidoApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':MasVendidos')->add(\MWparaAutentificar::class . ':VerificarUsuario');


  $this->get('/menosVendidos/', \pedidoApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':MenosVendidos')->add(\MWparaAutentificar::class . ':VerificarUsuario');

  $this->get('/cancelados/', \pedidoApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':Cancelados')->add(\MWparaAutentificar::class . ':VerificarUsuario');


  $this->post('/', \pedidoApi::class . ':CargarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');


  $this->post('/cambiarEstado', \pedidoApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaAutentificar::class . ':Cerrar');


  $this->delete('/{id}', \pedidoApi::class . ':BorrarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');

  $this->put('/{id}/{estado}/{clave}/{horaPedido}/{idMesa}/{idEmpleado}', \pedidoApi::class . ':ModificarUno')->add(\MWparaAutentificar::class . ':VerificarUsuario');
     
});



$app->group('/itemPedido', function () {
 
  $this->get('/', \itemPedidoApi::class . ':traerTodos');

  
  $this->get('/TraerNoEntregadosATiempo', \itemPedidoApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':TraerNoEntregadosATiempo');


  $this->get('/{idItem}', \itemPedidoApi::class . ':traerUno');

  $this->post('/', \itemPedidoApi::class . ':CargarUno');

  $this->post('/cambiarEstado', \itemPedidoApi::class . ':ModificarUno');

  $this->delete('/{id}', \itemPedidoApi::class . ':BorrarUno');

  $this->put('/{idItem}/{estado}/{sector}/{tiempo}/{descripcion}', \itemPedidoApi::class . ':ModificarUno');
     
})->add(\MWparaAutentificar::class . ':VerificarUsuario');





$app->group('/encuesta', function () {
 
  $this->get('/', \encuestaApi::class . ':traerTodos')->add(\MWparaAutentificar::class . ':VerificarUsuario');
 
  $this->get('/{id}', \encuestaApi::class . ':traerUno');

  $this->post('/', \encuestaApi::class . ':CargarUno');

 
});


$app->group('/ingreso', function () {
 
  $this->get('/', \ingresoApi::class . ':traerTodos');
 
  $this->get('/{id}', \ingresoApi::class . ':traerUno');

  $this->post('/', \ingresoApi::class . ':CargarUno');
     
})->add(\MWparaAutentificar::class . ':VerificarSocio');




$app->run();