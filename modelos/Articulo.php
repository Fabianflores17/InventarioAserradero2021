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
<<<<<<< HEAD
	public function insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen,$idalmacen)
	{
		$sql="INSERT INTO articulo (idcategoria,codigo,nombre,stock,descripcion,imagen,condicion,idalmacen)
		VALUES ('$idcategoria','$codigo','$nombre','$stock','$descripcion','$imagen','1',$idalmacen)";
=======
	public function insertar($imagen,$codigo,$nombre,$descripcion,$inventario_min,$precio_en,$presentation,$idusuario,$idcategoria,$unit)
	{
		$sql="INSERT INTO producto (imagen,codigo,nombre,descripcion,inventario_min,precio_en,presentation,idusuario,idcategoria,unit,condicion)
        VALUES ('$imagen','$codigo','$nombre','$descripcion','$inventario_min','$precio_en','$presentation','$idusuario','$idcategoria','$unit','1')";
>>>>>>> 597df40616a8e776a98a53bd15e5a5377a1cec66
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($imagen,$codigo,$nombre,$descripcion,$inventario_min,$precio_en,$presentation,$idcategoria,$unit,$idarticulo)
	{
        $sql="UPDATE producto SET imagen='$imagen',codigo='$codigo',nombre='$nombre',descripcion='$descripcion',
            inventario_min='$inventario_min',precio_en='$precio_en',presentation='$presentation',idcategoria='$idcategoria',unit='$unit' WHERE idproducto = '$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idarticulo)
	{
		$sql="UPDATE producto SET condicion='0' WHERE idproducto ='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idarticulo)
	{
		$sql="UPDATE producto SET condicion='1' WHERE idproducto ='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idarticulo)
	{
		$sql="SELECT * FROM producto WHERE idproducto = '$idarticulo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
<<<<<<< HEAD
//	public function listar()
//	{
//		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria 	";
	//	return ejecutarConsulta($sql);
//	}

public function listar()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.descripcion,a.imagen,a.condicion ,a.idalmacen,al.nombre as almacen FROM articulo a INNER JOIN categoria c ON  a.idcategoria=c.idcategoria
		INNER JOIN almacen al ON a.idalmacen = al.idalmacen";
		return ejecutarConsulta($sql);
=======
	public function listar()
    {		
       // $sql="SELECT * from producto";
        $sql="SELECT a.idcategoria,c.nombre as categoria,a.inventario_min,a.precio_en,a.presentation,a.unit,a.codigo,a.nombre,a.descripcion,a.imagen,a.condicion 
            FROM producto a INNER JOIN categoria c ON a.idcategoria=c.idcategoria";
		return ejecutarConsulta($sql);		
>>>>>>> 597df40616a8e776a98a53bd15e5a5377a1cec66
	}

	//Implementar un método para listar los registros activos
	public function listarActivos()
	{
<<<<<<< HEAD
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
		return ejecutarConsulta($sql);
=======
        $sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.inventario_min,a.descripcion,a.imagen,a.condicion,
            a.presentation,a.precio_en,a.unit FROM producto a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
		return ejecutarConsulta($sql);		
>>>>>>> 597df40616a8e776a98a53bd15e5a5377a1cec66
	}

	//Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_ingreso)
	public function listarActivosVenta()
	{
<<<<<<< HEAD
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo order by iddetalle_ingreso desc limit 0,1) as precio_venta,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
		return ejecutarConsulta($sql);
=======
        $sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,(SELECT precio_venta FROM detalle_ingreso WHERE
            idarticulo=a.idarticulo order by iddetalle_ingreso desc limit 0,1) as precio_venta,a.descripcion,a.imagen,a.condicion FROM articulo a 
            INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
		return ejecutarConsulta($sql);		
>>>>>>> 597df40616a8e776a98a53bd15e5a5377a1cec66
	}
}

?>
