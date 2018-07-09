<?php
class itemPedido
{
	public $idItem;
	public $idPedido;
	public $descripcion;
	public $sector;
	public $tiempo;
	public $estado;




  	public function BorrarItem()
	 {
	 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from itempedido 				
				WHERE IdItem=:id");	
				$consulta->bindValue(':id',$this->idItem, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
	 }


	 public function BorrarItemsPedido()
	 {
	 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from itempedido 				
				WHERE IdPedido=:id");	
				$consulta->bindValue(':id',$this->idPedido, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
	 }



	  public function Modificar()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update itempedido 
				set Estado=:estado,
				sector=:sector,
				tiempo=:tiempo,
				descripcion=:descripcion
				WHERE IdItem=:id");
			$consulta->bindValue(':id',$this->idItem, PDO::PARAM_STR);
			$consulta->bindValue(':estado',$this->estado, PDO::PARAM_STR);
			$consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
			$consulta->bindValue(':tiempo', $this->tiempo, PDO::PARAM_STR);
			$consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);

			return $consulta->execute();
	 }

	 public function InsertarItem()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into itempedido (idPedido,Estado,Sector,Tiempo,Descripcion)values(:idPedido,:estado,:sector,:tiempo,:descripcion)");
				$consulta->bindValue(':idPedido',$this->idPedido, PDO::PARAM_STR);
				$consulta->bindValue(':estado',$this->estado, PDO::PARAM_STR);
				$consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
				$consulta->bindValue(':tiempo', $this->tiempo, PDO::PARAM_STR);
				$consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }



  	public static function TraerTodosLosItems()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idItem, idPedido, estado, sector, tiempo, descripcion from itempedido");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "itemPedido");		
	}



	public static function TraerItemsPorSector($sector)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idItem, idPedido, estado, sector, tiempo, descripcion from itempedido where estado != 'Cerrado' AND sector=:sector");
				$consulta->bindValue(':sector',$sector, PDO::PARAM_STR);		
				$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "itemPedido");		
	}


	public static function TraerItemsPorPedido($id)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idItem, idPedido, estado, sector, tiempo, descripcion from itempedido where  idPedido=:idPedido");
				$consulta->bindValue(':idPedido',$id, PDO::PARAM_INT);		
				$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "itemPedido");		
	}






	public static function TraerUnItem($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idItem,idPedido, estado, sector, tiempo, descripcion from itempedido where idItem = $id");
			$consulta->execute();
			$buscado= $consulta->fetchObject('itemPedido');
			return $buscado;				

			
	}





	


	public function mostrarDatos()
	{
	  	return "Metodo mostar:".$this->estado."  ".$this->descripcion."  ".$this->tiempo;
	}

}