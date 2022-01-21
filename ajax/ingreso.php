<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Ingreso.php";

$ingreso=new Ingreso();

$idingreso=isset($_POST["idingreso"])? limpiarCadena($_POST["idingreso"]):"";
$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
//$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_compra=isset($_POST["total_compra"])? limpiarCadena($_POST["total_compra"]):"";
$tipo_pago=isset($_POST["tipo_pago"])? limpiarCadena($_POST["tipo_pago"]):"";
$form_pago=isset($_POST["form_pago"])? limpiarCadena($_POST["form_pago"]):"";
$dias=isset($_POST["dias"])? limpiarCadena($_POST["dias"]):"";



switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idingreso)){
			$rspta=$ingreso->insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$tipo_pago,$form_pago,$total_compra,$dias,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"]);
			echo $rspta ? "Ingreso registrado" : "No se pudieron registrar todos los datos del ingreso";
		}
		else {
		}
	break;

//	case 'guardaryeditar':
//		if (empty($idingreso)){
//			$rspta=$ingreso->insertar($idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"],$_POST["precio_venta"]);
//			echo $rspta ? "Ingreso registrado" : "No se pudieron registrar todos los datos del ingreso";
//		}
//		else {
//		}
//	break;

	case 'anular':
		$rspta=$ingreso->anular($idingreso);
 		echo $rspta ? "Ingreso anulado" : "Ingreso no se puede anular";
	break;

	case 'mostrar':
		$rspta=$ingreso->mostrar($idingreso);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $ingreso->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->price_compra.'</td><td>'.$reg->idprecio_lis.'</td><td>'.$reg->precio_compra*$reg->cantidad.'</td></tr>';
					$total=$total+($reg->price_compra*$reg->cantidad);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">Q/.'.$total.'</h4><input type="hidden" name="total_compra" id="total_compra"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$rspta=$ingreso->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado=='1')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="anular('.$reg->idingreso.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-eye"></i></button>',
 				"1"=>$reg->proveedor,
				"2"=>$reg->serie,
 				"3"=>$reg->codigo_factura,
				"4"=>'<P>Q.'.$reg->total.'</P>',
				"5"=>$reg->usuario,
				"6"=>$reg->fecha,
 				"7"=>($reg->estado=='1')?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'selectProveedor':
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listarP();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
				}
	break;

	case 'selectTipo_pago':

		$rspta = $ingreso->listadopago();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->id . '>' . $reg->nombrepago . '</option>';
				}
	break;

	


	case 'listarArticulos':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivos();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="this.disabled=true; agregarDetalle('.$reg->idproducto.',\''.$reg->nombre.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->categoria,
 				"3"=>$reg->codigo,
 				"4"=>$reg->descripcion,
 				"5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
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