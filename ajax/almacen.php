<?php
require_once "../modelos/almacen.php";

$almacen=new Almacen();

$idalmacen=isset($_POST["idalmacen"])? limpiarCadena($_POST["idalmacen"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$tipo_almacen=isset($_POST["tipo_almacen"])? limpiarCadena($_POST["tipo_almacen"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idalmacen)){
			$rspta=$almacen->insertar($nombre,$direccion,$telefono,$email,$tipo_almacen);
			echo $rspta ? "almacen registrada" : "almacen no se pudo registrar";
		}
		else {
			$rspta=$almacen->editar($idalmacen,$nombre,$direccion,$telefono,$email,$tipo_almacen);
			echo $rspta ? "almacen actualizada" : "almacen no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$almacen->desactivar($idalmacen);
 		echo $rspta ? "almacen Desactivada" : "almacen no se puede desactivar";
	break;

	case 'activar':
		$rspta=$almacen->activar($idalmacen);
 		echo $rspta ? "almacen activada" : "almacen no se puede activar";
	break;

	case 'mostrar':
		$rspta=$almacen->mostrar($idalmacen);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$almacen->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->is_principal)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idalmacen.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idalmacen.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idalmacen.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idalmacen.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->direccion,
				"3"=>$reg->telefono,
				"4"=>$reg->email,
 				"5"=>($reg->is_principal)?'<span class="label bg-green">Principal</span>':
 				'<span class="label bg-red">Secundario</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}
?>
