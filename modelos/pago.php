<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Colaborador
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	//transaccion y operacion
	//Implementamos un método para insertar registros
	public function insertar($idcliente,$idalmacen,$idpago,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$fecha_pro,$idarticulo,$cantidad,$precio_venta,$descuento)
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
			$sql_detalle = "INSERT INTO operacion (transaccion_id,idproducto,cantidad,idprecio_lis,tipo_operacion_id,idalmacen) VALUES ('$idingresonew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','2','$idalmacen')";
			$sql_detalle_venta = "INSERT INTO detalle_venta(idventa, idarticulo,cantidad,precio_venta,descuento) VALUES ('$idventa', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";
			ejecutarConsulta($sql_detalle_venta);
			ejecutarConsulta($sql_detalle) or $sw = false;	
			$num_elementos=$num_elementos + 1;
			if($idpago==2){
				$sql_credito="INSERT INTO credito (tipo_pago_id,transaccion_id,idpersona,total,created_at)
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
		$sql="UPDATE venta SET estado='1' WHERE idventa='$idventa'";
		return ejecutarConsulta($sql);
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



	public function mostrarcredito($idventa)
	{
		$sql="SELECT Distinct i.idingreso,i.fecha,c.created_at as fechapro,a.idalmacen,a.nombre as almacen,(deuda.deuda-ifnull(abono.abono,0)) as totales,i.idpersona,i.forma_pago,i.tipo_pago,i.tipo_comprobante,i.codigo_factura,i.serie,p.nombre as nombrepersona,u.idusuario,u.nombre as usuario,i.total,i.iva,i.estado 
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
		$sql="SELECT dv.idventa,dv.idarticulo,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal 
		FROM detalle_venta dv 
		INNER JOIN producto a ON dv.idarticulo=a.idproducto WHERE dv.idventa='$idventa'";
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
		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado 
		FROM venta v 
		INNER JOIN persona p ON v.idcliente=p.idpersona 
		INNER JOIN usuario u ON v.idusuario=u.idusuario ORDER by v.idventa desc";
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
		 where tipo_operacion_id='2'  group by c.transaccion_id";	
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

	public function listarColaborador()
	{
		$sql="SELECT idpersona, nombre, cargo FROM persona WHERE tipo_person = '3'";
		return ejecutarConsulta($sql);

	}

}
?>