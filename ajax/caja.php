<?php
require_once "../modelos/caja.php";

$caja=new Caja();

$idcaja=isset($_POST["idcaja"])? limpiarCadena($_POST["idcaja"]):"";
$cantida=isset($_POST["cantida"])? limpiarCadena($_POST["cantida"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idcaja)){
			$rspta=$caja->insertar($cantida,$descripcion);
			echo $rspta ? "caja registrada" : "caja no se pudo registrar";
		}
		else {
			$rspta=$caja->editar($idcaja,$cantida,$descripcion);
			echo $rspta ? "caja actualizada" : "caja no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$caja->desactivar($idcaja);
 		echo $rspta ? "caja Desactivada" : "caja no se puede desactivar";
	break;

	case 'activar':
		$rspta=$caja->activar($idcaja);
 		echo $rspta ? "caja activada" : "caja no se puede activar";
	break;

	case 'mostrar':
		$rspta=$caja->mostrar($idcaja);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$caja->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idcaja.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idcaja.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idcaja.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idcaja.')"><i class="fa fa-check"></i></button>',
 				"1"=>'<P>Q.'.$reg->cantida.'</P>',
 				"2"=>$reg->descripcion,
 				"3"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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
