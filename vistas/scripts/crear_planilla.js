var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	//Cargamos los items al select categoria
	$.post("../ajax/articulo.php?op=selectCategoria", function(r){
	            $("#idcategoria").html(r);
	            $('#idcategoria').selectpicker('refresh');

	});
	$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
	$("#codigo").val("");
	$("#nombre").val("");
	$("#descripcion").val("");
	$("#stock").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#print").hide();
	$("#idarticulo").val("");

	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_inicio').val(today);
	$('#fecha_final').val(today);
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	
		
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
					url: '../ajax/crear_planilla.php?op=listar',
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
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/crear_planilla.php?op=guardaryeditar",
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

function mostrarplanilla(idarticulo)
{

	tabla=$('#tblarticulos').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
			buttons: [		          
						// 'copyHtml5',
						// 'excelHtml5',
						// 'csvHtml5',
						// 'pdf'
					],
			"ajax":
					{
						url: '../ajax/crear_planilla.php?op=mostrarplanilla&id='+idarticulo,
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
	//	mostratotal(idarticulo);
	// $.post("../ajax/articulo.php?op=mostrar",{idarticulo : idarticulo}, function(data, status)
	// {
	// 	data = JSON.parse(data);		
	// 	mostrarform(true);

	

	//    $("#idcategoria").val(data.idcategoria);
    //    $('#idcategoria').selectpicker('refresh');
	// 	$("#codigo").val(data.codigo);
	// 	$("#nombre").val(data.nombre);
	// 	$("#descripcion").val(data.descripcion);
	// 	$("#unidad").val(data.unit);
	// 	$("#presentacion").val(data.presentation);
	// 	$("#imagenmuestra").show();
	// 	$("#imagenmuestra").attr("src","../files/articulos/"+data.imagen);
	// 	$("#imagenactual").val(data.imagen);
	// 	$("#tipo_produc").val(data.tipo_producto);
	// 	$('#tipo_produc').selectpicker('refresh');
 	// 	$("#idarticulo").val(data.idproducto);
		
 	

 	// })
}

// function mostratotal(idarticulo)
// {
// 	console.log(idarticulo);
// 	// "ajax",
// 	// {
// 	// 	url: '../ajax/crear_planilla.php?op=mostrartotal&idarticulo='+idarticulo,
// 	// 	type : "get",
// 	// 	dataType : "json",						
// 	// 	error: function(e){
// 	// 	console.log(e.responseText);	
// 	// 	}
// 	// }

// 	$.post("../ajax/articulo.php?opmostrartotal&idarticulo="+idarticulo,function(e){
// 	});
// }
//Función para desactivar registros
function desactivar(idarticulo)
{
	bootbox.confirm("¿Está Seguro de desactivar el artículo?", function(result){
		if(result)
        {
        	$.post("../ajax/articulo.php?op=desactivar", {idarticulo : idarticulo}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idarticulo)
{
	bootbox.confirm("¿Está Seguro de activar el Artículo?", function(result){
		if(result)
        {
        	$.post("../ajax/articulo.php?op=activar", {idarticulo : idarticulo}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//función para generar el código de barras
function generarbarcode()
{
	codigo=$("#codigo").val();
	JsBarcode("#barcode", codigo);
	$("#print").show();
}

//Función para imprimir el Código de barras
function imprimir()
{
	$("#print").printArea();
}

init();