var tabla;

//Función que se ejecuta al inicio
function init(){

	listarcaja();
	// listarganancia();
	// $("#fecha_inicio").change(listar);
	// $("#fecha_fin").change(listar);
	$.post("../ajax/articulo.php?op=selectproducto", function(r){
		$("#idproducto").html(r);
		$('#idproducto').selectpicker('refresh');
	});
}


//Función Listar reporte compras


//funcion listar reporte caja chica
function listarcaja()
{

	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
	var tipo_pago = $("#tipo_pago").val();

	tabla=$('#tbllistadocaja').dataTable(
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
					url: '../ajax/consultas.php?op=reportecaja',
					data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin, tipo_pago:tipo_pago},
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
	mostrartotalcaja();

}

function mostrartotalcaja(fecha_inicio,fecha_fin,tipo_pago){
	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
	var tipo_pago = $("#tipo_pago").val();

	$.post("../ajax/consultas.php?op=mostrartotalcaja",{fecha_inicio,fecha_fin,tipo_pago},function(r){
		$("#totales").html(r);

});

}


//funcion listar reporte caja chica
// function listarganancia()
// {

// 	var fecha_inicio = $("#fecha_inicio").val();
// 	var fecha_fin = $("#fecha_fin").val();
// 	var idproducto = $("#idproducto").val();

// 	tabla=$('#tbllistadoganacia').dataTable(
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
// 					url: '../ajax/consultas.php?op=reporteganancia',
// 					data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin, idproducto:idproducto},
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
// 	mostrartotalganacia();

// }

// function mostrartotalganacia(fecha_inicio,fecha_fin,tipo_pago){
// 	var fecha_inicio = $("#fecha_inicio").val();
// 	var fecha_fin = $("#fecha_fin").val();
// 	var idproducto = $("#idproducto").val();

// 	$.post("../ajax/consultas.php?op=mostrartotalganancia",{fecha_inicio,fecha_fin,idproducto},function(r){
// 		$("#totales").html(r);

// });

// }

init();