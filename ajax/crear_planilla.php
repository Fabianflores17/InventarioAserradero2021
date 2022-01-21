<?php 
if (strlen(session_id()) < 1) 
session_start();
require_once "../modelos/crear_planilla.php";

$articulo=new Articulo();

$idplanilla=isset($_POST["idplanilla"])? limpiarCadena($_POST["idplanilla"]):"";
$idusuario=$_SESSION["idusuario"];
$mes=isset($_POST["mes"])? limpiarCadena($_POST["mes"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$fecha_inicio=isset($_POST["fecha_inicio"])? limpiarCadena($_POST["fecha_inicio"]):"";
$fecha_final=isset($_POST["fecha_final"])? limpiarCadena($_POST["fecha_final"]):"";



switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idplanilla)){
			$rspta=$articulo->insertar($mes,$nombre,$fecha_inicio,$fecha_final);
			echo $rspta ? "Planilla registrado" : "Artículo no se pudo registrar";
		}
		else {
			$rspta=$articulo->editar($idarticulo,$idcategoria,$codigo,$nombre,$presentacion,$unidad,$descripcion,$imagen,$idusuario);
			echo $rspta ? "Artículo actualizado".$tipoproduc : "Artículo no se pudo actualizar";
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
 				"0"=>($reg->mes)?'<button class="btn btn-warning" data-toggle="modal" href="#myModal" onclick="mostrarplanilla('.$reg->idplanilla.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idplanilla.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idplanilla.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idplanilla.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->mes,
				"3"=>$reg->fecha_inicio,
				"4"=>$reg->fecha_final,
 				"5"=>($reg->mes)?'<span class="label bg-green">Activado</span>':
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

	case 'mostrarplanilla':
		//$idarticulo=$_GET['id'];
	//	$rspta=$articulo->mostrarplanilla($idarticulo); 
		$rspta=$articulo->mostrarplanilla();
 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button id="agregar_producto" class="btn btn-warning bloque"  onclick="this.disabled=true; agregarDetalle('.$reg->idplanilla.',\''.$reg->persona.'\');"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->persona,
 				"2"=>$reg->mes,
				"3"=>$reg->fecha_inicio,
				"4"=>$reg->fecha_final
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
}
?>