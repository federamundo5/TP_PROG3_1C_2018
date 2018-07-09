<?php
require_once 'Pedido.php';
require_once 'IApiUsable.php';
require_once 'Empleado.php';
require_once 'itemPedido.php';

class pedidoApi extends Pedido implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
     	$clave=$args['clave'];
		$pedido=Pedido::TraerPedidoClave($clave);
		$pedido->items = itemPedido::TraerItemsPorPedido($pedido->idPedido);
	/*	$datetime1 = new DateTime($pedido->horaPedido);
		$datetime2 = new DateTime($pedido->fin);
		$pedido->interval = date_diff($pedido->horaPedido,$pedido->fin);

		$diff = $datetime2 - $datetime1;
		$hours = $diff / ( 60 * 60 );

		$hours = $diff->h;
		$hours = $hours + ($diff->days*24);
		$mins = ($datetime2 - $datetime1) / 60;
		$pedido->diff = $mins;
		*/
      //  $pedido->tiempoRestante =  $interval->format('%h:%i:%s');
     	$newResponse = $response->withJson($pedido, 200);  
    	return $newResponse;
    }
     public function TraerTodos($request, $response, $args) {

	//	$sector = $request->getAttribute('sector');
		
		$consulta = $request->getAttribute('consulta');


	
			$pedidos=Pedido::TraerTodosLosPedidos();
			foreach($pedidos as $pedido){
				$pedido->items = itemPedido::TraerItemsPorPedido($pedido->idPedido);
			}

		if($consulta == "MasVendidos"){
			$pedidos=Pedido::TraerMasVendidos();
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
     	 $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $estado= $ArrayDeParametros['estado'];
        $clave= $ArrayDeParametros['clave'];
		$horaPedido= $ArrayDeParametros['horaPedido'];
		$idEmpleado= $ArrayDeParametros['idEmpleado'];
		$importe= $ArrayDeParametros['importe'];
		$idMesa= $ArrayDeParametros['idMesa'];




                
        $archivos = $request->getUploadedFiles();
        $destino="./fotos/";

		$pedido = new Pedido();
        $pedido->estado=$estado;
        $pedido->clave=$clave;
		$pedido->horaPedido=$horaPedido;
		$pedido->importe=$importe;
		$pedido->idMesa = $idMesa;

        if(isset($archivos['foto']))
        {
            $nombreAnterior=$archivos['foto']->getClientFilename();
            $extension= explode(".", $nombreAnterior)  ;
            $extension=array_reverse($extension);
            $archivos['foto']->moveTo($destino.$clave.".".$extension[0]);
            $pedido->foto = $destino.$clave.".".$extension[0];
	   }else{
		   $pedido->foto = "";
	   } 
	   
	   $empleado=Empleado::TraerUnEmpleado($idEmpleado);
	   $empleado->operaciones++;
	   $empleado->ModificarEmpleado();

        $pedido->InsertarPedido();

        $response->getBody()->write("se guardo el Pedido");

        return $response;
	}
	

      public function BorrarUno($request, $response, $args) {
		 $id=$args['id'];
     	$pedido= new Pedido();
		 $pedido->idPedido=$id;
     	$cantidadDeBorrados=$pedido->BorrarPedido();

     	$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->cantidad=$cantidadDeBorrados;

		$itemPedido= new itemPedido();
		$itemPedido->idPedido=$id;
		$itemPedido->BorrarItemsPedido();


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
		$pedido = new Pedido();
		if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
			$pedido = new Pedido();


			$pedido->idPedido=$args['id'];
			$pedido->estado=$args['estado'];
			$pedido->clave=$args['clave'];
			$pedido->horaPedido=$args['horaPedido'];
			$pedido->fin=$args['fin'];
			$pedido->importe=$args['importe'];


	
	
			$pedido->idMesa=$args['idMesa'];
			$pedido->idEmpleado=$args['idEmpleado'];
			$idEmpleado = $pedido->idEmpleado;
			
		}	

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$ArrayDeParametros = $request->getParsedBody();
				$idPedido= $ArrayDeParametros['idPedido'];
				$estado= $ArrayDeParametros['estado'];
				$idEmpleado= $ArrayDeParametros['idEmpleado'];

               
				$pedido=Pedido::TraerUnPedido($idPedido);
				$pedido->idEmpleado = $idEmpleado;
				$pedido->estado = $ArrayDeParametros['estado'];				

				if(isset($ArrayDeParametros['tiempo']))
				{
     			//	$minutes_to_add = $ArrayDeParametros['tiempo'];;
				//	$time = new DateTime($pedido->horaPedido);
					//$time->modify("+{$minutes_to_add} minutes");
					$pedido->tiempo = $ArrayDeParametros['tiempo'];
				}

		

				if(isset($ArrayDeParametros['fin']))
				{
					$pedido->fin = $ArrayDeParametros['fin'];
				}
		}	
			$idEmpleado = $pedido->idEmpleado;
    	 $empleado=Empleado::TraerUnEmpleado($idEmpleado);
	  	 $empleado->operaciones++;
	 	 $empleado->ModificarEmpleado();
	   
		$resultado =$pedido->ModificarPedido();
		$objDelaRespuesta= new stdclass();
	    $objDelaRespuesta->resultado=$resultado;
	    return $response->withJson($objDelaRespuesta, 200);		
	}
	



}