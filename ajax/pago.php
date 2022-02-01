<?php
if (strlen(session_id()) < 1)
  session_start();

require_once "../modelos/pago.php";

$venta=new Colaborador();

$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$formapago=isset($_POST["forma_pago"])? limpiarCadena($_POST["forma_pago"]):"";
$idusuario=$_SESSION["idusuario"];
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";
$fecha_pro=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$idsocio=isset($_POST["idsocio"])? limpiarCadena($_POST["idsocio"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idventa)){
			$rspta=$venta->insertar($formapago,$idusuario,$total_venta,$fecha_pro,$idsocio,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"]);
			echo $rspta ? "Pago Realizado" : "No se pudieron registrar todos los datos del pago";
			
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

	case 'guardaryeditarpagoplanilla':
		if (empty($idventa)){
			$rspta=$venta->insertarpagoplanilla($formapago,$idusuario,$total_venta,$fecha_pro,$idsocio,$_POST["idplanilla"],$_POST["mes"],$_POST["totalplanilla"]);
			echo $rspta ? "Pago de planilla realizado" : "No se pudo realizar el pago de la planilla";	
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

	
	case 'mostrardatos':
		$idplanilla=$_REQUEST["idplanilla"];
		$rspta=$venta->mostrardatos($idplanilla);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'mostrarpago':
		$rspta=$venta->mostrarpagosocio($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	

	case 'caja':
		$rspta=$venta->mostrarcaja();
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
                                    <th>Colaborador</th>
                                    <th>Dias/Mes</th>
                                    <th>Pago</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->colaborador.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->pago.'</td><td>'.$reg->descuento.'</td><td>'.($reg->pago*$reg->cantidad-$reg->descuento).'</td></tr>';
					$total=$total+($reg->pago*$reg->cantidad-$reg->descuento);
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



	case 'listarDetalleplanilla':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $venta->listarDetalleplanilla($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Planilla</th>
                                    <th>Total Pago planilla</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->planilla.'</td><td>'.$reg->pago.'</td><td>'.($reg->pago*$reg->cantidad).'</td></tr>';
					$total=$total+($reg->pago*$reg->cantidad);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">Q.'.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th>
                                </tfoot>';
	break;

	case 'listarDetalleplanillasocios':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $venta->listarDetalleplanillasocios($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Planilla</th>
                                    <th>Total Pago planilla</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->planilla.'</td><td>'.$reg->pago.'</td><td>'.($reg->pago*$reg->cantidad).'</td></tr>';
					$total=$total+($reg->pago*$reg->cantidad);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
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
			 $tipo_comprobante='1';
 			if($tipo_comprobante=='1'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			// else{
 			// 	$url='../reportes/exFactura.php?id=';
 			// }
			

 			$data[]=array(
 				"0"=>(($reg->condicion=='0')?'<button id="btnmostrar" class="btn btn-warning" onclick="mostrar('.$reg->iddetalle.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="anular('.$reg->iddetalle.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->iddetalle.')"><i class="fa fa-eye"></i></button>').
 					'<a target="_blank" href="'.$url.$reg->iddetalle.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
 				"1"=>$reg->fecha,
 				"2"=>$reg->usuario,
 				"3"=>$tipo_comprobante ?'<span class="label bg-black">Voucher</span>':
 				'<span class="label bg-red"></span>',
 				"4"=>'<P>Q.'.($reg->pago*$reg->cantidad-$reg->descuento).'</P>',
				"5"=>($reg->forma_pago == 1)? ' <span id="validar" class="label bg-primary">Caja chica</span> ':($reg->forma_pago == 2  ? '<span  id="validar" class="label bg-yellow">Socios</span>': ' <span id="validar" class="label bg-green">Finanzas</span> '),
 				"6"=>($reg->condicion=='1')?'<span class="label bg-green">Aceptado</span>':
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


	case 'listarpla':
		$rspta=$venta->listar_planilla();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
			 $tipo_comprobante='1';
 			if($tipo_comprobante=='1'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			// else{
 			// 	$url='../reportes/exFactura.php?id=';
 			// }
			

 			$data[]=array(
 				"0"=>(($reg->condicion=='0')?'<button id="btnmostrar" class="btn btn-warning" onclick="mostrarplanilla('.$reg->iddetalle.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="anular('.$reg->iddetalle.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrarplanilla('.$reg->iddetalle.')"><i class="fa fa-eye"></i></button>'),
 					// '<a target="_blank" href="'.$url.$reg->iddetalle.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
 				"1"=>$reg->fecha,
 				"2"=>$reg->usuario,
 				"3"=>$reg->nombre,
 				"4"=>'<P>Q.'.($reg->pago*$reg->cantidad).'</P>',
				"5"=>($reg->forma_pago == 1)? ' <span id="validar" class="label bg-primary">Caja chica</span> ':($reg->forma_pago == 2  ? '<span  id="validar" class="label bg-yellow">Socios</span>': ' <span id="validar" class="label bg-green">Finanzas</span> '),
 				"6"=>($reg->condicion=='1')?'<span class="label bg-green">Aceptado</span>':
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

	// case 'listarcredito':
	// 	$rspta=$venta->listarcredito();
 	// 	//Vamos a declarar un array
 	// 	$data= Array();

 	// 	while ($reg=$rspta->fetch_object()){
 	// 		if($reg->tipo_comprobante=='Ticket'){
 	// 			$url='../reportes/exTicket.php?id=';
 	// 		}
 	// 		else{
 	// 			$url='../reportes/exFactura.php?id=';
 	// 		}
	// 		date_default_timezone_set('America/Guatemala');
	// 		$fecha=date('Y-m-d');	
	// 		$date1 = new DateTime("$fecha");
	// 		$date2 = new DateTime("$reg->fechaventa");
	// 		$diff = $date1->diff($date2);
		
	// 		$dias='3';	
	// 		//$dias2=($diff->invert == 1) ? ' - ' . $diff->days .' days '  : $diff->days .' days ';
	// 		//$dias1='-7';
	// 		//$fechapro=($diff->invert == 1) ? ' - ' . $diff->days<'0'.' <span class="label bg-red">Plazo vencido</span> ': $diff->days<=$dias.' <span class="label bg-green">Plazo por vencer</span> '.' ';
	// 		$data[]=array(
 	// 			"0"=>(($reg->estado=='0')?'<button id="validar2" class="btn btn-warning" onclick="mostrarcredito('.$reg->transaccion_id.')">Abonar<i class="fa fa-eye"></i></button>'.
 	// 				' <button class="btn btn-danger" onclick="anular('.$reg->transaccion_id.')"><i class="fa fa-close"></i></button>':
 	// 				'<button   id="validar2" class="btn btn-warning" onclick="mostrarcredito('.$reg->transaccion_id.')">Abonar<i class="fa fa-eye"></i></button>'),
 	// 				//'<a target="_blank" href="'.$url.$reg->transaccion_id.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
 	// 			"1"=>$reg->fechaventa,
 	// 			"2"=>$reg->cliente,
 	// 			"3"=>$reg->usuario,
 	// 			"4"=>'<P>Q.'.$reg->totales.'</P>',
 	// 			"5"=>($reg->totales=='0')?'<span id="pagado" class="label bg-green">Pagado</span>':
 	// 			'<span class="label bg-red">Pendiente Pago</span>',
	// 			"6"=>($diff->invert == 1)? ' <span id="validar" class="label bg-red">Plazo vencido</span> ':($diff->days<=$dias ? $diff->days. ' dia(s) ' ." ".'<span  id="validar" class="label bg-yellow">Para que venza el plazo</span>': $diff->days. ' dia(s) ' ." ".' <span id="validar" class="label bg-green"></span> '),
	// 			// "7"=>($dias2<='0' or $dias2>='5' )??'<span class="label bg-green">vencido</span>'?? '<span class="label bg-green">se acerca la fecha</span>'??
	// 			// '<span class="label bg-red">Pendiente Pago</span>'	
				
	// 			//"6"=>($fechapro==true)? '<span class="label bg-green">Plazo por vencer</span>':
	// 			//'<span class="label bg-red"></span>'
	// 		);
 	// 	}
 	// 	$results = array(
 	// 		"sEcho"=>1, //Información para el datatables
 	// 		"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 	// 		"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 	// 		"aaData"=>$data);
 	// 	echo json_encode($results);

	// break;


	case 'listarpagosocios':
		$rspta=$venta->listarpagosocios();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
			 $tipo_comprobante='1';
 			if($tipo_comprobante=='1'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			// else{
 			// 	$url='../reportes/exFactura.php?id=';
 			// }
			

 			$data[]=array(
 				"0"=>(($reg->condicion=='0')?'<button id="btnmostrar" class="btn btn-warning" onclick="mostrarpagosocio('.$reg->idpagosocios.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="anular('.$reg->idpagosocios.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrarpagosocio('.$reg->idpagosocios.')"><i class="fa fa-eye"></i></button>').
 					'<a target="_blank" href="'.$url.$reg->idpagosocios.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
 				"1"=>$reg->fecha,
 				"2"=>$reg->usuario,
 				"3"=>$tipo_comprobante ?'<span class="label bg-black">Voucher</span>':
 				'<span class="label bg-red"></span>',
 				"4"=>'<P>Q.'.($reg->totales).'</P>',
				"5"=>($reg->condicion == 1)? ' <span id="validar" class="label bg-primary">Caja chica</span> ':($reg->forma_pago == 2  ? '<span  id="validar" class="label bg-yellow">Socios</span>': ' <span id="validar" class="label bg-green">Finanzas</span> '),
 				"6"=>($reg->condicion=='1')?'<span class="label bg-green">Aceptado</span>':
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


	case 'selectCliente':
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listarC();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
				}
	break;


	case 'selectotal':
		$rspta = $venta->mostrarcaja();

		while ($reg = $rspta->fetch_object())
				{
				echo 
				'<label>Total(*):</label>
				<input  id="totalpago" type="text" class="form-control"  value=' . $reg->total . '>'
				;
				}
	break;

	
	case 'selectotalestadoccuenta':
		$rspta = $venta->mostrarestado_cuenta();

		while ($reg = $rspta->fetch_object())
				{
				echo 
				'<label>Total(*):</label>
				<input  id="totalpago" type="text" class="form-control"  value=' . $reg->total . '>'
				;
				}
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

	case 'listarColaborador':
		//$idalmacen=$_GET['idalmacen'];
		$rspta=$venta->listarColaborador(); 
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button id="agregar_producto" class="btn btn-warning bloque"  onclick="this.disabled=true; agregarDetalle('.$reg->idpersona.',\''.$reg->nombre.'\',\''.$reg->cargo.'\');"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->cargo
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'listarPlanilla':
		//$idalmacen=$_GET['idalmacen'];
		$rspta=$venta->listarPlanilla(); 
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button id="agregar_producto" class="btn btn-warning bloque"  onclick="this.disabled=true; agregarplanilla('.$reg->idplanilla.',\''.$reg->nombre.'\',\''.$reg->mes.'\');"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->mes,
				"3"=>'<P> Q.'.$reg->mes.'</P>'
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
