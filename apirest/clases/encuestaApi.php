<?php
require_once 'Encuesta.php';
require_once 'IApiUsable.php';

class encuestaApi extends Encuesta implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
     	$id=$args['id'];
    	$encuesta=encuesta::TraerUnencuesta($id);
     	$newResponse = $response->withJson($encuesta, 200);  
    	return $newResponse;
    }
     public function TraerTodos($request, $response, $args) {
      	$encuestas=encuesta::TraerTodasLasEncuestas();
     	$newResponse = $response->withJson($encuestas, 200);  
    	return $newResponse;
	}
	

      public function CargarUno($request, $response, $args) {
     	 $ArrayDeParametros = $request->getParsedBody();
		  $experiencia= $ArrayDeParametros['experiencia'];
		  $idMozo= $ArrayDeParametros['idMozo'];
		  $idCocinero= $ArrayDeParametros['idCocinero'];
		  $puntuacionMozo= $ArrayDeParametros['puntuacionMozo'];
		  $puntuacionRestaurante= $ArrayDeParametros['puntuacionRestaurante'];
		  $puntuacionMesa= $ArrayDeParametros['puntuacionMesa'];
		  $puntuacionCocinero= $ArrayDeParametros['puntuacionCocinero'];
  
  
		  
		  $encuesta = new Encuesta();
		  $encuesta->experiencia=$experiencia;
		  $encuesta->idMozo=$idMozo;
		  $encuesta->idCocinero=$idCocinero;
		  $encuesta->puntuacionMozo=$puntuacionMozo;
		  $encuesta->puntuacionRestaurante=$puntuacionRestaurante;
		  $encuesta->puntuacionCocinero=$puntuacionCocinero;
		  $encuesta->puntuacionMesa=$puntuacionMesa;
  

        $encuesta->InsertarEncuesta();

        $response->getBody()->write("se guardo el encuesta");

        return $response;
	}
	

      public function BorrarUno($request, $response, $args) {
		 $id=$args['id'];
     	$encuesta= new encuesta();
		 $encuesta->idencuesta=$id;
     	$cantidadDeBorrados=$encuesta->Borrarencuesta();

     	$objDelaRespuesta= new stdclass();
	    $objDelaRespuesta->cantidad=$cantidadDeBorrados;
	    if($cantidadDeBorrados>0)
	    	{
	    		 $objDelaRespuesta->resultado="algo borro!!!";
	    	}
	    	else
	    	{
	    		$objDelaRespuesta->resultado="no Borro nada!!!";
	    	}
	    $newResponse = $response->withJson($objDelaRespuesta, 200);  
      	return $newResponse;
    }
     
     public function ModificarUno($request, $response, $args) {
     	//$response->getBody()->write("<h1>Modificar  uno</h1>");
	    //var_dump($ArrayDeParametros);    	
		$encuesta = new encuesta();


		$encuesta->idencuesta=$args['id'];
		$encuesta->estado=$args['estado'];
	    $encuesta->clave=$args['clave'];
		$encuesta->horaencuesta=$args['horaencuesta'];

		$encuesta->idMesa=$args['idMesa'];
		$encuesta->idEmpleado=$args['idEmpleado'];
		$encuesta->tiempo=$args['tiempo'];
		$encuesta->nombreEmpleado=$args['nombreEmpleado'];

		
	   	$resultado =$encuesta->Modificarencuesta();
	   	$objDelaRespuesta= new stdclass();
		//var_dump($resultado);
		$objDelaRespuesta->resultado=$resultado;
		return $response->withJson($objDelaRespuesta, 200);		
    }


}