<?php
class Mesa
{
	public $IdMesa;
 	public $Clave;
	public $IdMozo;
   public $Estado;




  	public function BorrarMesa()
	 {
	 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from Mesa 				
				WHERE IdMesa=:id");	
				$consulta->bindValue(':id',$this->IdMesa, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
	 }




	  public function ModificarMesa()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update Mesa 
				set Clave=:clave,
				 Estado=:estado,
				IdMozo=:idmozo
				WHERE IdMesa=:id");
			$consulta->bindValue(':clave',$this->Clave, PDO::PARAM_STR);
			$consulta->bindValue(':estado',$this->Estado, PDO::PARAM_STR);
			$consulta->bindValue(':idmozo', $this->IdMozo, PDO::PARAM_INT);
			$consulta->bindValue(':id', $this->IdMesa, PDO::PARAM_INT);

			return $consulta->execute();
	 }

	 public function InsertarMesa()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into Mesa (Clave)values(:clave)");
				$consulta->bindValue(':clave',$this->Clave, PDO::PARAM_STR);
				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }
	 public function GuardarMesa()
	 {

	 	if($this->id>0)
	 		{
	 			$this->ModificarMesa();
	 		}else {
	 			$this->InsertarMesa();
	 		}

	 }


  	public static function TraerTodasLasMesas()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select IdMesa, Clave,  IdMozo from Mesa");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Mesa");		
	}

	public static function TraerUnaMesa($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select IdMesa, Clave, IdMozo from Mesa where IdMesa = $id");
			$consulta->execute();
			$mesaBuscada= $consulta->fetchObject('Mesa');
			return $mesaBuscada;				

			
	}


	public static function MesaMayorFactura() 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT Mesa.Clave AS Mesa, MAX(Importe) AS Factura FROM `Mesa` inner join Pedido on Pedido.idMesa = Mesa.IdMesa GROUP BY Mesa.IdMesa order by MAX(Importe) DESC");
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Mesa");							
	}

	public static function MesaMenorFactura() 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT Mesa.Clave AS Mesa, MAX(Importe) AS Factura FROM `Mesa` inner join Pedido on Pedido.idMesa = Mesa.IdMesa GROUP BY Mesa.IdMesa order by MAX(Importe) ASC");
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Mesa");							
	}



	


public static function PorMeses($desde, $hasta) 
{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select Mesa.Clave, SUM(Pedido.Importe) from Mesa inner Join Pedido on Pedido.idMesa = Mesa.IdMesa  where Pedido.HoraPedido between :desde AND :hasta
		group by Mesa.Clave");
		$consulta->bindValue(':desde',$desde, PDO::PARAM_STR);
		$consulta->bindValue(':hasta', $hasta, PDO::PARAM_STR);
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_CLASS, "Mesa");							
}


	public static function PeoresComentarios() 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT experiencia, puntuacionMesa, Mesa.Clave from Encuesta inner join Mesa on Mesa.IdMesa = Encuesta.idMesa order by puntuacionMesa ASC			");
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Encuesta");							
	}



	public static function MejoresComentarios() 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT experiencia, puntuacionMesa, Mesa.Clave from Encuesta inner join Mesa on Mesa.IdMesa = Encuesta.idMesa order by puntuacionMesa DESC			");
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Encuesta");							
	}








	public function mostrarDatos()
	{
	  	return "Metodo mostrar:".$this->Clave."  ".$this->IdMozo;
	}

}