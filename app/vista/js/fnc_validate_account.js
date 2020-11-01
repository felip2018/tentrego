//	FUNCION DE VALIDACION DE CUENTA
function validar_cuenta(email,codigo_validacion)
{
	console.log("Se valida la cuenta");
	$.ajax({
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
					$(".modal").modal("toggle");
					$(".modal-title").html("Verificación de cuenta");
					$(".modal-body").html("Tu cuenta ha sido verificada y activada correctamente.");
					$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					$(".modal-btn-accept").on('click',function () {
						location.href = "index.php";
					});
					break;

				case "error":
					$(".modal").modal("toggle");
					$(".modal-title").html("Error en verificación de cuenta");
					$(".modal-body").html("Algo ha ocurrido con la verificación de tu cuenta: <br>"+jsonResponse.data);
					$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					$(".modal-btn-accept").on('click',function () {
						location.href = "index.php";
					});
					break;

				case "Activo":
					$(".modal").modal("toggle");
					$(".modal-title").html("Cuenta activa");
					$(".modal-body").html('Su cuenta ya se encuentra activa.');
					$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					$(".modal-btn-accept").on('click',function () {
						location.href = "index.php";
					});
					break;

				case "Inactivo":
					$(".modal").modal("toggle");
					$(".modal-title").html("Cuenta inactiva");
					$(".modal-body").html('Su cuenta se encuentra inactiva, por favor comuniquese con los administradores del sitio para más información.');
					$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					$(".modal-btn-accept").on('click',function () {
						location.href = "index.php";
					});
					break;

				case "Bloqueado":
					$(".modal").modal("toggle");
					$(".modal-title").html("Cuenta bloqueada");
					$(".modal-body").html('Su cuenta se encuentra bloqueada ya que se ha presentado un ataque de seguridad en su cuenta, a su correo electrónico se han enviado los pasos para reactivar su cuenta.');
					$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					$(".modal-btn-accept").on('click',function () {
						location.href = "index.php";
					});
					break;
			}
		}
	})
}