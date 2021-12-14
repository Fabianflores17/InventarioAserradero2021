<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/traspaso.php";

$ingreso=new Ingreso();
$idingreso=isset($_POST["idingreso"])? limpiarCadena($_POST["idingreso"]):"";
$idalmacen=isset($_POST["idalmacen"])? limpiarCadena($_POST["idalmacen"]):"";
$idalmacen2=isset($_POST["idalmacen2"])? limpiarCadena($_POST["idalmacen2"]):"";
$total_compra=isset($_POST["total_compra"])? limpiarCadena($_POST["total_compra"]):"";
$idusuario=$_SESSION["idusuario"];



switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idtrasaccion)){
			$rspta=$ingreso->insertar($idalmacen,$idalmacen2,$idusuario,$total_compra,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"]);
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

	case 'mostrartraspaso':
		$rspta=$ingreso->mostraringreso($idingreso);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$idalmacen=$_GET['id'];

		$rspta = $ingreso->listarDetalle($idalmacen);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Compra</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->price_compra.'</td><td>'.$reg->price_compra*$reg->cantidad.'</td></tr>';
					$total=$total+($reg->price_compra*$reg->cantidad);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
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
 					'< class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-eye"></i></button>',
 				"1"=>$reg->origen,
				"2"=>$reg->destino,
				"3"=>$reg->usuario,
 				"4"=>($reg->estado=='1')?'<span class="label bg-green">Aceptado</span>':
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

	case 'listarproductos':
		$idalmacen=$_GET['idalmacen'];
		$rspta=$ingreso->listarproduct($idalmacen); 
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idproducto.',\''.$reg->nombre.'\',\''.$reg->stock.'\',\''.$reg->precio.'\');"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->codigo,
 				"2"=>$reg->nombre,
				"3"=>$reg->stock,
				"4"=>'<P>Q.'.$reg->precio.'</P>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'selectalmacen':
		require_once "../modelos/almacen.php";
		$almacen = new Almacen();

		$rspta = $almacen->listaralmacen();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value='. $reg->idalmacen.'>'. $reg->nombre . '</option>';
				}
	break;

	case 'selectTipo_pago':

		$rspta = $ingreso->listadopago();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idalmacen . ' onclick="mostrar('.$reg->idalmacen.')">' . $reg->nombre . '</option>';
				}
	break;

	


	case 'listarArticulos':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articxulo->listarActivos();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idproducto.',\''.$reg->nombre.'\')"><span class="fa fa-plus"></span></button>',
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