var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	//Cargamos los items al select proveedor
	$.post("../ajax/listadoprecio.php?op=selectProducto", function(r){
	            $("#idproducto").html(r);
	            $('#idproducto').selectpicker('refresh');
	});
}

//Función limpiar
function limpiar()
{
	$("#idproducto").val("");
	$('#idproducto').selectpicker('refresh');
	$("#proveedor").val("");
	$("#precio1").val("");
	$("#precio2").val("");
	$("#precio3").val("");
	$("#precio4").val("");
	$("#precio5").val("");
	$("#precio6").val("");
	$("#precio7").val("");
	$("#precio8").val("");
	$("#precio9").val("");
	$("#precio10").val("");

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

		
		$("#btnCancelar").show();
	
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
					url: '../ajax/listadoprecio.php?op=listar',
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
	tabla=$('#tblarticulos').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		        ],
		"ajax":
				{
					url: '../ajax/ingreso.php?op=listarArticulos',
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
		url: "../ajax/listadoprecio.php?op=guardaryeditar",
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
	$.post("../ajax/listadoprecio.php?op=mostrar",{idingreso : idingreso}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#idproducto").val(data.idproducto);
		$("#idproducto").selectpicker('refresh');
		$("#precio1").val(data.precio);
		$("#precio2").val(data.precio2);
		$("#precio3").val(data.precio3);
		$("#precio4").val(data.precio4);
		$("#precio5").val(data.precio5);
		$("#precio6").val(data.precio6);
		$("#precio7").val(data.precio7);
		$("#precio8").val(data.precio8);
		$("#precio9").val(data.precio9);
		$("#precio10").val(data.precio10);
		$("#idingreso").val(data.idprecio);

		//Ocultar y mostrar los botones
		$("#btnGuardar").show();
		$("#btnCancelar").show();
		//$("#btnAgregarArt").hide();
 	});

 	// $.post("../ajax/ingreso.php?op=listarDetalle&id="+idingreso,function(r){
	//         $("#detalles").html(r);
	// });
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





//   function evaluar(){
//   	if (detalles>0)
//     {
//       $("#btnGuardar").show();
//     }
//     else
//     {
//       $("#btnGuardar").hide(); 
//       cont=0;
//     }
//   }


init();