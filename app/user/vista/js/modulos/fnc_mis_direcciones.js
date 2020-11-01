function verListaDirecciones()
{
	$.ajax({
		type:"POST",
		url:"vista/modulos/mis_direcciones/listaDirecciones.php",
		data:{
			action: "listaDirecciones",
			email: 	localStorage.email
		},
		success:function (response) {
			$(".listaDirecciones").html(response);
		}
	})
}

function registrar_direccion()
{
	$.ajax({
		type:"POST",
		url:"vista/modulos/mis_direcciones/registrar_direccion.php",
		success:function (response) 
		{
			$(".modal").modal("toggle");
			$(".modal-title").html('Registrar nueva dirección');
			$(".modal-body").html(response);
			$(".modal-footer").html('');	
			$("#email").val(localStorage.email);
		}
	});
}

function buscarCiudades()
{
	var id_dpto = $("#id_dpto");
	if (id_dpto.val() != "") 
	{
		$.ajax({
			type:"POST",
			url:"vista/ajax/ajax_mis_direcciones.php",
			data:{
				action:"buscarCiudades",
				id_dpto: id_dpto.val()
			},
			success:function (response) {
				//console.log(response);
				$("#id_ciudad").html(response);
			}
		})
	}
}

function salvar_direccion(action)
{
	var direccion 	= $("#direccion");
	var barrio 		= $("#barrio");
	var indicaciones = $("#indicaciones");
	var telefono 	= $("#telefono");
	var id_dpto 	= $("#id_dpto");
	var id_ciudad 	= $("#id_ciudad");

	var campos = [direccion,barrio,id_dpto,id_ciudad];
	var j = 4;

	$(".alert_registro_direccion").css("display","none");
	$(".alert_registro_direccion").html("");

	for (var i = 0; i < campos.length; i++) 
	{
		if(campos[i].val() == "")
		{
			$(".alert_registro_direccion").css("display","block");
			$(".alert_registro_direccion").html('Diligencie el campo "'+campos[i].attr("data-name")+'" para continuar');
			campos[i].focus();
			break;
		}
		else
		{
			j = j - 1;
		}
	}

	if (j == 0) 
	{
		var form 		= document.getElementById('form_registro_direccion');
		var formData 	= new FormData(form);

		$.ajax({
			type:"POST",
			url:"vista/ajax/ajax_mis_direcciones.php",
			data:formData,
			contentType:false,
			processData:false,
			success:function (response) {
				//console.log(response);
				var jsonResponse = JSON.parse(response);
				if (jsonResponse.estado == "registrado") 
				{
					$(".modal-title").html('Registro exitoso');
					$(".modal-body").html('Se ha registrado la dirección correctamente.');
					$(".modal-footer").html('<button class="btn btn-primary modal-btn-accept">Aceptar</button>');

					$(".modal-btn-accept").click(function () {
						$(".modal").modal("toggle");
						loadPage("mis_direcciones");
					});

				}
				else if (jsonResponse.estado == "actualizado") 
				{
					$(".modal-title").html('Actualizacion exitosa');
					$(".modal-body").html('Se ha actualizado la dirección correctamente.');
					$(".modal-footer").html('<button class="btn btn-primary modal-btn-accept">Aceptar</button>');

					$(".modal-btn-accept").click(function () {
						$(".modal").modal("toggle");
						loadPage("mis_direcciones");
					});
				}
				else
				{
					console.log(response);
				}
			}
		})
	}
}

function editar_direccion(id_direccion)
{
	$.ajax({
		type:"POST",
		url:"vista/modulos/mis_direcciones/editar_direccion.php",
		data:{
			id_direccion: id_direccion
		},
		success:function (response) {
			$(".modal").modal("toggle");
			$(".modal-title").html('Editar dirección');
			$(".modal-body").html(response);
			$(".modal-footer").html('');
			$("#email").val(localStorage.email);
		}
	})
}

function estado_direccion(estado,id_direccion)
{
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_mis_direcciones.php",
		data:{
			action: 		"estadoDireccion",
			estado: 		estado,
			id_direccion: 	id_direccion
		},
		success:function (response) {
			var jsonResponse = JSON.parse(response);
			if (jsonResponse.estado == "success") 
			{
				loadPage("mis_direcciones");
			}
			else
			{
				console.log(jsonResponse);
			}
		}
	})
}