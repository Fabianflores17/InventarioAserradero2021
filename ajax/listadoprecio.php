<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/listadoprecio.php";

$ingreso=new Ingreso();

$idingreso=isset($_POST["idingreso"])? limpiarCadena($_POST["idingreso"]):"";
$idusuario=$_SESSION["idusuario"];
$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$precio1=isset($_POST["precio1"])? limpiarCadena($_POST["precio1"]):"";
$precio2=isset($_POST["precio2"])? limpiarCadena($_POST["precio2"]):"";
$precio3=isset($_POST["precio3"])? limpiarCadena($_POST["precio3"]):"";
$precio4=isset($_POST["precio4"])? limpiarCadena($_POST["precio4"]):"";
$precio5=isset($_POST["precio5"])? limpiarCadena($_POST["precio5"]):"";
$precio6=isset($_POST["precio6"])? limpiarCadena($_POST["precio6"]):"";
$precio7=isset($_POST["precio7"])? limpiarCadena($_POST["precio7"]):"";
$precio8=isset($_POST["precio8"])? limpiarCadena($_POST["precio8"]):"";
$precio9=isset($_POST["precio9"])? limpiarCadena($_POST["precio9"]):"";
$precio10=isset($_POST["precio10"])? limpiarCadena($_POST["precio10"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idingreso)){
			$rspta=$ingreso->insertar($idproducto,$idusuario,$precio1,$precio2,$precio3,$precio4,$precio5,$precio6,$precio7,$precio8,$precio9,$precio10);
			echo $rspta ? "Lista de precio registrada" : "No se pudieron registrar la informacion";
		}
		else {
			$rspta=$ingreso->editar($idingreso,$idproducto,$idusuario,$precio1,$precio2,$precio3,$precio4,$precio5,$precio6,$precio7,$precio8,$precio9,$precio10);
			echo $rspta ? "Artículo actualizado" : "Artículo no se pudo actualizar";
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
 				"0"=>($reg->condicion=='1')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idprecio.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="anular('.$reg->idprecio.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idprecio.')"><i class="fa fa-eye"></i></button>',
 				"1"=>$reg->producto,
				"2"=>$reg->usuario,
 				"3"=>($reg->condicion=='1')?'<span class="label bg-green">Aceptado</span>':
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

	case 'selectProducto':
		
		$rspta = $ingreso->listarProducto();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idproducto . '>' . $reg->nombre . '</option>';
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