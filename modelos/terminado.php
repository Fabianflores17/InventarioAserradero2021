<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Venta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	//transaccion y operacion
	//Implementamos un método para insertar registros
	public function insertar($idproducto,$idusuario,$idalmacen,$totalunit,$cantidadgenerada,$total_venta,$idarticulo,$cantidad,$precio_venta,$descuento)
	{
		$sql="INSERT INTO transaccion (idusuario,total,tipo_operacion_id,estado)
		VALUES ('$idusuario','$total_venta','3','1')";
		//return ejecutarConsulta($sql);
	  	$idingresonew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		$sql_detalle = "INSERT INTO operacion (transaccion_id,idproducto,cantidad,price_compra,tipo_operacion_id,idalmacen) 
		VALUES ('$idingresonew', '$idproducto','$cantidadgenerada','$totalunit','1','$idalmacen')";
		ejecutarConsulta($sql_detalle);

		while ($num_elementos < count($idarticulo))
		{
			
			$sql_detalles = "INSERT INTO operacion (transaccion_id,idproducto,cantidad,price_compra,tipo_operacion_id,idalmacen) 
			VALUES ('$idingresonew','$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','2','$idalmacen')";
			
			ejecutarConsulta($sql_detalles) or $sw = false;	
			$num_elementos=$num_elementos + 1;
		
		}

		return $sw;
	}

	public function insertarcredito($idcliente,$idventa,$total_pago){

		$sql="INSERT INTO credito (tipo_pago_id,transaccion_id,idpersona,total)
		values ('2','$idventa','$idcliente','$total_pago')";
		ejecutarConsulta($sql);
	}

	
	//Implementamos un método para anular la venta
	public function anular($idventa)
	{
		$sql="UPDATE venta SET estado='1' WHERE idventa='$idventa'";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventa)
	{
		$sql="SELECT  o.idalmacen,o.idproducto,o.cantidad,o.price_compra
		FROM transaccion i
		inner join operacion o On o.transaccion_id=i.idingreso 
		inner join almacen a ON a.idalmacen=o.idalmacen
		WHERE o.transaccion_id='$idventa' and o.tipo_operacion_id='1'";
		return ejecutarConsultaSimpleFila($sql);
	}



	public function mostrarcredito($idventa)
	{
		$sql="SELECT Distinct i.idingreso,i.fecha,c.created_at as fechapro,a.idalmacen,a.nombre as almacen,(deuda.deuda-ifnull(abono.abono,0)) as totales,i.idpersona,i.forma_pago,i.tipo_pago,i.tipo_comprobante,i.codigo_factura,i.serie,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.total,i.iva,i.estado 
		FROM transaccion i 
		INNER JOIN persona p ON i.idpersona=p.idpersona 
		INNER JOIN usuario u ON i.idusuario=u.idusuario 
		inner join operacion o On i.idingreso=o.transaccion_id
		inner join almacen a ON o.idalmacen=a.idalmacen
		INNER JOIN credito c ON i.idpersona=c.idpersona
		left join (select transaccion_id, sum(total) as deuda FROM credito WHERE tipo_pago_id='1' and transaccion_id='$idventa') as deuda On c.transaccion_id=deuda.transaccion_id 
		left join (select transaccion_id, sum(total) as abono FROM credito WHERE tipo_pago_id='2' and transaccion_id='$idventa') as abono on c.transaccion_id=abono.transaccion_id
		WHERE i.idingreso='$idventa' and c.transaccion_id='$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}	

	public function listarDetalle($idventa)
	{
		$sql="SELECT DISTINCT o.transaccion_id,o.idproducto,p.nombre, o.cantidad,o.price_compra,o.idalmacen 
		FROM operacion o 
		inner join producto p on o.idproducto=p.idproducto 
		where o.transaccion_id='$idventa' and o.tipo_operacion_id='2'";
		return ejecutarConsulta($sql);
	}

	public function listarDetallecredito($idventa)
	{
	$sql="SELECT DISTINCT o.transaccion_id,o.idproducto,p.nombre, o.cantidad,o.idprecio_lis,o.idalmacen 
		FROM operacion o inner join producto p on o.idproducto=p.idproducto where o.transaccion_id='$idventa'";
	return ejecutarConsulta($sql);
}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT DISTINCT i.idingreso, u.nombre as usuario,p.nombre as producto,o.cantidad, i.estado
		FROM transaccion i 
		INNER JOIN usuario u ON i.idusuario=u.idusuario
		inner join operacion o ON o.transaccion_id=i.idingreso 
		inner join producto p ON p.idproducto=o.idproducto
		Where i.tipo_operacion_id='3' and o.tipo_operacion_id='1' ORDER by i.idingreso desc";
		return ejecutarConsulta($sql);		
	}


	public function listarcredito()
	{
		$sql="SELECT c.transaccion_id,c.created_at as fechaventa,(deuda.deuda-ifnull(abono.abono,0)) as totales,i.tipo_comprobante,p.nombre as cliente,u.idusuario,u.nombre as usuario,i.estado 
		FROM transaccion i 
		INNER JOIN persona p ON i.idpersona=p.idpersona 
		INNER JOIN usuario u ON i.idusuario=u.idusuario 
		INNER JOIN credito c ON p.idpersona=c.idpersona
		left join (select transaccion_id, sum(total) as deuda FROM credito WHERE tipo_pago_id='1' GROUP BY transaccion_id) as deuda On c.transaccion_id=deuda.transaccion_id 
		left join (select transaccion_id, sum(total) as abono FROM credito WHERE tipo_pago_id='2' GROUP BY transaccion_id) as abono on c.transaccion_id=abono.transaccion_id
		 where tipo_operacion_id='2' group by c.transaccion_id";	
		return ejecutarConsulta($sql);		
	}

	public function ventacabecera($idventa){
		$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	public function ventadetalle($idventa){
		$sql="SELECT a.nombre as articulo,a.codigo,d.cantidad,d.precio_venta,d.descuento,(d.cantidad*d.precio_venta-d.descuento) as subtotal FROM detalle_venta d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.idventa='$idventa'";
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
		WHERE p.condicion='1' and o.idalmacen='$idalmacen' and tipo_producto='1' group by o.idproducto";
		return ejecutarConsulta($sql);

	}

}
?>