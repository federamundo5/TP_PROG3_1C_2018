<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../composer/vendor/autoload.php';
require 'clases/AccesoDatos.php';
require 'clases/empleadoApi.php';
require 'clases/mesaApi.php';
require 'clases/MWAutentificarEmpleado.php';



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



$app->get('[/]', function (Request $request, Response $response) {    
  $response->getBody()->write("GET => Bienvenido!!! ,a SlimFramework");
  return $response;
});




/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
$app->group('/empleado', function () {
 
  $this->get('/', \empleadoApi::class . ':traerTodos');
 
  $this->get('/{id}', \empleadoApi::class . ':traerUno');

  $this->post('/', \empleadoApi::class . ':CargarUno') -> add(\MWparaAutentificarEmpleado::class . ':VerificarUsuario');

  $this->post('/ModificarUno', \empleadoApi::class . ':ModificarUno');

  $this->post('/BorrarUno', \empleadoApi::class . ':BorrarUno') -> add(\MWparaAutentificarEmpleado::class . ':VerificarUsuario');


  $this->delete('/', \empleadoApi::class . ':BorrarUno');

  $this->put('/', \empleadoApi::class . ':ModificarUno');
     
});



/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
$app->group('/mesa', function () {
 
  $this->get('/', \mesaApi::class . ':traerTodos');
 
  $this->get('/{id}', \mesaApi::class . ':traerUno');

  $this->post('/', \mesaApi::class . ':CargarUno');

  $this->delete('/', \mesaApi::class . ':BorrarUno');

  $this->put('/', \mesaApi::class . ':ModificarUno');
     
});


$app->run();