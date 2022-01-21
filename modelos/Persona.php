<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Persona
{

	//Implementamos nuestro constructor
	public function __construct()
	{
   //$created_at = "NOW()";
	}

	//Implementamos un método para insertar registros cliente y proveedor
	public function insertar($tipo_person,$nombre,$apellido,$tipo_docum,$nit,$direccion,$telefono,$telefono1,$email)
	{
		$sql="INSERT INTO persona (tipo_person,nombre,apellido,tipo_docum,nit,direccion,telefono,telefono1,email)
		VALUES ('$tipo_person','$nombre','$apellido','$tipo_docum','$nit','$direccion','$telefono','$telefono1','$email')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idpersona,$tipo_person,$nombre,$apellido,$tipo_docum,$nit,$direccion,$telefono,$telefono1,$email)
	{
		$sql="UPDATE persona SET tipo_person='$tipo_person',nombre='$nombre',apellido='$apellido',tipo_docum='$tipo_docum',nit='$nit',direccion='$direccion',telefono='$telefono',telefono1='$telefono1',email='$email' WHERE idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}



	//Implementamos un método para insertar registros del colaborador
	public function insertarCo($tipo_person,$nombre,$apellido,$tipo_docum,$nit,$direccion,$telefono,$email,$cargo)
	{
		$sql="INSERT INTO persona (tipo_person,nombre,apellido,tipo_docum,nit,direccion,telefono,email,cargo)
		VALUES ('$tipo_person','$nombre','$apellido','$tipo_docum','$nit','$direccion','$telefono','$email','$cargo')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros del colaborador
	public function editarCo($idpersona,$tipo_person,$nombre,$apellido,$tipo_docum,$nit,$direccion,$telefono,$email,$cargo)
	{
		$sql="UPDATE persona SET tipo_person='$tipo_person',nombre='$nombre',apellido='$apellido',tipo_docum='$tipo_docum',nit='$nit',direccion='$direccion',telefono='$telefono',email='$email',cargo='$cargo' WHERE idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}
	public function insertarasistencia($tipo_asistencia,$fecha,$idpersona)
	{
		$sql="INSERT INTO asistencia (tipo_asistencia,fecha,idpersona)
		VALUES ('$tipo_asistencia','$fecha','$idpersona')";
		return ejecutarConsulta($sql);
	}


	public function editarasistencia($idasistencia,$tipo_asistencia,$fecha,$idpersona)
	{
		$sql="UPDATE asistencia SET tipo_asistencia='$tipo_asistencia',fecha='$fecha',idpersona='$idpersona' WHERE idasistencia='$idasistencia'";
		return ejecutarConsulta($sql);
	}

	
	//Implementamos un método para eliminar categorías
	public function eliminar($idpersona)
	{
		$sql="DELETE FROM persona WHERE idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idpersona)
	{
		$sql="SELECT * FROM persona WHERE idpersona='$idpersona'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listarp()
	{
		$sql="SELECT * FROM persona WHERE tipo_person='2'";
		return ejecutarConsulta($sql);
	}

	public function listarco()
	{
		$sql="SELECT * FROM persona WHERE tipo_person='3'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listarC()
	{  //1 = cliente,  2 = proveedor,  3 = colaborador
		$sql="SELECT * FROM persona where tipo_person ='1'";
		return ejecutarConsulta($sql);
	}

	public function verificar($fecha,$idpersona){
		$sql="SELECT * FROM asistencia WHERE fecha='$fecha' AND idpersona='$idpersona'";
		return ejecutarConsultaSimpleFila($sql);
	}
}

?>
