var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	//Cargamos los items al select Almacen
	$.post("../ajax/traspaso.php?op=selectTipo_pago", function(r){
	            $("#idalmacen").html(r);
	            $('#idalmacen').selectpicker('refresh');
	});
	$.post("../ajax/traspaso.php?op=selectalmacen", function(r){
		$("#idalmacen2").html(r);
		$('#idalmacen2').selectpicker('refresh');
});

}

//Función limpiar
function limpiar()
{
	$("#idalmacen").val("");
	$('#idalmacen').selectpicker('refresh');
	$("#idalmacen2").val("");
	$('#idalmacen2').selectpicker('refresh');


	$("#total_compra").val("");
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
	//	 mostrar();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		detalles=0;
		$("#btnAgregarArt").show();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}

}

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
					url: '../ajax/traspaso.php?op=listar',
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
	let almacen = document.getElementById("idalmacen");
	let selecAlmacen = almacen.value
	tabla=$('#tblarticulos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":
				{
					url: '../ajax/traspaso.php?op=listarproductos&idalmacen='+selecAlmacen,
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
		url: "../ajax/traspaso.php?op=guardaryeditar",
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

function mostrar(idingreso)
{
	$.post("../ajax/traspaso.php?op=mostrartraspaso",{idingreso : idingreso}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		

		$("#idalmacen").val(data.origen);
		$("#idalmacen").selectpicker('refresh');
		
		$("#idalmacen2").val(data.destino);
		$("#idalmacen2").selectpicker('refresh');
	
	;
		$("#idingreso").val(data.idingreso);


		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
 	});

 	$.post("../ajax/traspaso.php?op=listarDetalle&id="+idingreso,function(r){
	        $("#detalles").html(r);
	});
}


//Función para anular registros
function anular(idingreso)
{
	bootbox.confirm("¿Está Seguro de anular el ingreso?", function(result){
		if(result)
        {
        	$.post("../ajax/ingreso.php?op=anular", {idingreso : idingreso}, function(e){
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

function agregarDetalle(idarticulo,articulo,total,precio_compra)
  {
  	 var cantidad=1;
    // var precio_compra=0;
	//var stock;
    //var precio_venta=0;

    if (idarticulo!="")
    {
    	var subtotal=cantidad*precio_compra;
    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
		'<td><input type="hidden" name="total[]" id="total[]" value="'+total+'">'+total+'</td>'+
    	'<td><input type="number" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
    	'<td><input type="hidden" name="precio_compra[]"  value="'+precio_compra+'">'+precio_compra+'</td>'+
    	'<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
    	'<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'+
    	'</tr>';
	
    	cont++;
    	detalles=detalles+1;
    	$('#detalles').append(fila);
    	modificarSubototales();
		//validar();
    }
    else
    {
    	alert("Error al ingresar el detalle, revisar los datos del artículo");
    }
  }


  function modificarSubototales()
  {
	  
  	var cant = document.getElementsByName("cantidad[]");
     var prec = document.getElementsByName("precio_compra[]");
     var sub = document.getElementsByName("subtotal");
	 var stock = document.getElementsByName("total[]");

    for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var inpP=prec[i];
    	var inpS=sub[i];
		var inpSt=stock[i];
		var st=parseInt(inpSt.value);
		var ct=parseInt(inpC.value);
		if(ct<=st){
		
    	inpS.value=inpC.value * inpP.value;
    	document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
		}
		else{
			alert("La cantidad ingresada es mayor al stock disponible");
            location.reload();
            

}
//		console.log(inpC.value-inpSt.value);
    }
	
    calcularTotales();

  }
  function calcularTotales(){
  	var sub = document.getElementsByName("subtotal");
  	var total = 0.0;

  	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}
	$("#total").html("Q/. " + total);
    $("#total_compra").val(total);
    evaluar();
  }


//   function validarstock()
//   {

// 	var canti= document.getElementsByName("cantidad[]");
// 	var stock = document.getElementsByName("total[]");
	
	
// 	for (var i = 0; i <canti.length; i++) {
//     	var inpCant=canti[i];
//     	var inpStock=stock[i];

// 		if(inpCant.value<inpStock.value){
		
// 			alert("Error al ingresar menor");
		
    	
//     }else{
		
// 		alert("Error al ingresar mayor");
// 	}
//   }
// }


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

  function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar();
  }

init();
