<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Articulo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}


	//Implementamos un método para insertar registros
	public function insertar($mes,$nombre,$fecha_inicio,$fecha_final)
	{
		$sql="INSERT INTO planilla (nombre,mes,fecha_inicio,fecha_final,tipo_empleado)
		VALUES ('$nombre','$mes','$fecha_inicio','$fecha_final','3')";
		//return ejecutarConsulta($sql);	
		$idplanillanew=ejecutarConsulta_retornarID($sql);


		$sql_datos="INSERT INTO datos_planilla(idplanilla,idpersona,sueldos,tipo_empledo) 
		SELECT '$idplanillanew',idpersona,limite_credito,tipo_person FROM persona WHERE tipo_person='3'";
		return ejecutarConsulta($sql_datos);	
		
	}
	
	//Implementamos un método para editar registros
	public function editar($idarticulo,$tipoproduc,$idcategoria,$codigo,$nombre,$presentacion,$unidad,$descripcion,$imagen)
	{
		$sql="UPDATE producto SET tipo_producto='$tipoproduc',idcategoria='$idcategoria',codigo='$codigo',nombre='$nombre',presentation='$presentacion',unit='$unidad',descripcion='$descripcion',imagen='$imagen' WHERE idproducto='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idarticulo)
	{
		
		$sql="UPDATE producto SET condicion='0' WHERE idproducto='$idarticulo'";
		return ejecutarConsulta($sql);		

	 }

	//Implementamos un método para activar registros
	public function activar($idarticulo)
	{
		$sql="UPDATE producto SET condicion='1' WHERE idproducto='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idarticulo)
	{
		$sql="SELECT * FROM producto WHERE idproducto='$idarticulo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function mostrarplanilla($idarticulo)
	{
		$sql="SELECT p.nombre,p.limite_credito,pa.mes,Asistencia.Asistencia as dias,Falta.Falta as faltas,pa.fecha_inicio,pa.fecha_final 
		From ( Select idpersona From asistencia ) as Datos Left join ( Select asis.idpersona, COUNT(tipo_asistencia) as Asistencia from asistencia asis
		INNER JOIN persona p ON asis.idpersona=p.idpersona
		INNER JOIN planilla pa ON p.tipo_person=pa.tipo_empleado
		WHERE asis.tipo_asistencia='1' AND asis.fecha BETWEEN pa.fecha_inicio and pa.fecha_final and pa.idplanilla='$idarticulo' GROUP by idpersona) as Asistencia On Datos.idpersona = Asistencia.idpersona 
		Left join ( Select asis.idpersona, COUNT(tipo_asistencia) as Falta from asistencia  asis
		INNER JOIN persona p ON asis.idpersona=p.idpersona
		INNER JOIN planilla pa ON p.tipo_person=pa.tipo_empleado
        WHERE asis.tipo_asistencia='2' AND asis.fecha BETWEEN pa.fecha_inicio and pa.fecha_final and pa.idplanilla='$idarticulo' GROUP by idpersona) as Falta On Datos.idpersona = Falta.idpersona 
		inner join persona p ON datos.idpersona=p.idpersona 
		inner join planilla pa on pa.tipo_empleado=p.tipo_person 
		where pa.idplanilla='$idarticulo' GROUP BY datos.idpersona";
		return ejecutarConsulta($sql);
	}

	public function Totalplanilla()
	{
		$sql="SELECT SUM(p.limite_credito-(p.limite_credito/30* ifnull(Falta.Falta,0))) as totalplanilla 
		From ( Select DISTINCT idpersona From asistencia ) as Datos Left join ( Select asis.idpersona, COUNT(tipo_asistencia) as Falta from asistencia asis 
		INNER JOIN persona p ON asis.idpersona=p.idpersona 
		INNER JOIN planilla pa ON p.tipo_person=pa.tipo_empleado 
		WHERE asis.tipo_asistencia='2' AND asis.fecha 
		BETWEEN pa.fecha_inicio and pa.fecha_final GROUP by asis.idpersona) as Falta On Datos.idpersona = Falta.idpersona 
		inner join persona p ON datos.idpersona=p.idpersona 
		inner join planilla pa on pa.tipo_empleado=p.tipo_person";
		return ejecutarConsulta($sql);
	}

	

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idplanilla,a.nombre,a.mes,a.fecha_inicio, a.fecha_final	FROM planilla a";
		return ejecutarConsulta($sql);		
	}

	public function listararticulot()
	{
		$sql="SELECT *FROM producto  WHERE condicion='1' and tipo_producto='2'";
		return ejecutarConsulta($sql);		
	}

	
	//Implementar un método para listar los registros activos
	public function listarActivos()
	{
		$sql="SELECT a.idproducto,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.descripcion,a.imagen,a.condicion FROM producto a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1' and a.tipo_producto='1'";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_ingreso)
	// public function listarActivosVenta()
	// {
	// 	$sql="SELECT a.idproducto,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo order by iddetalle_ingreso desc limit 0,1) as precio_venta,a.descripcion,a.imagen,a.condicion FROM producto a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
	// 	return ejecutarConsulta($sql);		
	// }
	public function listarActivosVenta()
	{
		$sql="SELECT a.idproducto,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre, a.descripcion,a.imagen,a.condicion 
		FROM producto a 
		INNER JOIN categoria c ON a.idcategoria=c.idcategoria 
		WHERE a.condicion='1'";
		return ejecutarConsulta($sql);	
	
	}
}

?>