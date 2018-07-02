<?php
class Encuesta
{
	public $idEncuesta;
	public $experiencia;
	public $idMozo;
	public $idCocinero;
	public $puntuacionMozo;
	public $puntuacionMesa;
	public $puntuacionCocinero;
	public $puntuacionRestaurante;






	 public function InsertarEncuesta()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into Encuesta (Experiencia,idMozo,idCocinero,
				puntuacionMozo,puntuacionRestaurante,puntuacionCocinero,puntuacionMesa)
				values(:experiencia,:idMozo,:idCocinero,:puntuacionMozo,:puntuacionRestaurante,:puntuacionCocinero,:puntuacionMesa)");
				$consulta->bindValue(':experiencia', $this->experiencia, PDO::PARAM_STR);
				$consulta->bindValue(':idMozo', $this->idMozo, PDO::PARAM_STR);
				$consulta->bindValue(':idCocinero', $this->idCocinero, PDO::PARAM_INT);
				$consulta->bindValue(':puntuacionMozo', $this->puntuacionMozo, PDO::PARAM_INT);
				$consulta->bindValue(':puntuacionRestaurante', $this->puntuacionRestaurante, PDO::PARAM_INT);
				$consulta->bindValue(':puntuacionCocinero', $this->puntuacionCocinero, PDO::PARAM_INT);
				$consulta->bindValue(':puntuacionMesa', $this->puntuacionMesa, PDO::PARAM_INT);

				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }

  	public static function TraerTodasLasEncuestas()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select puntuacionMozo, puntuacionRestaurante, puntuacionCocinero, puntuacionMesa, 
			Experiencia from Encuesta");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Encuesta");		
	}




	public function mostrarDatos()
	{
	  	return "Metodo mostrar:".$this->estado."  ".$this->clave."  ".$this->tiempo;
	}

}