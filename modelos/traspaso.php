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
	public function insertar($idalmacen,$idalmacen2,$idusuario,$total_compra,$idarticulo,$cantidad,$precio_compra)
	{
		$sql="INSERT INTO transaccion (idusuario,almacen_to_id,almacen_des_id,tipo_operacion_id,tipo_pago,forma_pago,total,estado)
		VALUES ('$idusuario','$idalmacen2','$idalmacen','6','1','1','$total_compra','1')";
		//return ejecutarConsulta($sql);
		$idingresonew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle = "INSERT INTO operacion (transaccion_id,idproducto,idalmacen,cantidad,price_compra,tipo_operacion_id,is_traspase) 
			VALUES ('$idingresonew', '$idarticulo[$num_elementos]','$idalmacen[$num_elementos]' ,'$cantidad[$num_elementos]','$precio_compra[$num_elementos]','6','1')";
			$idoperacion=ejecutarConsulta_retornarID($sql_detalle);
			$sql_detalles = "INSERT INTO operacion (operation_from_id,transaccion_id,idproducto,idalmacen,cantidad,price_compra,tipo_operacion_id,is_traspase) 
			VALUES ('$idoperacion','$idingresonew', '$idarticulo[$num_elementos]','$idalmacen[$num_elementos]' ,'$cantidad[$num_elementos]','$precio_compra[$num_elementos]','2','1')";
			ejecutarConsulta($sql_detalles);
			$sql_detalles2 = "INSERT INTO operacion (operation_from_id,transaccion_id,idproducto,idalmacen,cantidad,price_compra,tipo_operacion_id,is_traspase) 
			VALUES ('$idoperacion','$idingresonew', '$idarticulo[$num_elementos]','$idalmacen2[$num_elementos]' ,'$cantidad[$num_elementos]','$precio_compra[$num_elementos]','1','1')";
			ejecutarConsulta($sql_detalles2) or $sw = false;
			$num_elementos=$num_elementos + 1;
		
		}

		return $sw;
	}


	
	//Implementamos un método para anular categorías
	public function anular($idingreso)
	{
		$sql="UPDATE transaccion SET estado='0' WHERE idingreso='$idingreso'";
		return ejecutarConsulta($sql);
	}


	public function listarproduct($idalmacen)
	{
		$sql="SELECT Datos.idproducto,p.codigo,o.idalmacen, MAX(o.price_compra) as precio,p.condicion,p.nombre,c.nombre as categoria, Entradas.Entradas - IFNULL(Salidas.Salidas,0) as stock 
		From ( Select distinct idproducto From operacion ) as Datos 
		Left join ( Select idproducto, Sum(cantidad) as Entradas from operacion WHERE tipo_operacion_id='1' AND idalmacen='$idalmacen' 
		Group by idproducto) as Entradas On Datos.idproducto = Entradas.idproducto 
		Left join ( Select idproducto, Sum(cantidad) as Salidas from operacion WHERE tipo_operacion_id='2' AND idalmacen='$idalmacen' 
		Group by idproducto) as Salidas On Datos.idproducto = Salidas.idproducto 
		INNER JOIN producto p ON Datos.idproducto=p.idproducto 
		INNER JOIN categoria c ON c.idcategoria=p.idcategoria 
		INNER JOIN operacion o ON o.idproducto=p.idproducto 
		WHERE p.condicion='1' and o.idalmacen='$idalmacen' group by o.idproducto";
		return ejecutarConsulta($sql);

	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostraringreso($idingreso)
	{
		$sql="SELECT DISTINCT i.idingreso,al.idalmacen as origen,u.idusuario,u.nombre as usuario, a.idalmacen as destino,i.estado 
		FROM transaccion i 
		INNER JOIN usuario u ON i.idusuario=u.idusuario 
		INNER JOIN operacion o ON i.idingreso=o.transaccion_id 
		INNER JOIN almacen a ON i.almacen_to_id=a.idalmacen 
		inner join almacen al ON i.almacen_des_id=al.idalmacen WHERE i.tipo_operacion_id='6' and i.idingreso='$idingreso'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idingreso)
	{
		$sql="SELECT DISTINCT o.transaccion_id,o.idproducto,p.nombre, o.cantidad,o.price_compra,o.idprecio_lis 
		FROM operacion o inner join producto p on o.idproducto=p.idproducto where o.transaccion_id='$idingreso'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT DISTINCT i.idingreso,al.nombre as origen,a.idalmacen,u.idusuario,u.nombre as usuario, a.nombre as destino,i.estado FROM transaccion i 
		INNER JOIN usuario u ON i.idusuario=u.idusuario 
		INNER JOIN operacion o ON i.idingreso=o.transaccion_id 
		INNER JOIN almacen a ON i.almacen_to_id=a.idalmacen 
		inner join almacen al ON i.almacen_des_id=al.idalmacen WHERE i.tipo_operacion_id='6'";
		return ejecutarConsulta($sql);		
	}
	
	public function listadopago(){
		$sql="SELECT *from almacen";
		return ejecutarConsulta($sql);
	}
	
}

?>