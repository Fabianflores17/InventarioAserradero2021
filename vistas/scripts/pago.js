var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	});
	//Cargamos los items al select cliente
	$.post("../ajax/venta.php?op=selectCliente", function(r){
	            $("#idcliente").html(r);
	            $('#idcliente').selectpicker('refresh');
	});
	$.post("../ajax/venta.php?op=selectalmacen", function(r){
		$("#idalmacen").html(r);
		$('#idalmacen').selectpicker('refresh');
	});
//	$.post("../ajax/venta.php?op=selectTipo_pago", function(r){
//		$("#tipo_pago").html(r);
//		$('#tipo_pago').selectpicker('refresh');
//});
    $.post("../ajax/ingreso.php?op=selectTipo_pago", function(r){
		$("#tipo_pago").html(r);
		$('#tipo_pago').selectpicker('refresh');
    });
}

//Función limpiar
function limpiar()
{
	$("#idcliente").val("");
	$('#idcliente').selectpicker('refresh');
	$("#cliente").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	$("#impuesto").val("0");
	$("#idalmacen").val("");
	$("#idalmacen").selectpicker('refresh');
	$("#tipo_pago").val("");
	$("#tipo_pago").selectpicker('refresh')

	$("#total_venta").val("");
	$(".filas").remove();
	$("#total").html("0");

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_hora').val(today);

    //Marcamos el primer tipo_documento
    $("#tipo_comprobante").val("Boleta");
	$("#tipo_comprobante").selectpicker('refresh');
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		listarArticulos();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").show();
		detalles=0;
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}


// function listarcredito()
// {
// 	tabla=$('#tbllistadocredito').dataTable(
// 	{
// 		"aProcessing": true,//Activamos el procesamiento del datatables
// 	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
// 	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
// 	    buttons: [
// 		            'copyHtml5',
// 		            'excelHtml5',
// 		            'csvHtml5',
// 		            'pdf'
// 		        ],
// 		"ajax":
// 				{
// 					url: '../ajax/venta.php?op=listarcredito',
// 					type : "get",
// 					dataType : "json",
// 					error: function(e){
// 						console.log(e.responseText);
// 					}
// 				},
// 		"bDestroy": true,
// 		"iDisplayLength": 5,//Paginación
// 	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
// 	}).DataTable();
// }
//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/venta.php?op=listar',
					type : "get",
					dataType : "json",
					error: function(e){
						console.log(e.responseText);
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}


//Función ListarArticulos
function listarArticulos()
{
	// let almacen = document.getElementById("idalmacen");
	// let selecAlmacen = almacen.value
	tabla=$('#tblarticulos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":
				{
					url: '../ajax/pago.php?op=listarColaborador',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/venta.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {	

	          bootbox.alert(datos);
	          mostrarform(false);
	          listar();
	    }

	});
	limpiar();
}

function mostrar(idventa)
{
	$.post("../ajax/venta.php?op=mostrar",{idventa : idventa}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

		$("#idcliente").val(data.idcliente);
		$("#idcliente").selectpicker('refresh');
		$("#tipo_comprobante").val(data.tipo_comprobante);
		$("#tipo_comprobante").selectpicker('refresh');
		$("#serie_comprobante").val(data.serie_comprobante);
		$("#num_comprobante").val(data.num_comprobante);
		$("#fecha_hora").val(data.fecha);
		$("#impuesto").val(data.impuesto);
		$("#idventa").val(data.idventa);
		$("#idalmacen").val(data.idalmacen);
		$("#idalmacen").selectpicker('refresh');
		$("#tipo_pago").val(data.tipo_pago);
		$("#tipo_pago").selectpicker('refresh');
		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
 	});

 	$.post("../ajax/venta.php?op=listarDetalle&id="+idventa,function(r){
	        $("#detalles").html(r);
	});
}


// function mostrarcredito(idventa)
// {
// 	$.post("../ajax/venta.php?op=mostrarcredito",{idventa : idventa}, function(data, status)
// 	{
// 		data = JSON.parse(data);
// 		mostrarform(true);

// 		$("#idcliente").val(data.idpersona);
// 		$("#idcliente").selectpicker('refresh');
// 		$("#tipo_comprobante").val(data.tipo_comprobante);
// 		$("#tipo_comprobante").selectpicker('refresh');	
// 		$("#idalmacen").val(data.idalmacen);
// 		$("#idalmacen").selectpicker('refresh');
// 		$("#total_credito").val(data.totales);
		
	
	
// 		//Ocultar y mostrar los botones
// 		$("#btnGuardar").show();
// 		$("#btnCancelar").show();
// 		$("#btnAgregarArt").hide();
//  	});

//  	$.post("../ajax/venta.php?op=listarDetalle&id="+idventa,function(r){
// 	        $("#detalles").html(r);
// 	});
// }

//Función para anular registros
function anular(idventa)
{
	bootbox.confirm("¿Está Seguro de anular la venta?", function(result){
		if(result)
        {
        	$.post("../ajax/venta.php?op=anular", {idventa : idventa}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});
        }
	})
}

//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto=18;
var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto()
  {
  	var tipo_comprobante=$("#tipo_comprobante option:selected").text();
  	if (tipo_comprobante=='Factura')
    {
        $("#impuesto").val(impuesto);
    }
    else
    {
        $("#impuesto").val("0");
    }
  }



function agregarDetalle(idarticulo,articulo,stock,precio_venta)
  {
  	var cantidad=1;
    var descuento=0;
    var precio_venta=1;
	globalThis.id_articulo = idarticulo;


    if (idarticulo!="")
    {
    	var subtotal=cantidad*precio_venta;
    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="hidden" id="id_articulo" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
		'<td><input type="hidden" name="stock[]" value="'+stock+'">'+stock+'</td>'+
    	'<td><input type="number" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
    	'<td><input type="number" name="precio_venta[]" id="precio_venta[]" value="'+precio_venta+'"></td>'+
    	'<td><input type="number" name="descuento[]" value="'+descuento+'"></td>'+
    	'<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
    	'<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
    	'</tr>';
    	cont++;
    	detalles=detalles+1;//Loadin
    	$('#detalles').append(fila);
    	modificarSubototales();
		

	}else
    {
    	alert("Error al ingresar el detalle, revisar los datos del artículo");
    }
  }


  function modificarSubototales()
  {
  	var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_venta[]");
    var desc = document.getElementsByName("descuento[]");
    var sub = document.getElementsByName("subtotal");
	var stock = document.getElementsByName("stock[]");

    for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var inpP=prec[i];
    	var inpD=desc[i];
    	var inpS=sub[i];
		var inpSt=stock[i];
		

		var st=parseInt(inpSt.value);
		var ct=parseInt(inpC.value);
		// if(ct<=st){

    	inpS.value=(inpC.value * inpP.value)-inpD.value;
    	document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
		// }
		// else{
		// 	alert("La cantidad ingresada es mayor al stock disponible");
        //     location.reload();
		// }
    }
    calcularTotales();

  }

  
  function calcularTotales(){
  	var sub = document.getElementsByName("subtotal");
	var to = document.getElementById("totalpago").value;
  	var total = 0.0;

	 

  	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}
	console.log(to);
	if(total<to){
		alert("prueba");

	} 
	else{

		alert("prueba22222");
	}

	$("#total").html("Q/. " + total);
    $("#total_venta").val(total);
    evaluar();
  }

  function fechaprorroga(){
	let tipopago = document.getElementById("tipo_pago").value;
	if(tipopago==2&&tipopago!=0){
	
		$("#fecha_pro").show();
	
	}
	else
    {
      $("#fecha_pro").hide();
      cont=0;
    }

  }
  function evaluar(){
  	if (detalles>0)
    {
      $("#btnGuardar").show();
    }
    else
    {
      $("#btnGuardar").hide();
      cont=0;
    }
  }


  function mostrartotal(){
	let tipopago2 = document.getElementById("forma_pago").value;
	if(tipopago2==1){
		
		$.post("../ajax/pago.php?op=selectotal", function(r){
			$("#totalpago").html(r);
			// var to = r.innerHTML;
			// console.log(r);
		});
		
	}
	else if(tipopago2==3){
		alert("pendiente de total");

	}
}

  function fechaprorroga(){
	let tipopago = document.getElementById("forma_pago").value;
	if(tipopago==1||tipopago==3){
	
		$("#totalpago").show();
		$("#tipo").hide();
		mostrartotal();
	
	}
	else
    {
      $("#totalpago").hide();
	  $("#tipo").show();
      cont=0;
    }
}

  function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar()
  }

init();
