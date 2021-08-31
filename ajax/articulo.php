<?php
require_once "../modelos/Articulo.php";

$articulo=new Articulo();

$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
<<<<<<< HEAD
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$idalmacen=isset($_POST["idalmacen"])? limpiarCadena($_POST["idalmacen"]):"";
=======
$inventario_min=isset($_POST["inventario_min"])? limpiarCadena($_POST["inventario_min"]):"";
$precio_en=isset($_POST["precio_en"])? limpiarCadena($_POST["precio_en"]):"";
$presentation=isset($_POST["presentation"])? limpiarCadena($_POST["presentation"]):"";
$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$unit=isset($_POST["unit"])? limpiarCadena($_POST["unit"]):"";
>>>>>>> 597df40616a8e776a98a53bd15e5a5377a1cec66

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/" . $imagen);
			}
		}
		if (empty($idarticulo)){
<<<<<<< HEAD
			$rspta=$articulo->insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen,$idalmacen);
			echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";
		}
		else {
			$rspta=$articulo->editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen,$idalmacen);
=======
			$rspta=$articulo->insertar($imagen,$codigo,$nombre,$descripcion,$inventario_min,$precio_en,$presentation,$idusuario,$idcategoria,$unit);
			echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";
		}
		else {
			$rspta=$articulo->editar($idarticulo,$imagen,$codigo,$nombre,$descripcion,$inventario_min,$precio_en,$presentation,$idusuario,$idcategoria,$unit);
>>>>>>> 597df40616a8e776a98a53bd15e5a5377a1cec66
			echo $rspta ? "Artículo actualizado" : "Artículo no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$articulo->desactivar($idarticulo);
 		echo $rspta ? "Artículo Desactivado" : "Artículo no se puede desactivar";
	break;

	case 'activar':
		$rspta=$articulo->activar($idarticulo);
 		echo $rspta ? "Artículo activado" : "Artículo no se puede activar";
	break;

	case 'mostrar':
		$rspta=$articulo->mostrar($idarticulo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$articulo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idproducto.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idproducto.'`)"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->categoria,
 				"3"=>$reg->codigo,
<<<<<<< HEAD
 				"4"=>$reg->stock,
 				"5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >",
				"6"=>$reg->almacen,
 				"7"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
=======
 				"4"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >",
 				"5"=>$reg->inventario_min,
 				"6"=>$reg->precio_en,
 				"7"=>$reg->unit,
 				"8"=>$reg->presentation,
 				"9"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
>>>>>>> 597df40616a8e776a98a53bd15e5a5377a1cec66
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "selectCategoria":
		require_once "../modelos/Categoria.php";
		$categoria = new Categoria();

		$rspta = $categoria->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';
				}
	break;
	
	case "selectAlmacen":
		require_once "../modelos/almacen.php";
		$almacen = new Almacen();

		$rspta = $almacen->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idalmacen . '>' . $reg->nombre . '</option>';
				}
	break;
}
?>
