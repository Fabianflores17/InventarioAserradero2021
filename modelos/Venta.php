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
	public function insertar($idcliente,$idalmacen,$idpago,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$fecha_pro,$idarticulo,$precio_compra,$cantidad,$precio_venta,$descuento)
	{
		$sql_venta="INSERT INTO venta (idcliente,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_venta)
		VALUES ('$idcliente','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_venta')";
		$sql="INSERT INTO transaccion (idpersona,idusuario,tipo_comprobante,serie,codigo_factura,fecha,iva,tipo_pago,forma_pago,total,tipo_operacion_id,estado)
		VALUES ('$idcliente','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$idpago','1','$total_venta','2','1')";
		//ejecutarConsulta($sql);
		$idingresonew=ejecutarConsulta_retornarID($sql);	
		$idventa=ejecutarConsulta_retornarID($sql_venta);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle = "INSERT INTO operacion (transaccion_id,idproducto,cantidad,price_compra,idprecio_lis,tipo_operacion_id,idalmacen) VALUES ('$idingresonew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]','$precio_venta[$num_elementos]','2','$idalmacen')";
			$sql_detalle_venta = "INSERT INTO detalle_venta(idventa, idarticulo,cantidad,precio_venta,descuento) VALUES ('$idventa', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";
			ejecutarConsulta($sql_detalle_venta);
			ejecutarConsulta($sql_detalle) or $sw = false;	
			$num_elementos=$num_elementos + 1;
			if($idpago==2){
				$sql_credito="INSERT INTO credito (tipo_pago_id,transaccion_id,idpersona,total,diasxpro)
				VALUES ('1','$idingresonew','$idcliente','$total_venta','$fecha_pro')";
					ejecutarConsulta($sql_credito);
			}
			
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
		//$sql="UPDATE venta SET estado='1' WHERE idventa='$idventa'";
		$sqlope="UPDATE operacion SET status='0' WHERE transaccion_id='$idventa'";
		$sqltras="UPDATE transaccion SET estado='0' WHERE idingreso='$idventa'";
		ejecutarConsulta($sqlope);
		return ejecutarConsulta($sqltras);
		//return ejecutarConsulta($sql);

	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventa)
	{
		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,o.idalmacen,i.tipo_pago,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado 
		FROM venta v 
		INNER JOIN persona p ON v.idcliente=p.idpersona 
		inner join transaccion i ON i.idpersona=p.idpersona
		inner join operacion o On o.id=i.idingreso 
		INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}

		//Implementar un método para mostrar los datos de un registro a modificar
		public function mostrarventa($idventa)
		{
			$sql="SELECT v.idingreso,v.fecha as fecha,v.idpersona,o.idalmacen,v.tipo_pago,v.tipo_comprobante,v.serie,v.codigo_factura,v.total,v.estado 
			FROM transaccion v 
		-- INNER JOIN persona p ON v.idpersona=p.idpersona 
			inner join operacion o On o.transaccion_id=v.idingreso 
		-- INNER JOIN usuario u ON v.idusuario=u.idusuario 
			WHERE v.idingreso='$idventa'";
			return ejecutarConsultaSimpleFila($sql);
		}



	public function mostrarcredito($idventa)
	{
		$sql="SELECT Distinct i.idingreso,i.fecha,c.diasxpro as fechapro,a.idalmacen,a.nombre as almacen,(deuda.deuda-ifnull(abono.abono,0)) as totales,i.idpersona,i.forma_pago,i.tipo_pago,i.tipo_comprobante,i.codigo_factura,i.serie,p.nombre as nombrepersona,u.idusuario,u.nombre as usuario,i.total,i.iva,i.estado 
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

		$sql="SELECT DISTINCT o.transaccion_id,o.idproducto,p.nombre, o.cantidad,o.idprecio_lis,o.idalmacen 
		FROM operacion o inner join producto p on o.idproducto=p.idproducto where o.transaccion_id='$idventa'";
		return ejecutarConsulta($sql);
		// $sql="SELECT dv.idventa,dv.idarticulo,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal 
		// FROM detalle_venta dv 
		// INNER JOIN producto a ON dv.idarticulo=a.idproducto WHERE dv.idventa='$idventa'";
		// return ejecutarConsulta($sql);
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
		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado 
		FROM venta v 
		INNER JOIN persona p ON v.idcliente=p.idpersona 
		INNER JOIN usuario u ON v.idusuario=u.idusuario ORDER by v.idventa desc";
		return ejecutarConsulta($sql);		
	}

	public function listartrans()
	{
		$sql="SELECT v.idingreso ,v.fecha as fecha,v.idpersona,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie,v.codigo_factura,v.total,v.estado 
		FROM transaccion v 
		INNER JOIN persona p ON v.idpersona=p.idpersona 
		INNER JOIN usuario u ON v.idusuario=u.idusuario
		Where v.tipo_operacion_id='2' ORDER by v.idingreso desc";
		return ejecutarConsulta($sql);		
	}


	public function listarcredito()
	{
		$sql="SELECT c.transaccion_id,DATE(c.create_at) as fechainicio,c.diasxpro as fechaventa,(deuda.deuda-ifnull(abono.abono,0)) as totales,i.tipo_comprobante,p.nombre as cliente,u.idusuario,u.nombre as usuario,i.estado 
		FROM transaccion i 
		INNER JOIN persona p ON i.idpersona=p.idpersona 
		INNER JOIN usuario u ON i.idusuario=u.idusuario 
		INNER JOIN credito c ON p.idpersona=c.idpersona
		left join (select transaccion_id, sum(total) as deuda FROM credito WHERE tipo_pago_id='1' GROUP BY transaccion_id) as deuda On c.transaccion_id=deuda.transaccion_id 
		left join (select transaccion_id, sum(total) as abono FROM credito WHERE tipo_pago_id='2' GROUP BY transaccion_id) as abono on c.transaccion_id=abono.transaccion_id
		 where tipo_operacion_id='2'  group by c.transaccion_id";	
		return ejecutarConsulta($sql);		
	}
	
	
	public function listarprecio($idarticulo){
		$sql="SELECT * FROM listaprecio where idproducto='$idarticulo'";
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
		$sql="SELECT MAX(o.price_compra) as precio_compra,Datos.idproducto,p.codigo,o.idalmacen,l.precio,l.precio2,l.precio3,precio4,l.precio5,l.precio6,l.precio7,precio8,l.precio9,l.precio10,p.condicion,p.nombre,c.nombre as categoria, Entradas.Entradas - IFNULL(Salidas.Salidas,0) as stock 
		From ( Select distinct idproducto From operacion ) as Datos 
		Left join ( Select idproducto, Sum(cantidad) as Entradas from operacion WHERE tipo_operacion_id='1' AND idalmacen='$idalmacen' 
		Group by idproducto) as Entradas On Datos.idproducto = Entradas.idproducto 
		Left join ( Select idproducto, Sum(cantidad) as Salidas from operacion WHERE tipo_operacion_id='2' AND idalmacen='$idalmacen' 
		Group by idproducto) as Salidas On Datos.idproducto = Salidas.idproducto 
		INNER JOIN producto p ON Datos.idproducto=p.idproducto 
		INNER JOIN categoria c ON c.idcategoria=p.idcategoria 
		INNER JOIN operacion o ON o.idproducto=p.idproducto 
		inner join listaprecio l ON l.idproducto=p.idproducto
		WHERE p.condicion='1' and o.idalmacen='$idalmacen' group by o.idproducto";
		return ejecutarConsulta($sql);

	}

}
?>