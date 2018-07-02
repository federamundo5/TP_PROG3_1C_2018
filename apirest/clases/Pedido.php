<?php
class Pedido
{
	public $idPedido;
	public $estado;
	public $clave;
	public $idEmpleado;
	public $foto;
	public $idMesa;
	public $nombreEmpleado;
	public $tiempo;
	public $horaPedido;
	public $sector;
	public $importe;
	public $fin;
	public $descripcion;




  	public function BorrarPedido()
	 {
	 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from Pedido 				
				WHERE IdPedido=:id");	
				$consulta->bindValue(':id',$this->idPedido, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
	 }




	  public function ModificarPedido()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update Pedido 
				set Estado=:estado,
				Clave=:clave,
				IdMesa=:idmesa,
				IdEmpleado=:idempleado,
				NombreEmpleado=:nombrEmpleado,
				Tiempo=:tiempo,
				Sector=:sector,
				Importe=:importe,
				Foto=:foto,
				Fin=:fin,
				HoraPedido=:horaPedido
				WHERE IdPedido=:id");
			$consulta->bindValue(':id',$this->idPedido, PDO::PARAM_STR);
			$consulta->bindValue(':estado',$this->estado, PDO::PARAM_STR);
			$consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
			$consulta->bindValue(':idmesa', $this->idMesa, PDO::PARAM_STR);
			$consulta->bindValue(':idempleado', $this->idEmpleado, PDO::PARAM_STR);
			$consulta->bindValue(':nombrEmpleado', $this->nombreEmpleado, PDO::PARAM_STR);
			$consulta->bindValue(':tiempo', $this->tiempo, PDO::PARAM_STR);
			$consulta->bindValue(':fin', $this->fin, PDO::PARAM_STR);
			$consulta->bindValue(':importe', $this->importe, PDO::PARAM_INT);
			$consulta->bindValue(':horaPedido', $this->horaPedido, PDO::PARAM_STR);
			$consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
			$consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);


			return $consulta->execute();
	 }

	 public function InsertarPedido()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into Pedido (Estado,Clave,Tiempo,HoraPedido,Foto,Sector,Importe,idMesa,descripcion)values(:estado,:clave,:tiempo,:horapedido,:foto,:sector,:importe,:idMesa,:descripcion)");
				$consulta->bindValue(':estado',$this->estado, PDO::PARAM_STR);
				$consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
				$consulta->bindValue(':tiempo', $this->tiempo, PDO::PARAM_STR);
				$consulta->bindValue(':horapedido', $this->horaPedido, PDO::PARAM_STR);
				$consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
				$consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
				$consulta->bindValue(':importe', $this->importe, PDO::PARAM_INT);
				$consulta->bindValue(':idMesa', $this->idMesa, PDO::PARAM_INT);
				$consulta->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }
	 public function GuardarPedido()
	 {

	 	if($this->id>0)
	 		{
	 			$this->ModificarPedido();
	 		}else {
	 			$this->InsertarPedido();
	 		}

	 }


  	public static function TraerTodosLosPedidos()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idPedido, descripcion, estado, clave, tiempo, idEmpleado, horaPedido, sector, idMesa, importe, fin from Pedido");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");		
	}


	public static function TraerPedidosPorSector($sector)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idPedido, estado, clave, tiempo, idEmpleado, horaPedido, sector, idMesa,importe, fin from Pedido where Estado != 'Cerrado' AND sector=:sector");
				$consulta->bindValue(':sector',$sector, PDO::PARAM_STR);		
				$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");		
	}





	public static function TraerMasVendidos()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT SUM(Importe), Descripcion  FROM `Pedido` GROUP BY Descripcion ORDER BY SUM(Importe) DESC");
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");		
	}


	public static function TraerMenosVendidos()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT SUM(Importe), Descripcion  FROM `Pedido` GROUP BY Descripcion ORDER BY SUM(Importe) ASC");
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");		
	}


	public static function TraerPedidosCancelados()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idPedido, estado, clave, tiempo, idEmpleado, horaPedido, sector, idMesa,importe, fin from Pedido where Estado = 'Cancelado'");
				$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");		
	}






	public static function TraerUnPedido($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idPedido, Estado, descripcion, idMesa, Clave, Tiempo, idEmpleado, horaPedido, sector, foto, clave, importe, fin from Pedido where idPedido = $id");
			$consulta->execute();
			$buscado= $consulta->fetchObject('Pedido');
			return $buscado;				

			
	}


	public static function TraerPedidoClave($clave) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idPedido, Estado, idMesa, Clave, Tiempo, idEmpleado, horaPedido, foto, clave, importe, fin from Pedido where Clave = '$clave'");
			$consulta->execute();
			$buscado= $consulta->fetchObject('Pedido');
			return $buscado;				

			
	}



	
	public static function MesaMasUsada() 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT COUNT(IdPedido), idMesa FROM `Pedido` Group by idMesa Order by COUNT(IdPedido) ASC");
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");										
			
	}


		
	public static function MesaMenosUsada() 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT COUNT(IdPedido), idMesa FROM `Pedido` Group by idMesa Order by COUNT(IdPedido) DESC");
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");							
	}


	public function mostrarDatos()
	{
	  	return "Metodo mostar:".$this->estado."  ".$this->clave."  ".$this->tiempo;
	}

}