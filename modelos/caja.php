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
	public function insertar($cantida,$descripcion,$tipo_transaccion)
	{
		$sql="INSERT INTO cajachica (tipo_transacion,monto,descripcion,kind)
		VALUES ('$tipo_transaccion','$cantida','$descripcion','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcaja,$cantida,$descripcion,$tipo_transaccion)
	{
		$sql="UPDATE cajachica SET tipo_transacion='$tipo_transaccion', monto='$cantida',descripcion='$descripcion' WHERE id='$idcaja'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idcaja)
	{
		$sql="UPDATE cajachica SET kind='0' WHERE id='$idcaja'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idcaja)
	{
		$sql="UPDATE cajachica SET kind='1' WHERE id='$idcaja'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcaja)
	{
		$sql="SELECT * FROM cajachica WHERE id='$idcaja'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM cajachica";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM cajachica where kind=1";
		return ejecutarConsulta($sql);
	}
	public function listarTotal()
	{
		$sql="SELECT (SELECT Sum(monto) From cajachica where tipo_transacion='1') - 
		(SELECT Sum(monto) From cajachica where tipo_transacion='2') total";	
		return ejecutarConsulta($sql);		
	}
}

?>
