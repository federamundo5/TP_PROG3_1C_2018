<?php
require_once 'Empleado.php';
require_once 'IApiUsable.php';

class empleadoApi extends Empleado implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
     	$id=$args['id'];
    	$empleado=Empleado::TraerUnEmpleado($id);
     	$newResponse = $response->withJson($empleado, 200);  
    	return $newResponse;
    }
     public function TraerTodos($request, $response, $args) {
      	$empleados=Empleado::TraerTodosLosEmpleados();
     	$newResponse = $response->withJson($empleados, 200);  
    	return $newResponse;
	}
	

      public function CargarUno($request, $response, $args) {
     	 $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $nombre= $ArrayDeParametros['nombre'];
        $apellido= $ArrayDeParametros['apellido'];
        $sector= $ArrayDeParametros['sector'];
        
        $empleado = new Empleado();
        $empleado->nombre=$nombre;
        $empleado->apellido=$apellido;
        $empleado->sector=$sector;
        $empleado->InsertarEmpleado();

        $response->getBody()->write("se guardo el Empleado");

        return $response;
	}
	

      public function BorrarUno($request, $response, $args) {
     	$ArrayDeParametros = $request->getParsedBody();
     	$id=$ArrayDeParametros['idEmpleado'];
     	$empleado= new Empleado();
		 $empleado->idEmpleado=$id;
     	$cantidadDeBorrados=$empleado->BorrarEmpleado();

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
      	return $id;
    }
     
     public function ModificarUno($request, $response, $args) {
     	//$response->getBody()->write("<h1>Modificar  uno</h1>");
     	$ArrayDeParametros = $request->getParsedBody();
	    //var_dump($ArrayDeParametros);    	
	    $empleado = new Empleado();
		$empleado->idEmpleado=$ArrayDeParametros['idEmpleado'];
		$empleado->nombre=$ArrayDeParametros['nombre'];
	    $empleado->apellido=$ArrayDeParametros['apellido'];
	    $empleado->sector=$ArrayDeParametros['sector'];
	   	$resultado =$empleado->ModificarEmpleado();
	   	$objDelaRespuesta= new stdclass();
		//var_dump($resultado);
		$objDelaRespuesta->resultado=$resultado;
		return $response->withJson($objDelaRespuesta, 200);		
    }


}