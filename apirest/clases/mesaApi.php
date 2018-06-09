<?php
require_once 'Mesa.php';
require_once 'IApiUsable.php';

class mesaApi extends Mesa implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
     	$id=$args['id'];
    	$mesa=Mesa::TraerUnaMesa($id);
     	$newResponse = $response->withJson($mesa, 200);  
    	return $newResponse;
    }
     public function TraerTodos($request, $response, $args) {
      	$empleados=Mesa::TraerTodasLasMesas();
     	$newResponse = $response->withJson($empleados, 200);  
    	return $newResponse;
	}
	

      public function CargarUno($request, $response, $args) {
     	 $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $clave= $ArrayDeParametros['Clave'];
        
        $mesa = new Mesa();
        $mesa->Clave=$clave;
        $mesa->InsertarMesa();

        $response->getBody()->write("se guardo la mesa");

        return $response;
	}
	

      public function BorrarUno($request, $response, $args) {
     	$ArrayDeParametros = $request->getParsedBody();
     	$id=$ArrayDeParametros['idMesa'];
     	$mesa= new Mesa();
		 $mesa->IdMesa=$id;
     	$cantidadDeBorrados=$mesa->BorrarMesa();

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
     	$ArrayDeParametros = $request->getParsedBody();
	    //var_dump($ArrayDeParametros);    	
	    $mesa = new Mesa();
		$mesa->IdMesa=$ArrayDeParametros['idMesa'];
	    $mesa->Clave=$ArrayDeParametros['clave'];
	    $mesa->IdMozo=$ArrayDeParametros['idMozo'];
	   	$mesa =$mesa->ModificarMesa();
	   	$objDelaRespuesta= new stdclass();
		//var_dump($resultado);
		$objDelaRespuesta->resultado=$resultado;
		return $response->withJson($objDelaRespuesta, 200);		
    }


}