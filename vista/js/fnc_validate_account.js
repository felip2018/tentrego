//	FUNCION DE VALIDACION DE CUENTA
function validar_cuenta(email,codigo_validacion)
{
	console.log("Se valida la cuenta");
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/ajax_validate_account.php",
		data:{
			action: 	"validate_account",
			email: 		email,
			codigo: 	codigo_validacion
		},
		success:function (response) {
			console.log(response);
			var jsonResponse = JSON.parse(response);
			switch(jsonResponse.estado)
			{
				case "cuenta_validada":
					jQuery(".modal").modal("toggle");
					jQuery(".modal-title").html("Verificación de cuenta");
					jQuery(".modal-body").html("Tu cuenta ha sido verificada y activada correctamente.");
					jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").on('click',function () {
						location.href = "index.php";
					});
					break;

				case "error":
					jQuery(".modal").modal("toggle");
					jQuery(".modal-title").html("Error en verificación de cuenta");
					jQuery(".modal-body").html("Algo ha ocurrido con la verificación de tu cuenta: <br>"+jsonResponse.data);
					jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").on('click',function () {
						location.href = "index.php";
					});
					break;

				case "Activo":
					jQuery(".modal").modal("toggle");
					jQuery(".modal-title").html("Cuenta activa");
					jQuery(".modal-body").html('Su cuenta ya se encuentra activa.');
					jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").on('click',function () {
						location.href = "index.php";
					});
					break;

				case "Inactivo":
					jQuery(".modal").modal("toggle");
					jQuery(".modal-title").html("Cuenta inactiva");
					jQuery(".modal-body").html('Su cuenta se encuentra inactiva, por favor comuniquese con los administradores del sitio para más información.');
					jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").on('click',function () {
						location.href = "index.php";
					});
					break;

				case "Bloqueado":
					jQuery(".modal").modal("toggle");
					jQuery(".modal-title").html("Cuenta bloqueada");
					jQuery(".modal-body").html('Su cuenta se encuentra bloqueada ya que se ha presentado un ataque de seguridad en su cuenta, a su correo electrónico se han enviado los pasos para reactivar su cuenta.');
					jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").on('click',function () {
						location.href = "index.php";
					});
					break;
			}
		}
	})
}