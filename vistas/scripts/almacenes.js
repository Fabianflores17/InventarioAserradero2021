var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();


}

//Función limpiar
function limpiar()
{
	$("#idalmacen").val("");
	$("#nombre").val("");
	$("#descripcion").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#listadoarticulos").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#listadoarticulos").hide();
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
					url: '../ajax/almacenes.php?op=listar',
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

//Funcio listar productos de bodegas
//function listarproduct(idalmacen)
//{
//	tabla=$('#tbbodega').dataTable(
//	{
//		"aProcessing": true,//Activamos el procesamiento del datatables
//	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
//	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
//	    buttons: [
//		            'copyHtml5',
//		            'excelHtml5',
//		            'csvHtml5',
//		            'pdf'
//		        ],
//		"ajax":
//				{
//					url: '../ajax/almacenes.php?op=listarproduct&id='+idalmacen,
//					type : "get",
//					dataType : "json",
//					error: function(e){
//						console.log(e.responseText);
//					}
//				},
//		"bDestroy": true,
//		"iDisplayLength": 5,//Paginación
//	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
//	}).DataTable();
//}



function mostrar(idalmacen)

{
	$.post("../ajax/almacenes.php?op=mostrar",{idalmacen : idalmacen}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

		$("#nombre").val(data.nombre);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
		$("#tipo_almacen").val(data.is_principal);
 		$("#idalmacen").val(data.idalmacen);

 	})
	 $.post("../ajax/almacenes.php?op=listarproduct&id="+idalmacen,function(r){
		$("#tbbodega").dataTable(
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
							url: '../ajax/almacenes.php?op=listarproduct&id='+idalmacen,
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
});
}



init();
