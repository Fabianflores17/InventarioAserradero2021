var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listarpagosocios();

	$("#formulariopagosocio").on("submit",function(e)
	{
		guardaryeditar(e);
	});

	// $("#formulariopagosocio").on("submit",function(e)
	// {
	// 	guardaryeditarpagosocio(e);
	// });
	//Cargamos los items al select cliente
	$.post("../ajax/venta.php?op=selectCliente", function(r){
	            $("#idcliente").html(r);
	            $('#idcliente').selectpicker('refresh');
	});
	$.post("../ajax/venta.php?op=selectalmacen", function(r){
		$("#idalmacen").html(r);
		$('#idalmacen').selectpicker('refresh');
	});
	$.post("../ajax/venta.php?op=selectTipo_pago", function(r){
		$("#tipo_pago").html(r);
		$('#tipo_pago').selectpicker('refresh');
});
$.post("../ajax/pago.php?op=selectotalestadoccuenta", function(r){
	$("#totalpago").html(r);

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
	$("#pago").val("");
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
		//listarArticulos();

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


function listarpagosocios()
{
	tabla=$('#tbllistadopagosocios').dataTable(
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
					url: '../ajax/pago.php?op=listarpagosocios',
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
//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}




const pago = document.getElementById("pago");
pago.addEventListener("change", ()=>{
const pago2 = document.getElementById("total_socio").value;
let pago3 = document.getElementById("totalpago2").value;
const pago = document.getElementById("pago").value;
if (parseInt(pago) > parseInt(pago2) ){
    alert("el monto supera la deuda");
	$("#btnGuardar").hide();
}else if (parseInt(pago)>parseInt(pago3)) {
	alert("No hay suficientes fondos en la cuenta")
	$("#btnGuardar").hide();
}else {
	$("#btnGuardar").show();
}

});



function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulariopagosocio")[0]);

	$.ajax({
		url: "../ajax/pago.php?op=guardaryeditarpagosocio",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {
	          bootbox.alert(datos);
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}



function mostrarpagosocio(idventa)

{
	$.post("../ajax/pago.php?op=mostrarpago",{idventa : idventa}, function(data, status)
//	$.post("../ajax/venta.php?op=mostrarcredito",{idventa : idventa}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);
		$("#idventa").val(data.idpagosocios);
		$("#idplanilla").val(data.nombre);
		$("#total_socio").val(data.total_socio)
	
		
		let total=document.getElementById("total_socio");
		let totales=total.value;
		
				
	
		if(totales==0){
			$("#btnGuardar").hide();
			$("#pagoborrador").hide();
			alert("Ya esta pagado el total del credito");
			}else{
				$("#btnGuardar").show();
				$("#pagoborrador").show();
			}
	
		//Ocultar y mostrar los botones
		//$("#btnGuardar").show();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
 	});

 	$.post("../ajax/pago.php?op=listarDetalleplanillasocios&id="+idventa,function(r){
	        $("#detalles").html(r);
	});
}

// const botoon=document.querySelector("#btnGuardar");
// (()=>[
// botoon.addEventListener('click',validarfecha),
// ]());
function validarfecha(){
	//e.preventDefault();
	let total=document.getElementById("total_credito");
	let totales=total.value;
	let to=document.querySelector('#validar');
	if(totales==0){
		to.innerHTML=`<span class="label bg-green">pagado</span>`;
	}

}
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

    if (idarticulo!="")
    {
    	var subtotal=cantidad*precio_venta;
    	var fila='<tr class="filas" id="fila'+cont+'">'+
    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
    	'<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td>'+
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
    }
    else
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
	var stock = document.getElementsByName("stock[]")

    for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var inpP=prec[i];
    	var inpD=desc[i];
    	var inpS=sub[i];
		var inpSt=stock[i];
		if(inpC.value<=inpSt.value){

    	inpS.value=(inpC.value * inpP.value)-inpD.value;
    	document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
		}
		else{
			alert("La cantidad ingresada es mayor al stock disponible");
		}
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

//   function formapagoFinanzas()
//   {
// 	let tipopago2 = document.getElementById("forma_pago").value;

// 	if(tipopago2==1){
// 	$.post("../ajax/pago.php?op=selectotalestadoccuenta", function(r){
// 		$("#totalpago").html(r);

// 	});
// }
//     }



	

  function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar()
  }

init();
