<?php
class Pedido
{
	public $idPedido;
	public $estado;
	public $clave;
	public $idEmpleado;
	public $foto;
	public $idMesa;
	public $horaPedido;
	public $importe;
	public $fin;
    public $items;



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
			$consulta->bindValue(':fin', $this->fin, PDO::PARAM_STR);
			$consulta->bindValue(':importe', $this->importe, PDO::PARAM_INT);
			$consulta->bindValue(':horaPedido', $this->horaPedido, PDO::PARAM_STR);
			$consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);


			return $consulta->execute();
	 }

	 public function InsertarPedido()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into Pedido (Estado,Clave,HoraPedido,Foto,Importe,idMesa)values(:estado,:clave,:horapedido,:foto,:importe,:idMesa)");
				$consulta->bindValue(':estado',$this->estado, PDO::PARAM_STR);
				$consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
				$consulta->bindValue(':horapedido', $this->horaPedido, PDO::PARAM_STR);
				$consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
				$consulta->bindValue(':importe', $this->importe, PDO::PARAM_INT);
				$consulta->bindValue(':idMesa', $this->idMesa, PDO::PARAM_INT);
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
			$consulta =$objetoAccesoDato->RetornarConsulta("select idPedido, estado, clave, idEmpleado, horaPedido, idMesa, importe, fin from Pedido");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");		
	}






	public static function TraerPedidosCancelados()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idPedido, estado, clave, tiempo, idEmpleado, horaPedido, idMesa,importe, fin from Pedido where Estado = 'Cancelado'");
				$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");		
	}





	public static function TraerMasVendidos()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT COUNT(itempedido.IdItem) AS Vendidos, SUM(Importe), Descripcion FROM `Pedido` inner join itempedido on itempedido.IdPedido = Pedido.IdPedido group by Descripcion order by COUNT(itempedido.IdItem) ASC
			");
				$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");		
	}


	
	public static function TraerMenosVendidos()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT COUNT(itempedido.IdItem) AS Vendidos, SUM(Importe), Descripcion FROM `Pedido` inner join itempedido on itempedido.IdPedido = Pedido.IdPedido group by Descripcion order by COUNT(itempedido.IdItem) DESC
			");
				$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");		
	}


	


	public static function TraerUnPedido($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idPedido, Estado, idMesa, Clave, Tiempo, idEmpleado, horaPedido, foto, clave, importe, fin from Pedido where idPedido = $id");
			$consulta->execute();
			$buscado= $consulta->fetchObject('Pedido');
			return $buscado;				

			
	}


	public static function TraerPedidoClave($clave) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idPedido, Estado, idMesa, Clave, idEmpleado, horaPedido, foto, clave, importe, fin from Pedido where Clave = '$clave'");
			$consulta->execute();
			$buscado= $consulta->fetchObject('Pedido');
			return $buscado;						
	}


	
	public static function TraerPedidoClaveMesa($clave,$claveMesa) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idPedido, Pedido.Estado, Pedido.idMesa, Pedido.Clave, horaPedido, importe, fin from Pedido inner join Mesa on Mesa.IdMesa = Pedido.idMesa where Pedido.Clave = :clave and Mesa.Clave = :claveMesa");
			$consulta->bindValue(':clave',$clave, PDO::PARAM_STR);
			$consulta->bindValue(':claveMesa',$claveMesa, PDO::PARAM_STR);
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


	public static function MesasMenosImporte() 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT Mesa.Clave, SUM(Importe)  FROM `Mesa` inner join Pedido on Pedido.idMesa = Mesa.IdMesa GROUP BY Mesa.IdMesa order by SUM(Importe) ASC		");
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");							
	}

	
	public static function MesasMasImporte() 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT Mesa.Clave, SUM(Importe)  FROM `Mesa` inner join Pedido on Pedido.idMesa = Mesa.IdMesa GROUP BY Mesa.IdMesa order by SUM(Importe) DESC		");
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");							
	}




	public function mostrarDatos()
	{
	  	return "Metodo mostar:".$this->estado."  ".$this->clave."  ".$this->tiempo;
	}

}