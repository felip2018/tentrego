function verListaDirecciones()
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/mis_direcciones/listaDirecciones.php",
		data:{
			action: "listaDirecciones",
			email: 	localStorage.email
		},
		success:function (response) {
			jQuery(".listaDirecciones").html(response);
		}
	})
}

function registrar_direccion()
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/mis_direcciones/registrar_direccion.php",
		success:function (response) 
		{
			jQuery(".modal").modal("toggle");
			jQuery(".modal-title").html('Registrar nueva dirección');
			jQuery(".modal-body").html(response);
			jQuery(".modal-footer").html('');	
			jQuery("#email").val(localStorage.email);
		}
	});
}

function buscarCiudades()
{
	var id_dpto = jQuery("#id_dpto");
	if (id_dpto.val() != "") 
	{
		jQuery.ajax({
			type:"POST",
			url:"vista/ajax/ajax_mis_direcciones.php",
			data:{
				action:"buscarCiudades",
				id_dpto: id_dpto.val()
			},
			success:function (response) {
				//console.log(response);
				jQuery("#id_ciudad").html(response);
			}
		})
	}
}

function salvar_direccion(action)
{
	var direccion 	= jQuery("#direccion");
	var barrio 		= jQuery("#barrio");
	var indicaciones = jQuery("#indicaciones");
	var telefono 	= jQuery("#telefono");
	var id_dpto 	= jQuery("#id_dpto");
	var id_ciudad 	= jQuery("#id_ciudad");

	var campos = [direccion,barrio,id_dpto,id_ciudad];
	var j = 4;

	jQuery(".alert_registro_direccion").css("display","none");
	jQuery(".alert_registro_direccion").html("");

	for (var i = 0; i < campos.length; i++) 
	{
		if(campos[i].val() == "")
		{
			jQuery(".alert_registro_direccion").css("display","block");
			jQuery(".alert_registro_direccion").html('Diligencie el campo "'+campos[i].attr("data-name")+'" para continuar');
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

		jQuery.ajax({
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
					jQuery(".modal-title").html('Registro exitoso');
					jQuery(".modal-body").html('Se ha registrado la dirección correctamente.');
					jQuery(".modal-footer").html('<button class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").click(function () {
						jQuery(".modal").modal("toggle");
						loadPage("mis_direcciones");
					});

				}
				else if (jsonResponse.estado == "actualizado") 
				{
					jQuery(".modal-title").html('Actualizacion exitosa');
					jQuery(".modal-body").html('Se ha actualizado la dirección correctamente.');
					jQuery(".modal-footer").html('<button class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").click(function () {
						jQuery(".modal").modal("toggle");
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
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/mis_direcciones/editar_direccion.php",
		data:{
			id_direccion: id_direccion
		},
		success:function (response) {
			jQuery(".modal").modal("toggle");
			jQuery(".modal-title").html('Editar dirección');
			jQuery(".modal-body").html(response);
			jQuery(".modal-footer").html('');
			jQuery("#email").val(localStorage.email);
		}
	})
}

function estado_direccion(estado,id_direccion)
{
	jQuery.ajax({
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