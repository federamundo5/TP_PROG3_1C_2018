<?php

class MWparaAutentificar
{	
	
	
	public function VerificarUsuario($request, $response, $next) {
         
	$objDelaRespuesta= new stdclass();
	$objDelaRespuesta->respuesta="";
   

	
			$arrayConToken = $request->getHeader('token');
			$token=$arrayConToken[0];			
		

				$arrayConToken = $request->getHeader('token');
				$token=$arrayConToken[0];			
			
			//var_dump($token);
			$objDelaRespuesta->esValido=true; 
			try 
			{
				//$token="";
				AutentificadorJWT::verificarToken($token);
				$objDelaRespuesta->esValido=true;      
			}
			catch (Exception $e) {      
				//guardar en un log
				$objDelaRespuesta->excepcion=$e->getMessage();
				$objDelaRespuesta->esValido=false;     
			}

			if($objDelaRespuesta->esValido)
			{						
			
		
					$payload=AutentificadorJWT::ObtenerData($token);
					
					$request = $request->withAttribute('sector',$payload->sector);
					$request = $request->withAttribute('idEmpleado',$payload->idEmpleado);

					$response = $next($request, $response);
	
					
						          
			}    
			else
			{
				//   $response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
				$objDelaRespuesta->respuesta="Solo usuarios registrados";
				$objDelaRespuesta->elToken=$token;

			}  
				  
		if($objDelaRespuesta->respuesta!="")
		{
			$nueva=$response->withJson($objDelaRespuesta, 401);  
			return $nueva;
		}
		  
		 //$response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
		 return $response;   
	}


	public function VerificarSocio($request, $response, $next) {
         
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->respuesta="";
	   
	
		
				$arrayConToken = $request->getHeader('token');
				$token=$arrayConToken[0];			
			
	
					$arrayConToken = $request->getHeader('token');
					$token=$arrayConToken[0];			
				
				//var_dump($token);
				$objDelaRespuesta->esValido=true; 
				try 
				{
					//$token="";
					AutentificadorJWT::verificarToken($token);
					$objDelaRespuesta->esValido=true;      
				}
				catch (Exception $e) {      
					//guardar en un log
					$objDelaRespuesta->excepcion=$e->getMessage();
					$objDelaRespuesta->esValido=false;     
				}
	
				if($objDelaRespuesta->esValido)
				{									
					$payload=AutentificadorJWT::ObtenerData($token);
	
					if($payload->sector=="Socio")
					{
						$request = $request->withAttribute('idEmpleado',$payload->idEmpleado);
						$response = $next($request, $response);
					}		           	
					else
					{	
						$objDelaRespuesta->respuesta="Solo administradores";
					}
		
		
						
							          
				}    
				else
				{
					//   $response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
					$objDelaRespuesta->respuesta="Solo usuarios registrados";
					$objDelaRespuesta->elToken=$token;
	
				}  
					  
			if($objDelaRespuesta->respuesta!="")
			{
				$nueva=$response->withJson($objDelaRespuesta, 401);  
				return $nueva;
			}
			  
			 //$response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
			 return $response;   
		}

	public function OperacionesPorSector($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"PorSector");
		$response = $next($request, $response);
       return $response;			  
	}

	
	public function OperacionesEmpleados($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"CadaUno");
		$response = $next($request, $response);
       return $response;			  
	}

	public function OperacionesPorSectorYEmpleado($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"PorSectorYEmpleado");
		$response = $next($request, $response);
       return $response;			  
	}

	
	public function MesasMasUsadas($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"MasUsadas");
		$response = $next($request, $response);
       return $response;			  
	}


	
	public function MasVendidos($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"MasVendidos");
		$response = $next($request, $response);
       return $response;			  
	}

	public function MenosVendidos($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"MenosVendidos");
		$response = $next($request, $response);
       return $response;			  
	}


	public function Cancelados($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"Cancelados");
		$response = $next($request, $response);
       return $response;			  
	}



		
	public function MesasMenosUsadas($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"MenosUsadas");
		$response = $next($request, $response);
       return $response;			  
	}


			
	public function Suspension($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"Suspension");
		$response = $next($request, $response);
       return $response;			  
	}

	public function MesasMasImporte($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"MesasMasImporte");
		$response = $next($request, $response);
       return $response;			  
	}

	public function MesasMenosImporte($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"MesasMenosImporte");
		$response = $next($request, $response);
       return $response;			  
	}

	
	public function MesaMayorFactura($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"MesaMayorFactura");
		$response = $next($request, $response);
       return $response;			  
	}


	
	public function MesaMenorFactura($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"MesaMenorFactura");
		$response = $next($request, $response);
       return $response;			  
	}


	public function PeoresComentarios($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"PeoresComentarios");
		$response = $next($request, $response);
       return $response;			  
	}

	public function MejoresComentarios($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"MejoresComentarios");
		$response = $next($request, $response);
       return $response;			  
	}


	public function TiempoRestante($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"TiempoRestante");
		$response = $next($request, $response);
       return $response;			  
	}

	public function TraerNoEntregadosATiempo($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"TraerNoEntregadosATiempo");
		$response = $next($request, $response);
       return $response;			  
	}

	public function PorMeses($request, $response, $next) {
         
		$request = $request->withAttribute('consulta',"PorMeses");
		$response = $next($request, $response);
       return $response;			  
	}


	public function Cerrar($request, $response, $next) {
         
		$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->respuesta="";
	   
	
		
				$arrayConToken = $request->getHeader('token');
				$token=$arrayConToken[0];			
			
	
					$arrayConToken = $request->getHeader('token');
					$token=$arrayConToken[0];			
				
				//var_dump($token);
				$objDelaRespuesta->esValido=true; 
				try 
				{
					//$token="";
					AutentificadorJWT::verificarToken($token);
					$objDelaRespuesta->esValido=true;      
				}
				catch (Exception $e) {      
					//guardar en un log
					$objDelaRespuesta->excepcion=$e->getMessage();
					$objDelaRespuesta->esValido=false;     
				}
	
				if($objDelaRespuesta->esValido)
				{			$ArrayDeParametros = $request->getParsedBody();
				
				 $estado = $ArrayDeParametros['estado'];				
							

					if(	 $estado  == "Cerrado"){
					$payload=AutentificadorJWT::ObtenerData($token);
	
					if($payload->sector=="Socio")
					{
						$request = $request->withAttribute('idEmpleado',$payload->idEmpleado);
						$response = $next($request, $response);
					}		           	
					else
					{	
						$objDelaRespuesta->respuesta="Solo administradores pueden cerrar";
					}
				}else{
					$response = $next($request, $response);
				}
		
		
						
							          
				}    
				else
				{
					//   $response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
					$objDelaRespuesta->respuesta="Solo usuarios registrados";
					$objDelaRespuesta->elToken=$token;
	
				}  
					  
			if($objDelaRespuesta->respuesta!="")
			{
				$nueva=$response->withJson($objDelaRespuesta, 401);  
				return $nueva;
			}
			  
			 //$response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
			 return $response;   
		}

}