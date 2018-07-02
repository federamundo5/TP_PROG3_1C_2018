<?php
require_once 'Empleado.php';
require_once 'IApiUsable.php';

class operacionesApi extends Empleado implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
   
    }
     public function TraerTodos($request, $response, $args) {

		$consulta = $request->getAttribute('consulta');
		
		if($consulta == "PorSector"){
			$empleados=Empleado::TraerOperacionesPorSector();
		}
			
		if($consulta == "CadaUno"){
			$empleados=Empleado::TraerTodosLosEmpleados();
		}

				
		if($consulta == "PorSectorYEmpleado"){
			$empleados=Empleado::TraerOperacionesPorSectorYEmpleado();
		}



     	$newResponse = $response->withJson($empleados, 200);  
    	return $newResponse;
	}
	

      public function CargarUno($request, $response, $args) {
 
	}
	

      public function BorrarUno($request, $response, $args) {

    }
     
     public function ModificarUno($request, $response, $args) {

    }


}