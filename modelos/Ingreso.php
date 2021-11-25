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
	public function insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$idarticulo,$cantidad,$precio_compra,$precio_venta)
	{
<<<<<<< HEAD
		$sql="INSERT INTO ingreso (idproveedor,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_compra,estado)
		VALUES ('$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_compra','Aceptado')";
=======
		$sql="INSERT INTO transaccion (idpersona,idusuario,tipo_comprobante,serie,codigo_factura,fecha,iva,total,estado)
		VALUES ('$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_compra','1')";
>>>>>>> master
		//return ejecutarConsulta($sql);
		$idingresonew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
<<<<<<< HEAD
			$sql_detalle = "INSERT INTO detalle_ingreso(idingreso, idarticulo,cantidad,precio_compra,precio_venta) VALUES ('$idingresonew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]','$precio_venta[$num_elementos]')";
=======
			$sql_detalle = "INSERT INTO operacion (transaccion_id,idproducto,cantidad,price_compra,idprecio_lis,tipo_operacion_id) VALUES ('$idingresonew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]','$precio_venta[$num_elementos]','1')";
>>>>>>> master
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	
	//Implementamos un método para anular categorías
	public function anular($idingreso)
	{
<<<<<<< HEAD
		$sql="UPDATE ingreso SET estado='Anulado' WHERE idingreso='$idingreso'";
=======
		$sql="UPDATE transaccion SET estado='0' WHERE idingreso='$idingreso'";
>>>>>>> master
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idingreso)
	{
<<<<<<< HEAD
		$sql="SELECT i.idingreso,DATE(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE i.idingreso='$idingreso'";
=======
		$sql="SELECT i.idingreso,i.fecha,i.idpersona,i.tipo_comprobante,codigo_factura,serie,iva,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.total,i.iva,i.estado FROM transaccion i INNER JOIN persona p ON i.idpersona=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE i.idingreso='$idingreso'";
>>>>>>> master
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idingreso)
	{
<<<<<<< HEAD
		$sql="SELECT di.idingreso,di.idarticulo,a.nombre,di.cantidad,di.precio_compra,di.precio_venta FROM detalle_ingreso di inner join articulo a on di.idarticulo=a.idarticulo where di.idingreso='$idingreso'";
=======
		$sql="SELECT o.transaccion_id,o.idproducto,p.nombre, o.cantidad,o.price_compra,o.idprecio_lis 
		FROM operacion o inner join producto p on o.idproducto=p.idproducto where o.transaccion_id='$idingreso'";
>>>>>>> master
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
<<<<<<< HEAD
		$sql="SELECT i.idingreso,DATE(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario ORDER BY i.idingreso desc";
		return ejecutarConsulta($sql);		
	}
	
=======
		$sql="SELECT i.idingreso,i.idpersona,i.fecha,i.total,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.estado
		FROM transaccion i INNER JOIN persona p ON i.idpersona=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario ORDER BY i.idingreso desc";
		return ejecutarConsulta($sql);		
	}
	
	
>>>>>>> master
}

?>