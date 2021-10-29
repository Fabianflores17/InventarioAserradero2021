var tabla;

//Función que se ejecuta al inicio
function inicio(){
	mostrarclientes(0);
	listar();

	$("#formularioclientes").on("submit",function(e)
	{
		guardaryeditar(e);
	})
}

//Función limpiar
function limpiar()
{
	$("#nombre").val("");
	$("#apellido").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#telefono1").val("");
	$("#email").val("");
	$("#idpersona").val("");
}

//Función mostrar formulario
function mostrarclientes(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistrosclientes").show();
		$("#btnGuardarcliente").prop("disabled",false);
		$("#btnagregarcliente	").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistrosclientes").hide();
		$("#btnagregarcliente").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarclientes(0);
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

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarcliente").prop("disabled",true);
	var formData = new FormData($("#formularioregistrosclientes")[0]);

	$.ajax({
		url: "../ajax/persona.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {
	          bootbox.alert(datos);
	          mostrarclientes(0);
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
		mostrarclientes(1);

		$("#nombre").val(data.nombre);
		$("#apellido").val(data.apellido);
		$("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#num_documento").val(data.num_documento);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#telefono1").val(data.telefono1);
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

inicio();
