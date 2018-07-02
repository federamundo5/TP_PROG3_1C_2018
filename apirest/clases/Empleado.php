<?php
class Empleado
{
	public $idEmpleado;
 	public $nombre;
  	public $apellido;
  	public $sector;
	public $clave;
	public $operaciones; 
	public $suspendido;

  	public function BorrarEmpleado()
	 {
	 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from Empleado 				
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
				Clave=:clave,
				Operaciones =:operaciones,
				Suspendido =:suspendido,
				Sector=:sector
				WHERE IdEmpleado=:id");
			$consulta->bindValue(':id',$this->idEmpleado, PDO::PARAM_STR);
			$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
			$consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
			$consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
			$consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
			$consulta->bindValue(':suspendido', $this->suspendido, PDO::PARAM_INT);
			$consulta->bindValue(':operaciones', $this->operaciones, PDO::PARAM_STR);


			return $consulta->execute();
	 }


	 public static function CheckLogin($nombre,$clave) 
	 {
			 $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			 $consulta =$objetoAccesoDato->RetornarConsulta("select idEmpleado,nombre, clave, sector from Empleado WHERE Nombre=? AND Clave=?");
			 $consulta->execute(array($nombre, $clave));
			 $persona= $consulta->fetchObject('Empleado');
			 return $persona;						 
	 }
 

	 public function InsertarEmpleado()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into Empleado (Nombre,Apellido,Sector, Clave,Operaciones)values(:nombre,:apellido,:sector,:clave,:operaciones)");
				$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
				$consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
				$consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
				$consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
				$consulta->bindValue(':operaciones',0, PDO::PARAM_INT);
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
			$consulta =$objetoAccesoDato->RetornarConsulta("select idEmpleado, nombre, apellido, sector, operaciones, suspendido from Empleado");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Empleado");		
	}



	
	public static function TraerOperacionesPorSector()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT Sector, SUM(Operaciones) AS 'Cantidad Operaciones' FROM `Empleado` GROUP By Sector");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Empleado");		
	}


	public static function TraerOperacionesPorSectorYEmpleado()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT Sector, SUM(Operaciones), IdEmpleado FROM `Empleado` GROUP By Sector, IdEmpleado");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Empleado");		
	}

	public static function TraerUnEmpleado($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idEmpleado, nombre, apellido, sector, clave, operaciones from Empleado where idEmpleado = $id");
			$consulta->execute();
			$empleadoBuscado= $consulta->fetchObject('Empleado');
			return $empleadoBuscado;				

			
	}



	

	public function mostrarDatos()
	{
	  	return "Metodo mostar:".$this->nombre."  ".$this->clave."  ".$this->sector;
	}

}