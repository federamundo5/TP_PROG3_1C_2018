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
				if($request->isPost())
				{		
					// el post sirve para todos los logeados			    
					$response = $next($request, $response);
				}
				else
				{
					$payload=AutentificadorJWT::ObtenerData($token);
					
					$request = $request->withAttribute('sector',$payload->sector);
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

}