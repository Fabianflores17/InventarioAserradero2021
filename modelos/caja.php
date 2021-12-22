<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Caja
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($cantida,$descripcion)
	{
		$sql="INSERT INTO caja (cantida,descripcion,condicion)
		VALUES ('$cantida','$descripcion','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcaja,$cantida,$descripcion)
	{
		$sql="UPDATE caja SET cantida='$cantida',descripcion='$descripcion' WHERE idcaja='$idcaja'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idcaja)
	{
		$sql="UPDATE caja SET condicion='0' WHERE idcaja='$idcaja'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idcaja)
	{
		$sql="UPDATE caja SET condicion='1' WHERE idcaja='$idcaja'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcaja)
	{
		$sql="SELECT * FROM caja WHERE idcaja='$idcaja'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM caja";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM caja where condicion=1";
		return ejecutarConsulta($sql);
	}
}

?>
