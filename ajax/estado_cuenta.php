<?php
require_once "../modelos/estado_cuenta.php";

$caja=new Caja();

$idcuenta=isset($_POST["idcuenta"])? limpiarCadena($_POST["idcuenta"]):"";
$cantida=isset($_POST["cantida"])? limpiarCadena($_POST["cantida"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$tipo_transaccion=isset($_POST["tipo_transacion"])? limpiarCadena($_POST["tipo_transacion"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
// $documento=isset($_POST["documento"])? limpiarCadena($_POST["documento"]):"";
// $num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idcuenta)){
			$rspta=$caja->insertar($tipo_transaccion,$cantida,$descripcion,$fecha);
			echo $rspta ? "ingreso registrado" : "ingreso no se pudo registrar";
		}
		else {
			$rspta=$caja->editar($idcuenta,$cantida,$descripcion,$tipo_transaccion,$fecha);
			echo $rspta ? "ingreso actualizada" : "ingreso no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$caja->desactivar($idcuenta);
 		echo $rspta ? "caja Desactivada" : "caja no se puede desactivar";
	break;

	case 'activar':
		$rspta=$caja->activar($idcuenta);
 		echo $rspta ? "caja activada" : "caja no se puede activar";
	break;

	case 'mostrar':
		$rspta=$caja->mostrar($idcuenta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$caja->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idcuenta.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idcuenta.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idcuenta.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idcuenta.')"><i class="fa fa-check"></i></button>',
 				"1"=>'<P>Q.'.$reg->monto.'</P>',
 				"2"=>$reg->descripcion,
				"3"=>$reg->fecha,
 				"4"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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

	case 'listargasto':
		$rspta=$caja->listargasto();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idcuenta.')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-danger" onclick="desactivar('.$reg->idcuenta.')"><i class="fa fa-close"></i></button>':
				'<button class="btn btn-warning" onclick="mostrar('.$reg->idcuenta.')"><i class="fa fa-pencil"></i></button>'.
				' <button class="btn btn-primary" onclick="activar('.$reg->idcuenta.')"><i class="fa fa-check"></i></button>',
				"1"=>'<P>Q.'.$reg->monto.'</P>',
				"2"=>$reg->descripcion,
				"3"=>$reg->fecha,
				"4"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
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
