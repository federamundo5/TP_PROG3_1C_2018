<?php
class Ingreso
{
		public $IdIngreso;
		public $Usuario;
		public $FechaHorario;


	 public function Insertar()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into Ingreso (Usuario,FechaHorario)values(:usuario,:fechahora)");
				$consulta->bindValue(':usuario',$this->Usuario, PDO::PARAM_INT);
				$consulta->bindValue(':fechahora', $this->FechaHorario, PDO::PARAM_STR);

				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }

	 public function InsertarLogueo($usuario,$fechaHorario)
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into Ingreso (Usuario,FechaHorario)values(:usuario,:fechahora)");
				$consulta->bindValue(':usuario',$usuario, PDO::PARAM_INT);
				$consulta->bindValue(':fechahora', $fechaHorario, PDO::PARAM_STR);

				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }




  	public static function TraerListado()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select Usuario,FechaHorario from Ingreso");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "ingreso");		
	}


	

	public static function TraerListadoEmpleado($idEmpleado)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select Usuario,FechaHorario from Ingreso where Usuario = $idEmpleado");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "ingreso");		
	}






	public function mostrarDatos()
	{
	  	return "Metodo mostrar:".$this->Usuario."  ".$this->FechaHorario;
	}

}