<?php
if (strlen(session_id()) < 1)
  session_start();

require_once "../modelos/terminado.php";

$venta=new Venta();

$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$idalmacen=isset($_POST["idalmacen"])? limpiarCadena($_POST["idalmacen"]):"";
$cantidadgenerada=isset($_POST["q"])? limpiarCadena($_POST["q"]):"";
$gastoope=isset($_POST["gop"])? limpiarCadena($_POST["gop"]):"";
$gastoadmin=isset($_POST["gad"])? limpiarCadena($_POST["gad"]):"";
$gastolog=isset($_POST["glo"])? limpiarCadena($_POST["glo"]):"";
$totalunit=isset($_POST["totalunitario"])? limpiarCadena($_POST["totalunitario"]):"";
$idusuario=$_SESSION["idusuario"];
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idventa)){
			$rspta=$venta->insertar($idproducto,$idusuario,$idalmacen,$totalunit,$cantidadgenerada,$total_venta,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"]);
			echo $rspta ? "Venta registrada": "No se pudieron registrar todos los datos de la venta";
			// echo $rspta ? "<script type='text/JavaScript'> location.reload(); </script>";
			
		}
		else {
		}
	break;

	case 'guardaryeditarcredito':
		if ($idventa>0){
			$rspta=$venta->insertarcredito($idcliente,$idventa,$total_pago);
			echo $rspta ? "Error" : "Monto procesado";	
		}	
	break;

	case 'anular':
		$rspta=$venta->anular($idventa);
 		echo $rspta ? "Venta anulada" : "Venta no se puede anular";
	break;

	case 'mostrar':
		$rspta=$venta->mostrar($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'mostrarcredito':
		$rspta=$venta->mostrarcredito($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $venta->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Costo</th>
                                    <th>Descripcion</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->price_compra.'</td><td>'.$reg->descuento.'</td><td>'.$reg->cantidad*$reg->price_compra.'</td></tr>';
					$total=$total+($reg->price_compra*$reg->cantidad);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">Q.'.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th>
                                </tfoot>';
	break;



//Muestra la tabla ventacredito del producto comprado
	case 'listarDetallecredito':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $venta->listarDetallecredito($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->idprecio_lis.'</td><td>'.$reg->idprecio_lis*$reg->cantidad.'</td></tr>';
					$total=$total+($reg->idprecio_lis*$reg->cantidad);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">Q.'.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th>
                                </tfoot>';
	break;

	case 'listar':
		$rspta=$venta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 	
		 while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>(($reg->estado=='1')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="anular('.$reg->idingreso.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-eye"></i></button>'),
 					//'<a target="_blank" href="'.$url.$reg->idventa.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
 				"1"=>$reg->producto,
 				"2"=>$reg->usuario,
 				"3"=>$reg->cantidad,
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

	case 'listarcredito':
		$rspta=$venta->listarcredito();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			if($reg->tipo_comprobante=='Ticket'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			else{
 				$url='../reportes/exFactura.php?id=';
 			}

 			$data[]=array(
 				"0"=>(($reg->estado=='0')?'<button class="btn btn-warning" onclick="mostrarcredito('.$reg->transaccion_id.')">Abonar<i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="anular('.$reg->transaccion_id.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrarcredito('.$reg->transaccion_id.')">Abonar<i class="fa fa-eye"></i></button>'),
 					//'<a target="_blank" href="'.$url.$reg->idventa.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
 				"1"=>$reg->fechaventa,
 				"2"=>$reg->cliente,
 				"3"=>$reg->usuario,
 				"4"=>'<P>Q.'.$reg->totales.'</P>',
 				"5"=>($reg->totales=='0')?'<span class="label bg-green">Pagado</span>':
 				'<span class="label bg-red">Pendiente Pago</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


	case 'selectCliente':
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listarC();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
				}
	break;


	case 'selectproducto':
		require_once "../modelos/Articulo.php";
		$articulo = new Articulo();

		$rspta = $articulo->listararticulot();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value='. $reg->idproducto.'>'. $reg->nombre . '</option>';
				}
	break;

	case 'selectTipo_pago':
		require_once "../modelos/ingreso.php";
		$ingreso=new Ingreso();
		$rspta = $ingreso->listadopago();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->id . '>' . $reg->nombrepago . '</option>';
				}
	break;

	case 'listarproductos':
		$idalmacen=$_GET['idalmacen'];
		$rspta=$venta->listarproduct($idalmacen); 
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
	}
?>
