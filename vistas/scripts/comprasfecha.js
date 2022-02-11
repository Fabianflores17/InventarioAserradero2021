var tabla;

//Función que se ejecuta al inicio
function init(){
	listar();

	// $("#fecha_inicio").change(listar);
	// $("#fecha_fin").change(listar);
	$.post("../ajax/ingreso.php?op=selectProveedor", function(r){
		$("#idproveedor").html(r);
		$('#idproveedor').selectpicker('refresh');
	});
}


//Función Listar reporte compras
function listar()
{

	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
	var idproveedor = $("#idproveedor").val();
	var tipo_pago = $("#tipo_pago").val();

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
					url: '../ajax/consultas.php?op=comprasfecha',
					data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin, idproveedor: idproveedor, tipo_pago:tipo_pago},
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
	mostrartotalventas();

}

function mostrartotalventas(fecha_inicio,fecha_fin,idproveedor,tipo_pago){
	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
	var idproveedor = $("#idproveedor").val();
	var tipo_pago = $("#tipo_pago").val();

	$.post("../ajax/consultas.php?op=mostrartotalcompra",{fecha_inicio,fecha_fin,idproveedor,tipo_pago},function(r){
		$("#totales").html(r);

});

}


// function listar()
// {
// 	var fecha_inicio = $("#fecha_inicio").val();
// 	var fecha_fin = $("#fecha_fin").val();

// 	tabla=$('#tbllistado').dataTable(
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
// 					url: '../ajax/consultas.php?op=comprasfecha',
// 					data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin},
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


init();