<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	// public function comprasfecha($fecha_inicio,$fecha_fin)
	// {
	// 	$sql="SELECT DATE(i.fecha_hora) as fecha,u.nombre as usuario, p.nombre as proveedor,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE DATE(i.fecha_hora)>='$fecha_inicio' AND DATE(i.fecha_hora)<='$fecha_fin'";
	// 	return ejecutarConsulta($sql);
	// }

	public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente)
	{
		
		$sql="SELECT DATE(v.fecha_hora) as fecha,u.nombre as usuario, p.nombre as cliente,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v 
		INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario 
		WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND
		case when '$idcliente'!='' then v.idcliente='$idcliente' else v.idcliente end	
		";
		return ejecutarConsulta($sql);

	}

	public function estadodecuenta($fecha_inicio,$fecha_fin,$idcliente)
	{
		if($idcliente==''){
		$sql="SELECT c.fecha,c.monto,c.tipo_transaccion,c.descripcion,c.condicion, 
		ifnull((SELECT Sum(monto) From cuenta where tipo_transaccion='1' and DATE(fecha)>='$fecha_inicio' AND DATE(fecha)<='$fecha_fin'),0)-ifnull((SELECT Sum(monto) From cuenta where tipo_transaccion='2' and DATE(fecha)>='$fecha_inicio' AND DATE(fecha)<='$fecha_fin'),0) total FROM cuenta c
		WHERE DATE(c.fecha)>='$fecha_inicio' AND DATE(c.fecha)<='$fecha_fin' order by c.fecha asc";
		return ejecutarConsulta($sql);
		// $ql_total="SELECT DISTINCT(SELECT Sum(monto) From cuenta where tipo_transaccion='1' and DATE(fecha)>='$fecha_inicio' AND DATE(fecha)<='$fecha_fin')-(SELECT Sum(monto) From cuenta where tipo_transaccion='2' and DATE(fecha)>='$fecha_inicio' AND DATE(fecha)<='$fecha_fin') total";
		// return ejecutarConsulta($ql_total);
		}
		else{
		$sql="SELECT c.fecha,c.monto,c.tipo_transaccion,c.descripcion,c.condicion, (SELECT Sum(monto) From cuenta where tipo_transaccion='$idcliente' and DATE(fecha)>='$fecha_inicio' AND DATE(fecha)<='$fecha_fin') total FROM cuenta c
		WHERE c.tipo_transaccion='$idcliente' and DATE(c.fecha)>='$fecha_inicio' AND DATE(c.fecha)<='$fecha_fin' order by c.fecha asc";
		return ejecutarConsulta($sql);
		}
	}

	// public function mostrar($fecha_inicio,$fecha_fin,$idcliente)
	// {
	// 	if($idcliente==''){
	// 	$sql="SELECT DISTINCT (SELECT Sum(monto) From cuenta where tipo_transaccion='1' and DATE(fecha)>='$fecha_inicio' AND DATE(fecha)<='$fecha_fin')-(SELECT Sum(monto) From cuenta where tipo_transaccion='2' and DATE(fecha)>='$fecha_inicio' AND DATE(fecha)<='$fecha_fin') total,c.condicion
	// 	FROM cuenta c
	// 	WHERE DATE(c.fecha)>='$fecha_inicio' AND DATE(c.fecha)<='$fecha_fin' 
	// 	-- case when '$idcliente'!='' then c.tipo_transaccion='$idcliente' else c.tipo_transaccion end	
	// 	";
	// 	return ejecutarConsulta($sql);
	// }
	// }

	// SELECT c.fecha,c.monto,c.tipo_transaccion,c.descripcion,c.condicion, 
	// (SELECT Sum(monto) From cuenta where tipo_transaccion='1' and DATE(fecha)>='2022-01-04' AND DATE(fecha)<='2022-01-27')- (SELECT Sum(monto) From cuenta where tipo_transaccion='2' and DATE(fecha)>='2022-01-04' AND DATE(fecha)<='2022-01-27') total FROM cuenta c 
	// WHERE DATE(c.fecha)>='2022-01-04' AND DATE(c.fecha)<='2022-01-27'

	public function totalcomprahoy()
	{
		$sql="SELECT IFNULL(SUM(total),0) as total_compra FROM transaccion WHERE DATE(created_at)=curdate() and tipo_operacion_id='1'";
		return ejecutarConsulta($sql);
	}

	public function totalventahoy()
	{
		$sql="SELECT IFNULL(SUM(total),0) as total_venta FROM transaccion WHERE DATE(created_at)=curdate() and tipo_operacion_id='2'";
		return ejecutarConsulta($sql);
	}

	public function comprasultimos_10dias()
	{
		$sql="SELECT CONCAT(DAY(created_at),'-',MONTH(created_at)) as fecha,SUM(total) as total FROM transaccion GROUP by created_at ORDER BY created_at DESC limit 0,10";
		return ejecutarConsulta($sql);
	}

	public function ventasultimos_12meses()
	{
		$sql="SELECT DATE_FORMAT(created_at,'%M') as fecha,SUM(total) as total FROM transaccion GROUP by MONTH(created_at) ORDER BY created_at DESC limit 0,10";
		return ejecutarConsulta($sql);
	}
	// public function Totalventas()
	// {
	// 	$sql="SELECT SUM(DISTINCT v.total_venta-d.descuento) as total_venta FROM venta v right JOIN detalle_venta as d ON v.idventa=d.idventa WHERE v.estado='Aceptado'";
	// 	return ejecutarConsulta($sql);
	// }
	public function Totalventas()
		{
			$sql="SELECT SUM(total_venta) as total_venta FROM venta WHERE estado='Aceptado'";
			return ejecutarConsulta($sql);
	}

	public function Totalcajaingresos()
		{
			$sql="SELECT SUM(cantida) as total_ingreso FROM caja";
			return ejecutarConsulta($sql);
	}

	public function TotalCompra()
		{
			$sql="SELECT SUM(total_compra) as compras FROM ingreso WHERE estado='Aceptado'";
			return ejecutarConsulta($sql);
	}

	
	public function listar_calif()
		{
			$sql="SELECT * FROM persona WHERE tipo_person='3'";
			return ejecutarConsulta($sql);
	}


	public function listar_asistencia($idpersona,$fecha)
	{
		$sql="SELECT * FROM asistencia where idpersona='$idpersona' and fecha='$fecha'";
		return ejecutarConsulta($sql);
}

//Reporte venta
public function reporteventa($fecha_inicio,$fecha_fin,$idcliente,$tipo_pago)
	{
		$sql=" SELECT v.idingreso ,v.fecha as fecha,v.idpersona,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie,v.codigo_factura,v.total,v.tipo_pago,v.estado FROM transaccion v 
		INNER JOIN persona p ON v.idpersona=p.idpersona 
		INNER JOIN usuario u ON v.idusuario=u.idusuario 
		Where v.tipo_operacion_id='2' AND DATE(v.fecha)>='$fecha_inicio' AND DATE(v.fecha)<='$fecha_fin' 
		and (case when '$tipo_pago'!='' then v.tipo_pago='$tipo_pago' else v.tipo_pago end) AND
		(case when '$idcliente'!='' then v.idpersona='$idcliente' else v.idpersona end);
		";
		return ejecutarConsulta($sql);		
	}
	

	public function comprasfecha($fecha_inicio,$fecha_fin,$idproveedor,$tipo_pago)
	{
		$sql=" SELECT v.idingreso ,v.fecha as fecha,v.idpersona,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie,v.codigo_factura,v.total,v.tipo_pago,v.estado FROM transaccion v 
		INNER JOIN persona p ON v.idpersona=p.idpersona 
		INNER JOIN usuario u ON v.idusuario=u.idusuario 
		Where v.tipo_operacion_id='1' AND DATE(v.fecha)>='$fecha_inicio' AND DATE(v.fecha)<='$fecha_fin' 
		and (case when '$tipo_pago'!='' then v.tipo_pago='$tipo_pago' else v.tipo_pago end) AND
		(case when '$idproveedor'!='' then v.idpersona='$idproveedor' else v.idpersona end);
		";
		return ejecutarConsulta($sql);		
	}

	public function mostrartotalventas($fecha_inicio,$fecha_fin,$idcliente,$tipo_pago){
		$sql="SELECT sum(v.total) as totales FROM transaccion v 
		INNER JOIN persona p ON v.idpersona=p.idpersona 
		INNER JOIN usuario u ON v.idusuario=u.idusuario 
		Where v.tipo_operacion_id='2' AND DATE(v.fecha)>='$fecha_inicio' AND DATE(v.fecha)<='$fecha_fin' 
		and (case when '$tipo_pago'!='' then v.tipo_pago='$tipo_pago' else v.tipo_pago end) AND
		(case when '$idcliente'!='' then v.idpersona='$idcliente' else v.idpersona end);";
		return ejecutarConsulta($sql);
	}

	public function mostrartotalcompra($fecha_inicio,$fecha_fin,$idproveedor,$tipo_pago){
		$sql="SELECT sum(v.total) as totales FROM transaccion v 
		INNER JOIN persona p ON v.idpersona=p.idpersona 
		INNER JOIN usuario u ON v.idusuario=u.idusuario 
		Where v.tipo_operacion_id='1' AND DATE(v.fecha)>='$fecha_inicio' AND DATE(v.fecha)<='$fecha_fin' 
		and (case when '$tipo_pago'!='' then v.tipo_pago='$tipo_pago' else v.tipo_pago end) AND
		(case when '$idproveedor'!='' then v.idpersona='$idproveedor' else v.idpersona end);";
		return ejecutarConsulta($sql);
	}
	public function mostrartotalcaja($fecha_inicio,$fecha_fin,$tipo_pago)
	{
		if($tipo_pago==''){
		$sql="SELECT ifnull((SELECT Sum(monto) From cajachica where tipo_transacion='1' and DATE(fecha)>='$fecha_inicio' AND DATE(fecha)<='$fecha_fin'),0)-ifnull((SELECT Sum(monto) From cajachica where tipo_transacion='2' and DATE(fecha)>='$fecha_inicio' AND DATE(fecha)<='$fecha_fin'),0) totales ";
		return ejecutarConsulta($sql);
		}
		else{
			$sql="SELECT ifnull((SELECT Sum(monto) From cajachica where tipo_transacion='$tipo_pago' and DATE(fecha)>='$fecha_inicio' AND DATE(fecha)<='$fecha_fin'),0) totales ";
		return ejecutarConsulta($sql);

		}
	}

	public function mostrartotalganancia($fecha_inicio,$fecha_fin,$idproducto)
	{
		
		$sql="SELECT sum((ifnull(o.cantidad*o.idprecio_lis,0))-ifnull(o.cantidad*o.price_compra,0)) as totales
		FROM transaccion t 
		INNER join operacion o ON o.transaccion_id=t.idingreso 
		inner join producto p on p.idproducto=o.idproducto 
		where t.tipo_operacion_id='2' AND DATE(t.fecha)>='$fecha_inicio' AND DATE(t.fecha)<='$fecha_fin' and
		(case when '$idproducto'!='' then o.idproducto='$idproducto' else o.idproducto end) ";
		return ejecutarConsulta($sql);
		
	}
	
	public function reportecaja($fecha_inicio,$fecha_fin,$tipo_pago)
	{

		$sql="SELECT c.tipo_transacion,c.descripcion,c.monto,c.fecha,c.num_documento,u.nombre as usuario From cajachica c 
		inner join usuario u ON c.idusuario=u.idusuario
		where DATE(c.fecha)>='$fecha_inicio' AND DATE(c.fecha)<='$fecha_fin' and (case when '$tipo_pago'!='' then c.tipo_transacion='$tipo_pago' else c.tipo_transacion end)";
		return ejecutarConsulta($sql);

		
	}

	public function reporteganancia($fecha_inicio,$fecha_fin,$idproducto)
	{

		$sql="SELECT p.nombre as producto,o.cantidad, o.price_compra as preciocompra,o.idprecio_lis as precio,t.fecha,((ifnull(o.cantidad*o.idprecio_lis,0))-ifnull(o.cantidad*o.price_compra,0)) as Ganancia 
		FROM transaccion t 
		INNER join operacion o ON o.transaccion_id=t.idingreso 
		inner join producto p on p.idproducto=o.idproducto 
		where t.tipo_operacion_id='2' AND DATE(t.fecha)>='$fecha_inicio' AND DATE(t.fecha)<='$fecha_fin' and (case when '$idproducto'!='' then o.idproducto='$idproducto' else o.idproducto end) ";
		return ejecutarConsulta($sql);

		
	}

}

?>
