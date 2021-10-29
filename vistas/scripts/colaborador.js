var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarformcolaborador(false);
	listar();

	$("#formulariocolaborador").on("submit",function(e)
	{
		guardaryeditarColaborador(e);
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
	$("#cargo").val("");
}

//Función mostrar formulario
function mostrarformcolaborador(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistroscolaborador").hide();
		$("#formularioregistroscolaborador").show();
		$("#btnGuardarcolaborador").prop("disabled",false);
		$("#btnagregarcolaborador").hide();
	}
	else
	{
		$("#listadoregistroscolaborador").show();
		$("#formularioregistroscolaborador").hide();
		$("#btnagregarcolaborador").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarformcolaborador(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistadocolaborador').dataTable(
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
					url: '../ajax/persona.php?op=listarco',
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

function guardaryeditarColaborador(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarcolaborador").prop("disabled",true);
	var formData = new FormData($("#formulariocolaborador")[0]);

	$.ajax({
		url: "../ajax/persona.php?op=guardaryeditarColaborador",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,



	    success: function(datos)
	    {
		 //		Swal.fire(
			//		'Registro Exitoso!',
			//		'Presione Ok!',
			//		'success'
			//	)
	         bootbox.alert(datos);
	         mostrarformcolaborador(false);
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
		mostrarformcolaborador(true);

		$("#nombre").val(data.nombre);
		$("#apellido").val(data.apellido);
		$("#tipo_documento").val(data.tipo_docum);
		$("#tipo_documento").selectpicker('refresh');
		$("#num_documento").val(data.nit);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#telefono1").val(data.telefono1);
		$("#email").val(data.email);
 		$("#idpersona").val(data.idpersona);
		$("#cargo").val(data.cargo);


 	})
}

//Función para eliminar registros
function eliminar(idpersona)
{
	bootbox.confirm("¿Está Seguro de eliminar el colaborador?", function(result){
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
