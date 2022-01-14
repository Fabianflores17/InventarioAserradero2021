<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Ingreso
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idproducto,$idusuario,$precio1,$precio2,$precio3,$precio4,$precio5,$precio6,$precio7,$precio8,$precio9,$precio10)
	{
		$sql="INSERT INTO listaprecio (idproducto,idusuario,precio,precio2,precio3,precio4,precio5,precio6,precio7,precio8,precio9,precio10,condicion)
		VALUES ('$idproducto','$idusuario','$precio1','$precio2','$precio3','$precio4','$precio5','$precio6','$precio7','$precio8','$precio9','$precio10','1')";
		return ejecutarConsulta($sql);
	  

	
	}

	
	//Implementamos un método para anular categorías
	public function anular($idingreso)
	{
		$sql="UPDATE transaccion SET estado='0' WHERE idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idingreso)
	{
		$sql="SELECT * FROM listaprecio where idprecio='$idingreso'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idingreso)
	{
		$sql="SELECT o.transaccion_id,o.idproducto,p.nombre, o.cantidad,o.price_compra,o.idprecio_lis 
		FROM operacion o inner join producto p on o.idproducto=p.idproducto where o.transaccion_id='$idingreso'";
		return ejecutarConsulta($sql);
	}


	
	public function listarProducto()
	{
		$sql="SELECT * FROM producto";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT l.condicion, p.nombre as producto, u.nombre as usuario, l.idprecio
		FROM listaprecio l
		inner join producto p ON l.idproducto=p.idproducto
		inner join usuario u ON l.idusuario=u.idusuario";
		return ejecutarConsulta($sql);		
	}

	
	public function listadopago(){
		$sql="SELECT *from tipo_pago";
		return ejecutarConsulta($sql);
	}
	
}

?>	