<?php 
require_once "../modelos/Consultas.php";

$consulta=new Consultas();


switch ($_GET["op"]){
	case 'comprasfecha':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idproveedor=$_REQUEST["idproveedor"];
		$tipo_pago=$_REQUEST["tipo_pago"];

		$rspta=$consulta->comprasfecha($fecha_inicio,$fecha_fin,$idproveedor,$tipo_pago);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->fecha,
 				"1"=>$reg->usuario,
 				"2"=>$reg->cliente,
 				"3"=>$reg->tipo_comprobante,
 				"4"=>$reg->serie.' '.$reg->codigo_factura,
 				"5"=>'<p>Q'.$reg->total.'</p>',
 				"6"=>($reg->estado=='1')?'<span class="label bg-green">Aceptado</span>':
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

	case 'reportecaja':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
	//	$idproveedor=$_REQUEST["idproveedor"];
		$tipo_pago=$_REQUEST["tipo_pago"];

		$rspta=$consulta->reportecaja($fecha_inicio,$fecha_fin,$tipo_pago);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->fecha,
 				"1"=>$reg->usuario,
 				"2"=>$reg->descripcion,
 				"3"=>$reg->num_documento,
 				"4"=>'<p>Q'.$reg->monto.'</p>',
 				"5"=>($reg->tipo_transacion=='1')?'<span class="label bg-green">Ingreso</span>':
 				'<span class="label bg-red">Gasto</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'reporteganancia':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idproducto=$_REQUEST["idproducto"];

		$rspta=$consulta->reporteganancia($fecha_inicio,$fecha_fin,$idproducto);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->fecha,
 				"1"=>$reg->producto,
 				"2"=>$reg->cantidad,
 				"3"=>$reg->preciocompra,
 				"4"=>$reg->precio,
 				"5"=>'<p>Q'.$reg->Ganancia.'</p>',
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'mostrartotalventas':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idcliente=$_REQUEST["idcliente"];
		$tipo_pago=$_REQUEST["tipo_pago"];
		$rspta=$consulta->mostrartotalventas($fecha_inicio,$fecha_fin,$idcliente,$tipo_pago);
 		//Codificar el resultado utilizando json
 		while ($reg = $rspta->fetch_object())
				{
				echo '<h4  >Q.' . $reg->totales . '</h4>';
				}
	break;

	case 'mostrartotalcompra':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idproveedor=$_REQUEST["idproveedor"];
		$tipo_pago=$_REQUEST["tipo_pago"];
		$rspta=$consulta->mostrartotalcompra($fecha_inicio,$fecha_fin,$idproveedor,$tipo_pago);
 		//Codificar el resultado utilizando json
 		while ($reg = $rspta->fetch_object())
				{
				echo '<h4  >Q.' . $reg->totales . '</h4>';
				}
	break;


	case 'mostrartotalcaja':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$tipo_pago=$_REQUEST["tipo_pago"];
		$rspta=$consulta->mostrartotalcaja($fecha_inicio,$fecha_fin,$tipo_pago);
 		//Codificar el resultado utilizando json
 		while ($reg = $rspta->fetch_object())
				{
				echo '<h4  >Q.' . $reg->totales . '</h4>';
				}
	break;

	case 'mostrartotalganancia':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idproducto=$_REQUEST["idproducto"];
		$rspta=$consulta->mostrartotalganancia($fecha_inicio,$fecha_fin,$idproducto);
 		//Codificar el resultado utilizando json
 		while ($reg = $rspta->fetch_object())
				{
				echo '<h4  >Q.' . $reg->totales . '</h4>';
				}
	break;

	

	case 'mostrar':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idcliente=$_REQUEST["idcliente"];
		$rspta=$consulta->mostrar($fecha_inicio,$fecha_fin,$idcliente);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'ventasfechacliente':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idcliente=$_REQUEST["idcliente"];
		$tipo_pago=$_REQUEST["tipo_pago"];

		$rspta=$consulta->reporteventa($fecha_inicio,$fecha_fin,$idcliente,$tipo_pago);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->fecha,
 				"1"=>$reg->usuario,
 				"2"=>$reg->cliente,
 				"3"=>$reg->tipo_comprobante,
 				"4"=>$reg->serie.' '.$reg->codigo_factura,
 				"5"=>'<p>Q'.$reg->total.'</p>',
 				"6"=>($reg->estado=='1')?'<span class="label bg-green">Aceptado</span>':
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


    case 'estadodecuenta':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idcliente=$_REQUEST["idcliente"];

		$rspta=$consulta->estadodecuenta($fecha_inicio,$fecha_fin,$idcliente);
 		//Vamos a declarar un array
 		$data= Array();
       

 		while ($reg=$rspta->fetch_object()){
               $data[]=array(
 				"0"=>$reg->fecha,
 				"1"=>$reg->tipo_transaccion,
 				"2"=>$reg->descripcion,
 				"3"=>$reg->tipo_transaccion,
                "4"=>$reg->monto
 				);
               
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

    case 'estadodecuenta2':
		//Recibimos el idingreso
        $fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$idcliente=$_REQUEST["idcliente"];

		$rspta = $consulta->estadodecuenta($fecha_inicio,$fecha_fin,$idcliente);
		$total=0;
		echo '<thead>
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->fecha.'</td><td>'.$reg->descripcion.'</td><td>'.$reg->descripcion.'</td><td>'.$reg->tipo_transaccion.'</td><td>'.$reg->monto.'</td></tr>';
					$total=$reg->total;
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



	case 'lista_asistencia':
        $fecha_inicio=$_REQUEST["fecha_inicio"];
        $fecha_fin=$_REQUEST["fecha_fin"];
        //$team_id=$_REQUEST["idgrupo"];

        $range = 0;
        if($fecha_inicio<=$fecha_fin){
            $range= ((strtotime($fecha_fin)-strtotime($fecha_inicio))+(24*60*60)) /(24*60*60);
            if($range>31){
                echo "<p class='alert alert-warning'>El Rango Maximo es 31 Dias.</p>";
                exit(0);
            }
        }else{
            echo "<p class='alert alert-danger'>Rango Invalido</p>";
            exit(0);
        }

        // require_once "../modelos/Alumnos.php";
        // $alumnos=new Alumnos();
        // $team_id=$_REQUEST["idgrupo"];
        // $rsptav=$alumnos->verficar_alumno($user_id,$team_id);


        if(!empty($fecha_inicio)){
            // si hay usuarios
            ?>

        <table id="dataw" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Nombre</th>
                <?php for($i=0;$i<$range;$i++){?>
                <th>
                <?php echo date("d-M",strtotime($fecha_inicio)+($i*(24*60*60)));?>
                </th>
                <?php }?>
            </thead>
            <?php
            $rspta=$consulta->listar_calif();
            while ($reg=$rspta->fetch_object()) {
                ?>
                <tr>
                    <td style="width:250px;"><?php echo $reg->nombre." ".$reg->apellido; ?></td>
                    <?php 
                    for($i=0;$i<$range;$i++){
                    $fecha= date("Y-m-d",strtotime($fecha_inicio)+($i*(24*60*60)));
                    $asist=$consulta->listar_asistencia($reg->idpersona,$fecha);
                    $regc=$asist->fetch_object()
                    ?> 
                    <td >
                    <?php
                    if($regc!=null){
                        if($regc->tipo_asistencia==1){ echo "<strong>A</stron>"; }
                        else if($regc->tipo_asistencia==2){ echo "<strong>F</stron>"; }
                        
                    }   
                    ?>

                    </td>
                    <?php } ?>
                </tr>
            <?php }?>
        </table>
        <?php

        }else{
            echo "<p class='alert alert-danger'>No hay Colaboradores</p>";
        }
        ?>

        <script type="text/javascript">         
            tabla=$('#dataw').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                    ]
                } );
        </script>
        <?php
    break;
	
}
?>