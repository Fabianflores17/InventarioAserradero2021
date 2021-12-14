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
	public function insertar($idcliente,$idalmacen,$idpago,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$idarticulo,$cantidad,$precio_venta,$descuento)
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
		}

		return $sw;
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

	public function listarDetalle($idventa)
	{
		$sql="SELECT dv.idventa,dv.idarticulo,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal 
		FROM detalle_venta dv 
		INNER JOIN producto a ON dv.idarticulo=a.idproducto WHERE dv.idventa='$idventa'";
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
		WHERE p.condicion='1' and o.idalmacen='$idalmacen' group by o.idproducto";
		return ejecutarConsulta($sql);

	}

}
?>