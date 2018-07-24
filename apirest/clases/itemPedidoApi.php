<?php
require_once 'itemPedido.php';
require_once 'IApiUsable.php';
require_once 'Empleado.php';

class itemPedidoApi extends itemPedido implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
     	$id=$args['idItem'];
		$itemPedido=itemPedido::TraerUnItem($id);


     	$newResponse = $response->withJson($itemPedido, 200);  
    	return $newResponse;
    }
     public function TraerTodos($request, $response, $args) {

		$sector = $request->getAttribute('sector');
		
		$consulta = $request->getAttribute('consulta');


		if($sector == "Socio")
		{
			$pedidos=itemPedido::TraerTodosLosItems();
		}else{
			$pedidos=itemPedido::TraerItemsPorSector($sector);
		}

		if($sector == "Mozos")
		{
			$pedidos=itemPedido::TraerItemsMozo();
		}

		if($consulta == "MasVendidos"){
			$pedidos=Pedido::TraerMasVendidos();
		}
		

		if($consulta == "TraerNoEntregadosATiempo"){
			$pedidos=itemPedido::TraerNoEntregadosATiempo();
		}

		if($consulta == "MenosVendidos"){
			$pedidos=Pedido::TraerMenosVendidos();
		}

		if($consulta == "Cancelados"){
			$pedidos=Pedido::TraerPedidosCancelados();
		}

     	$newResponse = $response->withJson($pedidos, 200);  
    	return $newResponse;
	}
	

      public function CargarUno($request, $response, $args) {

		try{
     	 $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $estado= $ArrayDeParametros['estado'];
        $sector= $ArrayDeParametros['sector'];
		$descripcion= $ArrayDeParametros['descripcion'];
		$idPedido= $ArrayDeParametros['idPedido'];
 $idEmpleado =  $request->getAttribute('idEmpleado');
  

		$itemPedido = new itemPedido();
        $itemPedido->estado=$estado;
        $itemPedido->sector=$sector;
		$itemPedido->descripcion=$descripcion;
		$itemPedido->idPedido=$idPedido;

  
	   
	  $empleado=Empleado::TraerUnEmpleado($idEmpleado);
	  $empleado->operaciones++;
	   $empleado->ModificarEmpleado();

        $itemPedido->InsertarItem();

		$response->getBody()->write("se guardo el Item");
		}
		catch(Exception $e)
		{
			$response->getBody()->write("no existe el pedido");
		}

        return $response;
	}
	

      public function BorrarUno($request, $response, $args) {
		 $id=$args['id'];
     	$itemPedido= new itemPedido();
		 $itemPedido->idItem=$id;
     	$cantidadDeBorrados=$itemPedido->BorrarItem();

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

		$itempedido = new itemPedido();

		if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

			$itempedido->idItem=$args['idItem'];
			$itempedido->estado=$args['estado'];
			$itempedido->sector=$args['sector'];
			$itempedido->tiempoPrevisto=$args['tiempoPrevisto'];
			$itempedido->descripcion=$args['descripcion'];

		}	

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$ArrayDeParametros = $request->getParsedBody();
				$estado= $ArrayDeParametros['estado'];
				$idItem= $ArrayDeParametros['idItem'];

               
				$itempedido=itemPedido::TraerUnItem($idItem);
               
				$itempedido->estado = $ArrayDeParametros['estado'];				

				if(isset($ArrayDeParametros['tiempoPrevisto']))
				{	
				$tiempo=($ArrayDeParametros['tiempoPrevisto']);
				date_default_timezone_set('America/Argentina/Buenos_Aires');
				$now = time();
				$ten_minutes = $now + ($tiempo * 60);
				$startDate = date('m-d-Y H:i:s', $now);
				$endDate = date('m-d-Y H:i:s', $ten_minutes);
				$itempedido->tiempoPrevisto = $endDate;
				}

				
				if(isset($ArrayDeParametros['tiempoEntregado']))
				{	
				$tiempo=($ArrayDeParametros['tiempoEntregado']);
				$itempedido->tiempoEntregado = $tiempo;
				}

		}	

		$idEmpleado =  $request->getAttribute('idEmpleado');

    	 $empleado=Empleado::TraerUnEmpleado($idEmpleado);
	  	 $empleado->operaciones++;
	 	$empleado->ModificarEmpleado();
	   
		$resultado = $itempedido->Modificar();

		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->resultado=$resultado;
		$response->getBody()->write("Se modifico el Item");
	    return $response;
	}
	



}