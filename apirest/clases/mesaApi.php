<?php
require_once 'Mesa.php';
require_once 'Pedido.php';

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

		$consulta = $request->getAttribute('consulta');

		if($consulta == "MasUsadas"){
		$pedidos=Pedido::MesaMasUsada($sector);
	   $newResponse = $response->withJson($pedidos, 200);  
		return $newResponse;
		}

		if($consulta == "MenosUsadas"){
			$pedidos=Pedido::MesaMenosUsada($sector);
		   $newResponse = $response->withJson($pedidos, 200);  
			return $newResponse;
			}

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
		 $id=$args['id'];
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


		
		$mesa = new Mesa();
		
		
		if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
		$mesa->IdMesa=    $args['id'];
	    $mesa->Clave=$args['clave'];
		$mesa->IdMozo=$args['idMozo'];
		$mesa->Estado=$args['estado'];
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$ArrayDeParametros = $request->getParsedBody();
			$estado= $ArrayDeParametros['estado'];
			$idMesa= $ArrayDeParametros['idMesa'];

			$mesa=Mesa::TraerUnaMesa($idMesa);

			$mesa->Estado=$estado;
		}



	   	$resultado =$mesa->ModificarMesa();
	   	$objDelaRespuesta= new stdclass();
		//var_dump($resultado);
		$objDelaRespuesta->resultado=$resultado;
		return $response->withJson($objDelaRespuesta, 200);		
    }


}