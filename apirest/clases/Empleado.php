<?php
class Empleado
{
	public $idEmpleado;
 	public $nombre;
  	public $apellido;
  	public $sector;



  	public function BorrarEmpleado()
	 {
	 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from empleado 				
				WHERE IdEmpleado=:id");	
				$consulta->bindValue(':id',$this->idEmpleado, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
	 }




	  public function ModificarEmpleado()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update Empleado 
				set Nombre=:nombre,
				Apellido=:apellido,
				Sector=:sector
				WHERE IdEmpleado=:id");
			$consulta->bindValue(':id',$this->idEmpleado, PDO::PARAM_STR);
			$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
			$consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
			$consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
			return $consulta->execute();
	 }

	 public function InsertarEmpleado()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into Empleado (Nombre,Apellido,Sector)values(:nombre,:apellido,:sector)");
				$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
				$consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
				$consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }
	 public function GuardarEmpleado()
	 {

	 	if($this->id>0)
	 		{
	 			$this->ModificarEmpleado();
	 		}else {
	 			$this->InsertarEmpleado();
	 		}

	 }


  	public static function TraerTodosLosEmpleados()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select Nombre, Apellido, Sector from Empleado");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Empleado");		
	}

	public static function TraerUnEmpleado($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select Nombre, Apellido, Sector from Empleado where idEmpleado = $id");
			$consulta->execute();
			$empleadoBuscado= $consulta->fetchObject('Empleado');
			return $empleadoBuscado;				

			
	}



	

	public function mostrarDatos()
	{
	  	return "Metodo mostar:".$this->titulo."  ".$this->cantante."  ".$this->año;
	}

}