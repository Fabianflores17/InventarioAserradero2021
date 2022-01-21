<?php
if (strlen(session_id()) < 1)
  session_start();

require_once "../modelos/Venta.php";

$venta=new Venta();

$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idalmacen=isset($_POST["idalmacen"])? limpiarCadena($_POST["idalmacen"]):"";
$idpago=isset($_POST["tipo_pago"])? limpiarCadena($_POST["tipo_pago"]):"";
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";
$fecha_pro=isset($_POST["fecha_pro"])? limpiarCadena($_POST["fecha_pro"]):"";
$total_pago=isset($_POST["pago"])? limpiarCadena($_POST["pago"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idventa)){
			$rspta=$venta->insertar($idcliente,$idalmacen,$idpago,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$fecha_pro,$_POST["idarticulo"],$_POST["cantidad"],$_POST["idprecio"],$_POST["descuento"]);
			echo $rspta ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
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
		$rspta=$venta->mostrarventa($idventa);
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
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->idprecio_lis.'</td><td>'.$reg->descuento.'</td><td>'.$reg->idprecio_lis*$reg->cantidad.'</td></tr>';
					$total=$total+($reg->idprecio_lis*$reg->cantidad-$reg->descuento);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
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
		$rspta=$venta->listartrans();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			if($reg->tipo_comprobante=='1'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			else{
 				$url='../reportes/exFactura.php?id=';
 			}

 			$data[]=array(
 				"0"=>(($reg->estado=='1')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="anular('.$reg->idingreso.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idingreso.')"><i class="fa fa-eye"></i></button>'),
 					//'<a target="_blank" href="'.$url.$reg->idventa.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
 				"1"=>$reg->fecha,
 				"2"=>$reg->cliente,
 				"3"=>$reg->usuario,
 				"4"=>$reg->tipo_comprobante,
 				"5"=>$reg->serie.'-'.$reg->codigo_factura,
 				"6"=>'<P id="totalventa">Q.'.$reg->total.'</P>',
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

	case 'listarcredito':
		$rspta=$venta->listarcredito();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			// if($reg->tipo_comprobante=='Ticket'){
 			// 	$url='../reportes/exTicket.php?id=';
 			// }
 			// else{
 			// 	$url='../reportes/exFactura.php?id=';
 			// }
			date_default_timezone_set('America/Guatemala');
			$fecha=date('Y-m-d');	
			$date1 = new DateTime("$fecha");
			
			//$fecha2=date('Y-m-d');	
			
			$date2 = new DateTime("$reg->fechainicio");
			$diasx=strval($reg->fechaventa);
			$date2->modify("+ $diasx days");
			$date3=$date2->format('Y-m-d');
			$date4=new DateTime("$date3");
			


			// $date2 = new DateTime("$reg->fechaventa");
			 $diff = $date1->diff($date4);
		
			$dias='5';	
			//$dias2=($diff->invert == 1) ? ' - ' . $diff->days .' days '  : $diff->days .' days ';
			//$dias1='-7';
			//$fechapro=($diff->invert == 1) ? ' - ' . $diff->days<'0'.' <span class="label bg-red">Plazo vencido</span> ': $diff->days<=$dias.' <span class="label bg-green">Plazo por vencer</span> '.' ';
			$data[]=array(
 				"0"=>(($reg->estado=='0')?'<button id="validar2" class="btn btn-warning" onclick="mostrarcredito('.$reg->transaccion_id.')">Abonar<i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="anular('.$reg->transaccion_id.')"><i class="fa fa-close"></i></button>':
 					'<button   id="validar2" class="btn btn-warning" onclick="mostrarcredito('.$reg->transaccion_id.')">Abonar<i class="fa fa-eye"></i></button>'),
 					//'<a target="_blank" href="'.$url.$reg->transaccion_id.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
 				"1"=>$date3,
 				"2"=>$reg->cliente,
 				"3"=>$reg->usuario,
 				"4"=>'<P>Q.'.$reg->totales.'</P>',
 				"5"=>($reg->totales=='0')?'<span id="pagado" class="label bg-green">Pagado</span>':
 				'<span class="label bg-red">Pendiente Pago</span>',
				//"6"=>$date3
				"6"=>($diff->invert == 1)? ' <span id="validar" class="label bg-red">Cliente Morroso</span> ':($diff->days<=$dias ? $diff->days. ' dia(s) ' ." ".'<span  id="validar" class="label bg-yellow">Para que venza el plazo</span>': $diff->days. ' dia(s) ' ." ".' <span id="validar" class="label bg-green"></span> '),
				// "7"=>($dias2<='0' or $dias2>='5' )??'<span class="label bg-green">vencido</span>'?? '<span class="label bg-green">se acerca la fecha</span>'??
				// '<span class="label bg-red">Pendiente Pago</span>'	
				
				//"6"=>($fechapro==true)? '<span class="label bg-green">Plazo por vencer</span>':
				//'<span class="label bg-red"></span>'
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
				echo '<option value=' . $reg->idpersona . ' >' . $reg->nombre . '</option>';
				}
	break;

	

	case 'listadoprecio':
		$idarticulo=$_GET['id'];
		$rspta = $venta->listarprecio($idarticulo);

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->precio . ' >' . $reg->precio . '</option>';
				}
	break;

	case 'listadoprecio2':
		$idarticulo=$_GET['id'];
		$rspta=$venta->listarprecio($idarticulo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
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
 				"0"=>'<button id="agregar_producto" class="btn btn-warning bloque"  onclick="this.disabled=true; agregarDetalle('.$reg->idproducto.',\''.$reg->nombre.'\',\''.$reg->stock.'\',\''.$reg->precio.'\',\''.$reg->precio2.'\',\''.$reg->precio3.'\',\''.$reg->precio4.'\',\''.$reg->precio5.'\',\''.$reg->precio6.'\',\''.$reg->precio7.'\',\''.$reg->precio8.'\',\''.$reg->precio9.'\',\''.$reg->precio10.'\');"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->codigo,
 				"2"=>$reg->nombre,
				"3"=>$reg->stock
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
