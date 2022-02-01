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
	public function insertar($formapago,$idusuario,$total_venta,$fecha_pro,$idsocio,$idarticulo,$cantidad,$precio_venta,$descuento)
	{
		if($formapago==1){
		$sql_venta="INSERT INTO cajachica (tipo_transacion,monto,kind)
		VALUES ('2','$total_venta','1')";
		//ejecutarConsulta($sql_venta);
		$idventa=ejecutarConsulta_retornarID($sql_venta);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle_venta = "INSERT INTO detalle_pago (transaccion_id,idpersona,cantidad,pago,descuento,condicion,fecha,forma_pago,idusuario,idsocio) VALUES ('$idventa', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]','1','$fecha_pro','$formapago','$idusuario','$idsocio')";
			ejecutarConsulta($sql_detalle_venta) or $sw = false;	
			$num_elementos=$num_elementos + 1;
			
		}
		return $sw;
	}
	
	elseif($formapago==2){
		$num_elementos=0;
		$sw=true; 

		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle_venta = "INSERT INTO detalle_pago (idpersona,cantidad,pago,descuento,condicion,fecha,forma_pago,idusuario,idsocio) VALUES ('$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]','1','$fecha_pro','$formapago','$idusuario','$idsocio')";
			ejecutarConsulta($sql_detalle_venta) or $sw = false;	
			$num_elementos=$num_elementos + 1;
			
		}
		return $sw;
	}

	elseif($formapago==3){
		$num_elementos=0;
		$sw=true; 
		
		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle_venta = "INSERT INTO detalle_pago (idpersona,cantidad,pago,descuento,condicion,fecha,forma_pago,idusuario,idsocio) VALUES ('$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]','1','$fecha_pro','$formapago','$idusuario','$idsocio')";
			ejecutarConsulta($sql_detalle_venta) or $sw = false;	
			$num_elementos=$num_elementos + 1;
			
		}
		return $sw;
	}


	
	}


	public function insertarpagoplanilla($formapago,$idusuario,$total_venta,$fecha_pro,$idsocio,$idplanilla,$mes,$totalplanilla)

		{
			if($formapago==1){
			$sql_venta="INSERT INTO cajachica (tipo_transacion,monto,kind)
			VALUES ('2','$total_venta','1')";
			//ejecutarConsulta($sql_venta);
			$idventa=ejecutarConsulta_retornarID($sql_venta);
	
			$num_elementos=0;
			$sw=true;
	
			while ($num_elementos < count($idplanilla))
			{
				$sql_detalle_venta = "INSERT INTO detalle_pago (transaccion_id,idplanilla,cantidad,pago,condicion,fecha,forma_pago,idusuario,idsocio) VALUES ('$idventa', '$idplanilla[$num_elementos]','$mes[$num_elementos]','$totalplanilla[$num_elementos]','1','$fecha_pro','$formapago','$idusuario','$idsocio')";
				ejecutarConsulta($sql_detalle_venta) or $sw = false;	
				$num_elementos=$num_elementos + 1;
				
			}
			return $sw;
		}
		
		elseif($formapago==2){
			$numero=0;

			$sql_venta="INSERT INTO pago_socios (descripcion,idsocio,idplanilla,total,fecha)
			VALUES ('Pago planilla','$idsocio','$idplanilla[$numero]','$total_venta','$fecha_pro')";
			//ejecutarConsulta($sql_venta);
			$idventa=ejecutarConsulta_retornarID($sql_venta);

			$num_elementos=0;
			$sw=true; 
	
			while ($num_elementos < count($idplanilla))
			{
				$sql_detalle_venta = "INSERT INTO detalle_pago (idplanilla,cantidad,pago,condicion,fecha,forma_pago,idusuario,idsocio,idpagosocios) VALUES ('$idplanilla[$num_elementos]','$mes[$num_elementos]','$totalplanilla[$num_elementos]','1','$fecha_pro','$formapago','$idusuario','$idsocio',$idventa)";
				ejecutarConsulta($sql_detalle_venta) or $sw = false;	
				$num_elementos=$num_elementos + 1;
				
			}
			return $sw;
		}
	
		elseif($formapago==3){
			$sql_venta="INSERT INTO cuenta (tipo_transaccion,descripcion,monto,fecha,condicion)
			VALUES ('2','Pago de planilla','$total_venta','$fecha_pro','1')";
			//ejecutarConsulta($sql_venta);
			$idventa=ejecutarConsulta_retornarID($sql_venta);
			$num_elementos=0;
			$sw=true; 
			
			while ($num_elementos < count($idplanilla))
			{
				$sql_detalle_venta = "INSERT INTO detalle_pago (idplanilla,cantidad,pago,condicion,fecha,forma_pago,idusuario,idcuenta) VALUES ('$idplanilla[$num_elementos]','$mes[$num_elementos]','$totalplanilla[$num_elementos]','1','$fecha_pro','$formapago','$idusuario','$idventa')";
				ejecutarConsulta($sql_detalle_venta) or $sw = false;	
				$num_elementos=$num_elementos + 1;
				
			}
			return $sw;
		}
	
	
		
		}



		public function editarpagoplanilla($idarticulo,$tipoproduc,$idcategoria,$codigo,$nombre,$presentacion,$unidad,$descripcion,$imagen)
	{
		$sql="UPDATE producto SET tipo_producto='$tipoproduc',idcategoria='$idcategoria',codigo='$codigo',nombre='$nombre',presentation='$presentacion',unit='$unidad',descripcion='$descripcion',imagen='$imagen' WHERE idproducto='$idarticulo'";
		return ejecutarConsulta($sql);
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
		$sql="SELECT d.iddetalle,d.pago,d.cantidad, d.descuento,d.condicion,d.fecha,d.forma_pago,d.idsocio
		FROM detalle_pago as d where d.iddetalle='$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}

	
    public function mostrarpagosocio($idventa)
	{
		$sql="SELECT d.idpagosocios,pla.nombre, (deuda.deuda-ifnull(abono.abono,0)) as total_socio 
		FROM detalle_pago as d 
		inner join usuario u ON d.idusuario=u.idusuario 
		inner join pago_socios p ON p.idpagosocios=d.idpagosocios 
		inner join planilla pla On pla.idplanilla=d.idplanilla 
		left join (select idpagosocios, sum(total) as deuda FROM pago_socios WHERE tipo_pago='1' GROUP BY idpagosocios) as deuda On d.idpagosocios=deuda.idpagosocios 
		left join (select idpagosocios, sum(total) as abono FROM pago_socios WHERE tipo_pago='2' GROUP BY idpagosocios) as abono on d.idpagosocios=abono.idpagosocios 
		where p.idpagosocios='$idventa' GROUP by p.idpagosocios";
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
		$sql="SELECT d.iddetalle,d.pago,d.cantidad, d.descuento, p.nombre as colaborador
		FROM detalle_pago as d
		inner join persona p ON d.idpersona=p.idpersona WHERE d.iddetalle='$idventa'";
		return ejecutarConsulta($sql);
	}

	public function listarDetalleplanilla($idventa)
	{
		$sql="SELECT d.iddetalle,d.pago,d.cantidad, d.descuento, p.nombre as planilla
		FROM detalle_pago as d
		inner join planilla p ON d.idplanilla=p.idplanilla WHERE d.iddetalle='$idventa'";
		return ejecutarConsulta($sql);
	}

	public function listarDetalleplanillasocios($idventa)
	{
		$sql="SELECT d.iddetalle,d.pago,d.cantidad, d.descuento, p.nombre as planilla
		FROM detalle_pago as d
		inner join planilla p ON d.idplanilla=p.idplanilla WHERE d.idpagosocios='$idventa'";
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
		$sql="SELECT d.iddetalle,d.pago,d.cantidad, d.descuento,d.condicion,d.fecha,d.forma_pago, u.nombre as usuario
		FROM detalle_pago as d
		inner join usuario u ON d.idusuario=u.idusuario
		where d.idpersona";
		return ejecutarConsulta($sql);		
	}


	public function listarpagosocios()


	{
		$sql="SELECT d.idpagosocios,d.condicion,d.fecha, u.nombre as usuario, (deuda.deuda-ifnull(abono.abono,0)) as totales 
		FROM detalle_pago as d 
		inner join usuario u ON d.idusuario=u.idusuario 
		inner join pago_socios p ON p.idpagosocios=d.idpagosocios 
		left join (select idpagosocios, sum(total) as deuda FROM pago_socios WHERE tipo_pago='1' GROUP BY idpagosocios) as deuda On d.idpagosocios=deuda.idpagosocios 
		left join (select idpagosocios, sum(total) as abono FROM pago_socios WHERE tipo_pago='2' GROUP BY idpagosocios) as abono on d.idpagosocios=abono.idpagosocios 
		GROUP by p.idpagosocios";
		return ejecutarConsulta($sql);		
	}

	public function listar_planilla()
	{
		$sql="SELECT d.iddetalle,d.pago,d.cantidad,d.condicion,d.fecha,d.forma_pago, u.nombre as usuario,p.nombre
		FROM detalle_pago as d
		inner join usuario u ON d.idusuario=u.idusuario
		inner join planilla p ON p.idplanilla=d.idplanilla
		where d.idplanilla";
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

	public function pagocabecera($idventa){
		$sql="SELECT d.fecha,p.nombre as colaborador,d.cantidad,d.pago
		FROM detalle_pago d 
		inner join persona p on p.idpersona=d.idpersona
		WHERE d.iddetalle='$idventa'";
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


	public function listarPlanilla()
	{
		// $sql="SELECT SUM(p.limite_credito-(p.limite_credito/30*Falta.Falta)) as totalplanilla,pa.idplanilla,pa.nombre,pa.mes 
		// From ( Select DISTINCT idpersona From asistencia ) as Datos 
		// Left join ( Select asis.idpersona, COUNT(tipo_asistencia) as Falta from asistencia asis INNER JOIN persona p ON asis.idpersona=p.idpersona INNER JOIN planilla pa ON p.tipo_person=pa.tipo_empleado WHERE asis.tipo_asistencia='2' AND asis.fecha BETWEEN pa.fecha_inicio and pa.fecha_final GROUP by asis.idpersona) as Falta On Datos.idpersona = Falta.idpersona 
		// inner join persona p ON datos.idpersona=p.idpersona 
		// inner join planilla pa on pa.tipo_empleado=p.tipo_person";
		// return ejecutarConsulta($sql);

		$sql="SELECT p.idplanilla ,p.nombre,p.mes FROM planilla p";
		return ejecutarConsulta($sql);

	}
 
	public function mostrardatos($idplanilla){
		
	$sql="SELECT SUM(p.sueldos-(p.sueldos/30*Falta.Falta)) as totalplanilla,pa.idplanilla,pa.nombre,pa.mes 
	From ( Select DISTINCT idpersona From asistencia ) as Datos Left 
	join ( Select asis.idpersona, COUNT(tipo_asistencia) as Falta from asistencia asis 
	INNER JOIN persona p ON asis.idpersona=p.idpersona 
	INNER JOIN planilla pa ON p.tipo_person=pa.tipo_empleado 
	WHERE asis.tipo_asistencia='2' and pa.idplanilla='$idplanilla' AND asis.fecha BETWEEN pa.fecha_inicio and pa.fecha_final GROUP by asis.idpersona) as Falta On Datos.idpersona = Falta.idpersona 
	inner join datos_planilla p ON datos.idpersona=p.idpersona inner join planilla pa on pa.idplanilla=p.idplanilla 
	WHERE pa.idplanilla='$idplanilla'";
	return ejecutarConsulta($sql);

	}

	public function mostrarcaja()
	{

	
		$sql="SELECT (SELECT Sum(monto) From cajachica where tipo_transacion='1') - 
		(SELECT Sum(monto) From cajachica where tipo_transacion='2') total";	
		return ejecutarConsulta($sql);		
	}


	public function mostrarestado_cuenta()
	{

	
		$sql="SELECT (SELECT Sum(monto) From cuenta where tipo_transaccion='1') - 
		(SELECT Sum(monto) From cuenta where tipo_transaccion='2') total";	
		return ejecutarConsulta($sql);		
	}

}
?>