<?php
class Encuesta
{
	public $idEncuesta;
	public $experiencia;
	public $idMesa;
	public $puntuacionMozo;
	public $puntuacionMesa;
	public $puntuacionCocinero;
	public $puntuacionRestaurante;






	 public function InsertarEncuesta()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into Encuesta (Experiencia,
				puntuacionMozo,puntuacionRestaurante,puntuacionCocinero,puntuacionMesa,idMesa)
				values(:experiencia,:puntuacionMozo,:puntuacionRestaurante,:puntuacionCocinero,:puntuacionMesa,:idMesa)");
				$consulta->bindValue(':experiencia', $this->experiencia, PDO::PARAM_STR);
				$consulta->bindValue(':puntuacionMozo', $this->puntuacionMozo, PDO::PARAM_INT);
				$consulta->bindValue(':puntuacionRestaurante', $this->puntuacionRestaurante, PDO::PARAM_INT);
				$consulta->bindValue(':puntuacionCocinero', $this->puntuacionCocinero, PDO::PARAM_INT);
				$consulta->bindValue(':puntuacionMesa', $this->puntuacionMesa, PDO::PARAM_INT);
				$consulta->bindValue(':idMesa', $this->idMesa, PDO::PARAM_INT);

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




	

}