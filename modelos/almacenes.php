<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Almacen
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$direccion,$telefono,$email,$tipo_almacen)
	{
		$sql="INSERT INTO almacen (nombre,direccion,telefono,email,is_principal,condicion)
		VALUES ('$nombre','$direccion','$telefono','$email','$tipo_almacen','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idalmacen,$nombre,$direccion,$telefono,$email,$tipo_almacen)
	{
		$sql="UPDATE almacen SET nombre='$nombre',direccion='$direccion',telefono='$telefono',email='$email',is_principal='$tipo_almacen'  WHERE idalmacen='$idalmacen'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías  inner join operacion o ON o.idalmacen=a.idalmacen 
		
	public function desactivar($idalmacen)
	{
		$sql="UPDATE almacen --as a
		SET condicion='0' WHERE idalmacen='$idalmacen'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idalmacen)
	{
		$sql="UPDATE almacen SET condicion='1' WHERE idalmacen='$idalmacen'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idalmacen)
	{
		$sql="SELECT * FROM almacen WHERE idalmacen='$idalmacen'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM almacen";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para listar los productos
	public function listarproduct($idalmacen)
	{
		$sql="SELECT Datos.idproducto, o.idalmacen,p.codigo,p.condicion,p.nombre,c.nombre as categoria, Entradas.Entradas - IFNULL(Salidas.Salidas,0) as stock 
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

		// $sql="SELECT a.idproducto,a.codigo,a.nombre,a.descripcion,a.imagen,a.unit,a.presentation,a.condicion,c.nombre as categoria, o.idalmacen, SUM(o.cantidad) as stock
		// FROM producto a 
		// INNER JOIN categoria c ON a.idcategoria=c.idcategoria 
		// INNER JOIN operacion o On a.idproducto=o.idproducto
		// WHERE a.condicion='1' and o.tipo_operacion_id='1' and o.idalmacen='$idalmacen' group by o.idproducto ";
		// return ejecutarConsulta($sql);
	}



	
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM almacen where condicion=1";
		return ejecutarConsulta($sql);
	}
}

?>
