var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarformclient(false);
	listar();

	$("#formulariocliente").on("submit",function(e)
	{
		guardaryeditarCliente(e);
	})
}

//Función limpiar
function limpiar()
{
	$("#nombre").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#idpersona").val("");
}

//Función mostrar formulario
function mostrarformclient(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistroscliente").hide();
		$("#formularioregistroscliente").show();
		$("#btnGuardarcliente").prop("disabled",false);
		$("#btnagregarcliente").hide();
	}
	else
	{
		$("#listadoregistroscliente").show();
		$("#formularioregistroscliente").hide();
		$("#btnagregarcliente").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarformclient(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistadocliente').dataTable(
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
					url: '../ajax/persona.php?op=listarc',
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

function guardaryeditarCliente(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarcliente").prop("disabled",true);
	var formData = new FormData($("#formulariocliente")[0]);

	$.ajax({
		url: "../ajax/persona.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {
	          bootbox.alert(datos);
	          mostrarformclient(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idpersona)
{
	$.post("../ajax/persona.php?op=mostrar",{idpersona : idpersona}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarformclient(true);

		$("#nombre").val(data.nombre);
		$("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#num_documento").val(data.num_documento);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
 		$("#idpersona").val(data.idpersona);


 	})
}

//Función para eliminar registros
function eliminar(idpersona)
{
	bootbox.confirm("¿Está Seguro de eliminar el cliente?", function(result){
		if(result)
        {
        	$.post("../ajax/persona.php?op=eliminar", {idpersona : idpersona}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});
        }
	})
}

init();
