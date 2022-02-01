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
	public function insertar($tipo_transaccion,$cantida,$descripcion,$fecha)
	{
		$sql="INSERT INTO cuenta (tipo_transaccion,monto,descripcion,condicion,fecha)
		VALUES ('$tipo_transaccion','$cantida','$descripcion','1','$fecha')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcuenta,$cantida,$descripcion,$tipo_transaccion,$fecha)
	{
		$sql="UPDATE cuenta SET tipo_transaccion='$tipo_transaccion', monto='$cantida',descripcion='$descripcion',fecha='$fecha' WHERE idcuenta='$idcuenta'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idcuenta)
	{
		$sql="UPDATE cajachica SET kind='0' WHERE id='$idcuenta'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idcuenta)
	{
		$sql="UPDATE cajachica SET kind='1' WHERE id='$idcuenta'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcuenta)
	{
		$sql="SELECT * FROM cuenta WHERE idcuenta='$idcuenta'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM cuenta where tipo_transaccion='1' and condicion='1'";
		return ejecutarConsulta($sql);
	}

	public function listargasto()
	{
		$sql="SELECT * FROM cuenta where tipo_transaccion='2' and condicion='1'";
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
		$sql="SELECT (SELECT Sum(monto) From cuenta where tipo_transaccion='1') - 
		(SELECT Sum(monto) From cuenta where tipo_transaccion='2') total";	
		return ejecutarConsulta($sql);		
	}
}

?>
