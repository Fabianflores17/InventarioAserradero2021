<?php
require_once "../modelos/almacenes.php";

$almacen=new Almacen();

$idalmacen=isset($_POST["idalmacen"])? limpiarCadena($_POST["idalmacen"]):"";

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


	case 'mostrar':
		$rspta=$almacen->mostrar($idalmacen);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarproduct':
		$idalmacen=$_GET['id'];
		$rspta=$almacen->listarproduct($idalmacen);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->codigo,
 				"1"=>$reg->nombre,
 				"2"=>$reg->categoria,
				"3"=>$reg->stock,
				"4"=>($reg->condicion)?'<span class="label bg-green">Activo</span>':
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

	case 'listar':
		$rspta=$almacen->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idalmacen.')"><i class="fa fa-eye"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idalmacen.')"><i class="fa fa-eye"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->direccion,
				"3"=>($reg->is_principal)?'<span class="label bg-green">Principal</span>':
 				'<span class="label bg-red">Secundario</span>',
 				"4"=>($reg->condicion)?'<span class="label bg-green">Activo</span>':
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
}
?>
