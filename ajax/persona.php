<?php
require_once "../modelos/Persona.php";

$persona=new Persona();

$idpersona=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";
$tipo_person=isset($_POST["tipo_persona"])? limpiarCadena($_POST["tipo_persona"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$apellido=isset($_POST["apellido"])? limpiarCadena($_POST["apellido"]):"";
<<<<<<< HEAD
$tipo_docum=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
=======
>>>>>>> master
$nit=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$telefono1=isset($_POST["telefono1"])? limpiarCadena($_POST["telefono1"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
<<<<<<< HEAD
$cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
=======
>>>>>>> master

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idpersona)){
<<<<<<< HEAD
			$rspta=$persona->insertar($tipo_person,$nombre,$apellido,$tipo_docum,$nit,$direccion,$telefono,$telefono1,$email);
			echo $rspta ? "Persona registrada" : "Persona no se pudo registrar";
		}
		else {
			$rspta=$persona->editar($idpersona,$tipo_person,$nombre,$apellido,$tipo_docum,$nit,$direccion,$telefono,$telefono1,$email);
			echo $rspta ? "Persona actualizada" : "Persona no se pudo actualizar";
		}
	break;

	case 'guardaryeditarColaborador':
		if (empty($idpersona)){
			$rspta=$persona->insertarCo($tipo_person,$nombre,$apellido,$tipo_docum,$nit,$direccion,$telefono,$email,$cargo);
			echo $rspta ? "Persona registrada" : "Persona no se pudo registrar";
		}
		else {
			$rspta=$persona->editarCo($idpersona,$tipo_person,$nombre,$apellido,$tipo_docum,$nit,$direccion,$telefono,$email,$cargo);
=======
			$rspta=$persona->insertar($tipo_person,$nombre,$apellido,$nit,$direccion,$telefono,$telefono1,$email);
			echo $rspta ? "Persona registrada" : "Persona no se pudo registrar";
		}
		else {
			$rspta=$persona->editar($idpersona,$tipo_person,$nombre,$apellido,$nit,$direccion,$telefono,$telefono1,$email);
>>>>>>> master
			echo $rspta ? "Persona actualizada" : "Persona no se pudo actualizar";
		}
	break;

	case 'eliminar':
		$rspta=$persona->eliminar($idpersona);
 		echo $rspta ? "Persona eliminada" : "Persona no se puede eliminar";
	break;

	case 'mostrar':
		$rspta=$persona->mostrar($idpersona);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarp':
		$rspta=$persona->listarp();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->idpersona.')"><i class="fa fa-trash"></i></button>',
<<<<<<< HEAD
					"1"=>$reg->nombre,
					"2"=>$reg->apellido,
	 				"3"=>$reg->nit,
	 				"4"=>$reg->telefono,
	 				"5"=>$reg->telefono1,
	 				"6"=>$reg->email,
					"7"=>$reg->direccion
=======
 				"1"=>$reg->nombre,
 				"2"=>$reg->tipo_documento,
 				"3"=>$reg->num_documento,
 				"4"=>$reg->telefono,
 				"5"=>$reg->email
>>>>>>> master
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'listarc':
		$rspta=$persona->listarc();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->idpersona.')"><i class="fa fa-trash"></i></button>',
 				"1"=>$reg->nombre,
				"2"=>$reg->apellido,
 				"3"=>$reg->nit,
 				"4"=>$reg->telefono,
 				"5"=>$reg->telefono1,
 				"6"=>$reg->email,
				"7"=>$reg->direccion
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

<<<<<<< HEAD
	case 'listarco':
		$rspta=$persona->listarco();
		//Vamos a declarar un array
		$data= Array();

		while ($reg=$rspta->fetch_object()){
			$data[]=array(
				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
					' <button class="btn btn-danger" onclick="eliminar('.$reg->idpersona.')"><i class="fa fa-trash"></i></button>',
				"1"=>$reg->nombre,
				"2"=>$reg->apellido,
				"3"=>$reg->nit,
				"4"=>$reg->direccion,
				"5"=>$reg->telefono,
				"6"=>$reg->email,
				"7"=>$reg->cargo

				);
		}
		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);

	break;

=======
>>>>>>> master

}
?>
