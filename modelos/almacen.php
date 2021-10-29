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
		$sql="INSERT INTO almacen (nombre,direccion,telefono,email,is_principal)
		VALUES ('$nombre','$direccion','$telefono','$email','$tipo_almacen')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idalmacen,$nombre,$direccion,$telefono,$email,$tipo_almacen)
	{
		$sql="UPDATE almacen SET nombre='$nombre',direccion='$direccion',telefono='$telefono',email='$email',is_principal='$tipo_almacen'  WHERE idalmacen='$idalmacen'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idalmacen)
	{
		$sql="UPDATE almacen SET condiciion='0' WHERE idalmacen='$idalmacen'";
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
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM almacen where condicion=1";
		return ejecutarConsulta($sql);
	}
}

?>
