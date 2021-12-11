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
	public function insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$tipo_pago,$form_pago,$total_compra,$idarticulo,$cantidad,$precio_compra,$precio_venta)
	{
		$sql="INSERT INTO transaccion (idpersona,idusuario,tipo_comprobante,serie,codigo_factura,fecha,iva,tipo_pago,forma_pago,total,estado)
		VALUES ('$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$tipo_pago','$form_pago','$total_compra','1')";
		//return ejecutarConsulta($sql);
		$idingresonew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle = "INSERT INTO operacion (transaccion_id,idproducto,cantidad,price_compra,idprecio_lis,tipo_operacion_id,idalmacen) VALUES ('$idingresonew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]','$precio_venta[$num_elementos]','1','1')";
			ejecutarConsulta($sql_detalle) or $sw = false;
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


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idingreso)
	{
		$sql="SELECT i.idingreso,i.fecha,i.idpersona,i.tipo_comprobante,i.codigo_factura,i.serie,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.total,i.iva,i.estado 
		FROM transaccion i 
		INNER JOIN persona p ON i.idpersona=p.idpersona 
		INNER JOIN usuario u ON i.idusuario=u.idusuario 
		WHERE i.idingreso='$idingreso'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idingreso)
	{
		$sql="SELECT o.transaccion_id,o.idproducto,p.nombre, o.cantidad,o.price_compra,o.idprecio_lis 
		FROM operacion o inner join producto p on o.idproducto=p.idproducto where o.transaccion_id='$idingreso'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT i.idingreso,i.idpersona,i.fecha,i.total,i.codigo_factura,i.serie,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.estado
		FROM transaccion i INNER JOIN persona p ON i.idpersona=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario ORDER BY i.idingreso desc";
		return ejecutarConsulta($sql);		
	}
	
	public function listadopago(){
		$sql="SELECT *from tipo_pago";
		return ejecutarConsulta($sql);
	}
	
}

?>