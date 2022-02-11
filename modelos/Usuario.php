<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Usuario
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$apellido,$telefono,$email,$cargo,$login,$clave,$imagen,$stock_id,$permisos)
	{
		$sql="INSERT INTO usuario (nombre,apellido,telefono,email,cargo,login,password,imagen,stock_id,condicion)
		VALUES ('$nombre','$apellido','$telefono','$email','$cargo','$login','$clave','$imagen','$stock_id','1')";
		//return ejecutarConsulta($sql);
		$idusuarionew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($permisos))
		{
			$sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuarionew', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	//Implementamos un método para editar registros
	public function editar($idusuario,$nombre,$apellido,$telefono,$email,$cargo,$login,$clavehash,$clave,$imagen,$stock_id,$permisos)
	{

		if($clave==''){
		$sql="UPDATE usuario SET nombre='$nombre',apellido='$apellido',telefono='$telefono',email='$email',cargo='$cargo',login='$login',imagen='$imagen',stock_id='$stock_id' WHERE idusuario='$idusuario'";
		ejecutarConsulta($sql);

		//Eliminamos todos los permisos asignados para volverlos a registrar
		$sqldel="DELETE FROM usuario_permiso WHERE idusuario='$idusuario'";
		ejecutarConsulta($sqldel);
	}else if($clave!=''){

		$sql="UPDATE usuario SET nombre='$nombre',apellido='$apellido',telefono='$telefono',email='$email',cargo='$cargo',login='$login',password='$clavehash',imagen='$imagen',stock_id='$stock_id' WHERE idusuario='$idusuario'";
		ejecutarConsulta($sql);

		//Eliminamos todos los permisos asignados para volverlos a registrar
		$sqldel="DELETE FROM usuario_permiso WHERE idusuario='$idusuario'";
		ejecutarConsulta($sqldel);
	}
		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($permisos))
		{
			$sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuario', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;

	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idusuario)
	{
		$sql="UPDATE usuario SET condicion='0' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idusuario)
	{
		$sql="UPDATE usuario SET condicion='1' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idusuario)
	{
		$sql="SELECT a.idalmacen as almacen,u.nombre,u.apellido,u.telefono,u.email,u.cargo,u.password as clave,u.imagen,u.idusuario,u.login FROM usuario u
		inner join almacen a ON a.idalmacen=u.stock_id WHERE idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM usuario";
		return ejecutarConsulta($sql);
	}
	//Implementar un método para listar los permisos marcados
	public function listarmarcados($idusuario)
	{
		$sql="SELECT * FROM usuario_permiso WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Función para verificar el acceso al sistema
	public function verificar($login,$clave)
    {
    	$sql="SELECT idusuario,nombre,apellido,telefono,stock_id,email,cargo,imagen,login FROM usuario WHERE login='$login' AND password='$clave' AND condicion='1'";
    	return ejecutarConsulta($sql);
    }

	//select almacen
	public function selectalmacen()
	{
		$sql="SELECT * FROM almacen";
		return ejecutarConsulta($sql);
	}

}

?>
