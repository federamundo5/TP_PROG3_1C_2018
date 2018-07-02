<?php
require_once 'ingreso.php';
require_once 'IApiUsable.php';

class ingresoApi extends Ingreso implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
     	$id=$args['id'];
		 $listado=Ingreso::TraerListadoEmpleado($id);
     	$newResponse = $response->withJson($listado, 200);  
    	return $newResponse;
	}
	
     public function TraerTodos($request, $response, $args) {
      	$listado=Ingreso::TraerListado();
     	$newResponse = $response->withJson($listado, 200);  
    	return $newResponse;
	}
	

      public function CargarUno($request, $response, $args) {
     	 $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
		$usuario= $ArrayDeParametros['usuario'];
		$fechahora= $ArrayDeParametros['fechahora'];
        
        $ingreso = new Ingreso();
		$ingreso->Usuario=$usuario;
		$ingreso->FechaHorario=$fechahora;
        $ingreso->Insertar();

        $response->getBody()->write("se guardo el ingreso");

        return $response;
	}
	

      public function BorrarUno($request, $response, $args) {
    }
     
     public function ModificarUno($request, $response, $args) {
    }


}