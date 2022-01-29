var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	listarGasto();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})
}


//Función limpiar
function limpiar()
{
	$("#idcaja").val("");
	$("#cantida").val("");
	$("#descripcion").val("");
	$("#tipo_transaccion").val("");
	$("#tipo_transaccion").selectpicker('refresh');
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha').val(today);
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
					url: '../ajax/estado_cuenta.php?op=listar',
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

//funcio listar gasto
function listarGasto()
{
	tabla=$('#tbllistadogasto').dataTable(
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
					url: '../ajax/estado_cuenta.php?op=listargasto',
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
		url: "../ajax/estado_cuenta.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {
	          bootbox.alert(datos);
			//   setInterval('location.reload()',3000);
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

// function validarcuenta(){
// 	let validar = document.getElementById("validarcampo");
// 	let validar2 = parseInt(validar.innerHTML);
// 	let tipo = document.getElementById("tipo_transaccion").value;
// 	let cantidad = document.getElementById("cantida").value;

// 	if(tipo=="2"){
// 		if(validar2<cantidad){
// 			alert("No existen suficientes fondos",location.reload());
// 		}
// 	}

// }

function mostrar(idcuenta)
{
	$.post("../ajax/estado_cuenta.php?op=mostrar",{idcuenta : idcuenta}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);
		$("#tipo_transacion").val(data.tipo_transaccion);
		$("#cantida").val(data.monto);
		$("#descripcion").val(data.descripcion);
 		$("#idcuenta").val(data.idcuenta);

 	})
}

//Función para desactivar registros
function desactivar(idcaja)
{
	bootbox.confirm("¿Está Seguro de desactivar la caja?", function(result){
		if(result)
        {
        	$.post("../ajax/estado_cuenta.php?op=desactivar", {idcaja : idcaja}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});
        }
	})
}

//Función para activar registros
function activar(idcaja)
{
	bootbox.confirm("¿Está Seguro de activar la caja?", function(result){
		if(result)
        {
        	$.post("../ajax/estado_cuenta.php?op=activar", {idcaja : idcaja}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});
        }
	})
}


init();
