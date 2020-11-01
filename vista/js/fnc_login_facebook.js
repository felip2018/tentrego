var app_id = '320544408486189';
var scopes = 'email, public_profile';


  //FUNCIONALIDAD PARA EL BOTON DE LOGIN
  jQuery(document).on('click','.btn_facebook',function (e) {
    e.preventDefault();
    facebookLogin();
  });

  // This is called with the results from from FB.getLoginStatus().
	function statusChangeCallback(response) 
  {
	    if (response.status === 'connected') 
      {
	      	getFacebookData(response);
	      	var connected = true;
	    } 
      else 
      {
	        var connected = false;
	    }

	    return connected;
	}


	function checkLoginState() 
  {
  	FB.getLoginStatus(function(response) {
    		statusChangeCallback(response);
  	});
	}

	function facebookLogin()
  {
		FB.getLoginStatus(function(response){
    		
        var res = statusChangeCallback(response);
    		
        if (! res) 
        {
    			FB.login(function (response) {
    				if (response.status === 'connected') 
            {
              checkLoginState();
    				}
    			},{scope: scopes});
    		}

  	});
	}

	function facebookLogout()
  {  		
		FB.getLoginStatus(function(response){
        if (response.status === 'connected') 
        {
    			FB.logout(function (response) {
    				console.log(response);
    			});
    		}
  	});
	}

	//OBTENR LOS DATOS DEL USUARIO DESDE LA API DE FACEBOOK
	function getFacebookData(data) 
	{
  	FB.api('/me', 'POST',{fields:'email,first_name,last_name,id'}, function(response) {
        		
        jQuery.ajax({
          type:"POST",
          url: "vista/ajax/ajax_login_facebook.php",
          data:{
            action:           "validarUsuario",
            user_first_name:  response.first_name,
            user_last_name:   response.last_name,
            user_email:       response.email
          },
          success:function (respuesta) {
            var jsonResponse = JSON.parse(respuesta);
            
            if(jsonResponse.status == "registrado")
            {
              /*INICIAR SESION*/
              logInFacebook(jsonResponse.email);
            }
            else if (jsonResponse.status == "sin_registro") 
            {
              /*DESPLEGAR FORMULARIO DE REGISTRO*/
              signUpFacebook(response);
            }
            else if (jsonResponse.status == "estado_cuenta") 
            {
              switch(jsonResponse.estado_cuenta)
              {
                case "Inactivo":
                  jQuery(".modal").modal("toggle");
                  jQuery(".modal-title").html("Cuenta Inactiva");
                  jQuery(".modal-body").html("Su cuenta se encuentra inactiva, proceda a activarla siguiendo el enlace de validación que enviamos a su correo electrónico");
                  jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

                  jQuery("modal-btn-accept").on("click",function () {
                    jQuery(".modal").modal("toggle");
                  });

                  break;

                case "Bloqueado":
                  jQuery(".modal").modal("toggle");
                  jQuery(".modal-title").html("Cuenta Bloqueada");
                  jQuery(".modal-body").html("Se ha presentado un intento de violar la privacidad de su cuenta, por favor dirijase a su correo electrónico para reestablecer la integridad de su cuenta.");
                  jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

                  jQuery("modal-btn-accept").on("click",function () {
                    jQuery(".modal").modal("toggle");
                  });
                  break;
              }
            }

          }
        });

  	});
	}

  	

function logInFacebook(email) 
{
  jQuery.ajax({
    type:"POST",
    url:"vista/ajax/ajax_login_facebook.php",
    data:{
      action: "loginFacebook",
      email:  email
    },
    success:function(respuesta)
    {
      console.log(respuesta);
      var jsonResponse = JSON.parse(respuesta);
      if (jsonResponse['estado'] == "success") 
      {

        if (jsonResponse.data['intentos'] == 3 && jsonResponse.data['estado'] == "Bloqueado") 
        {
          jQuery(".modal").modal("toggle");
          jQuery(".modal-title").html("Alerta de seguridad");
          jQuery(".modal-body").html("No es posible iniciar sesión, tu cuenta se encuentra bloqueada debido a un intento de violación de seguridad al tratar de acceder a tu cuenta. Por favor dirijase a su correo electrónico para restablecer la integridad de su cuenta.");
          jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

          jQuery(".modal-btn-accept").on("click",function () {
            jQuery(".modal").modal("toggle");
            location.reload();
          });

        }
        else
        {
          localStorage.acceso         = 1;
          localStorage.id_tipo_identi = jsonResponse.data['id_tipo_identi'];
          localStorage.num_identi     = jsonResponse.data['num_identi'];
          localStorage.nombre         = jsonResponse.data['nombre'];
          localStorage.email          = jsonResponse.data['email'];
          localStorage.telefono       = jsonResponse.data['telefono'];
          localStorage.id_perfil      = jsonResponse.data['id_perfil'];
          localStorage.clave          = jsonResponse.data['clave'];
          localStorage.foto           = jsonResponse.data['foto'];
          localStorage.fecha_usuario  = jsonResponse.data['fecha_usuario'];
          localStorage.estado         = jsonResponse.data['estado'];
          localStorage.perfil         = jsonResponse.data['perfil'];
          localStorage.sesion         = "Conectado";

          if (localStorage.id_perfil == 1) 
          {
            location.href = "adm/";
          }
          else if(localStorage.id_perfil == 2)
          {
            location.href = "user/";
          }
        }
      }
      else if(jsonResponse['estado'] == "error")
      {
        jQuery(".modal").modal("toggle");
        jQuery(".modal-title").html("Ha ocurrido un errror");
        jQuery(".modal-body").html(jsonResponse['data']);
        jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

        jQuery(".modal-btn-accept").on("click",function () {
          jQuery(".modal").modal("toggle");
        });
      }
    }
  });
}

function signUpFacebook(response) {
    
  jQuery(".modal").modal("toggle");
  jQuery(".modal-title").html('Nuevo Usuario');
  jQuery(".modal-body").html('<form class="col-xs-12" id="form_registro_usuario">'+
              '<div class="form-group">'+
                '<p>Nombres (*)</p>'+
                '<input class="form-control" type="text" name="nombre" id="nombre" data-name="Nombres">'+
              '</div>'+
              '<div class="form-group">'+
                '<p>Apellidos (*)</p>'+
                '<input class="form-control" type="text" name="apellido" id="apellido" data-name="Apellidos">'+
              '</div>'+
              '<div class="form-group">'+
                '<p>Telefono (*)</p>'+
                '<input class="form-control" type="number" min="0" name="telefono" id="telefono" data-name="Telefono">'+
              '</div>'+
              '<div class="form-group">'+
                '<p>E-mail (*)</p>'+
                '<input class="form-control" type="text" name="email" id="email" data-name="E-mail">'+
              '</div>'+
              '<div class="form-group">'+
                '<p>Contraseña (*)</p>'+
                '<input class="form-control" type="password" name="contrasena" id="contrasena" data-name="Contraseña">'+
              '</div>'+
              '<div class="form-group">'+
                '<p>Repetir Contraseña (*)</p>'+
                '<input class="form-control" type="password" name="repetir_contrasena" id="repetir_contrasena" data-name="Repetir Contraseña">'+
              '</div>'+
              '<div class="form-group">'+
                '<table style="width: 100%;text-align: center;">'+
                  '<tr>'+
                    '<td style="width: 10%;"><input style="width: 20px;height: 20px;" type="checkbox" name="notificaciones" id="notificaciones" value="1" data-name="Recibir Notificaciones"></td>'+
                    '<td style="width: 90%;"><p>Me gustaria recibir notificaciones de promociones via correo electrónico.</p></td>'+
                  '</tr>'+
                '</table>'+
              '</div>'+
              '<div class="form-group">'+
                '<table style="width: 100%;text-align: center;">'+
                  '<tr>'+
                    '<td style="width: 10%;"><input style="width: 20px;height: 20px;" type="checkbox" name="terminos_condiciones" id="terminos_condiciones" value="1" data-name="Terminos y condiciones"></td>'+
                    '<td style="width: 90%;"><p>Acepto los términos y condiciones y la Política de Privacidad y Tratamiento de Datos Personales.</p></td>'+
                  '</tr>'+
                '</table>'+     
              '</div>'+
              '<hr>'+

              '<div id="alerta_formulario" class="alert alert-danger" style="display: none;"></div>'+

        '<!--<button title="Registrarse" type="button" class="btn btn-primary btn-block" onclick="validar_form_registro()">Registrarse</button>-->'+

  '</form>');

  jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

  //  LLENAR CAMPOS CON DATOS TRAIDOS DE FACEBOOK
  jQuery("#form_registro_usuario #nombre").val(response.first_name);
  jQuery("#form_registro_usuario #apellido").val(response.last_name);
  jQuery("#form_registro_usuario #email").val(response.email);
  jQuery("#form_registro_usuario #contrasena").val('');
  jQuery("#form_registro_usuario #repetir_contrasena").val('');

  jQuery(".modal-btn-accept").click(function () {
    var nombre              = jQuery("#nombre");
    var apellido            = jQuery("#apellido");
    var telefono            = jQuery("#telefono");
    var email               = jQuery("#email");
    var contrasena          = jQuery("#contrasena");
    var repetir_contrasena  = jQuery("#repetir_contrasena");
    var terminos            = jQuery("#terminos_condiciones");

    var campos = [nombre,apellido,telefono,email,contrasena,repetir_contrasena];
    var j = 6;
    
    jQuery("#alerta_formulario").html("");
    jQuery("#alerta_formulario").css("display","none");

    //  EVALUAR SI LOS CAMPOS DEL FORMULARIO ESTAN VACIOS
    for (var i = 0; i < campos.length; i++) 
    {
      if (campos[i].val() == "") 
      {
        jQuery("#alerta_formulario").css("display","block");
        jQuery("#alerta_formulario").html("El campo '"+campos[i].attr('data-name')+"' es obligatorio.");
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
      var errores = [];
      
      //  EVALUAR TIPOS DE DATOS INGRESADOS EN EL FORMULARIO (EXPRESIONES REGULARES)

      var exp_nombre = /^[a-zA-Z a-zA-Z]+$/;
      if (! exp_nombre.test(nombre.val())) 
      {
        errores.push("Error #1: No ingrese caracteres especiales en el campo 'Nombres'");
      }

      var exp_apellido = /^[a-zA-Z a-zA-Z]+$/;
      if (! exp_apellido.test(apellido.val())) 
      {
        errores.push("Error #2: No ingrese caracteres especiales en el campo 'Apellidos'");
      }

      var exp_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
      if (! exp_email.test(email.val())) 
      {
        errores.push("Error #3: El 'E-mail' ingresado no cumple con la estructura de correo electrónico.");
      }

      if (errores.length == 0) 
      {

        if (terminos.prop('checked')) 
        {

          if (contrasena.val() === repetir_contrasena.val()) 
          {
            var form    = document.getElementById('form_registro_usuario');
            var formData  = new FormData(form);

            jQuery.ajax({
              type:"POST",
              url:"vista/ajax/ajax_registro.php?action=registrar",
              data: formData,
              contentType:false,
              processData:false,
              success:function (respuesta){
                
                jQuery("#espera").css("display","none");
                console.log(respuesta);
                var jsonResponse = JSON.parse(respuesta);

                if (jsonResponse.status == "success") 
                {
                  jQuery(".modal-title").html('Registro exitoso');
                  jQuery(".modal-body").html('Felicidades, el registro se realizo correctamente.<br>Procede a validar tu cuenta desde tu correo electronico.');
                  jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

                  jQuery(".modal-btn-accept").click(function () {
                    window.location.reload();
                  });
                }
                else if (jsonResponse.status == "registrado") 
                {
                  jQuery(".modal-title").html('Error de registro');
                  jQuery(".modal-body").html('El correo electrónico ya se encuentra en uso.');
                  jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

                  jQuery(".modal-btn-accept").click(function () {
                    jQuery(".modal").modal('toggle');
                  });
                }
                else
                {
                  console.log(respuesta);
                }

              }
            });

          }
          else
          {
            console.log("Las claves no coinciden");
            jQuery("#alerta_formulario").css("display","block");
            jQuery("#alerta_formulario").html("¡Las contraseñas con coinciden!");
          }
        }
        else
        {
          console.log("No ha aceptado los terminos y condiciones");
          jQuery("#alerta_formulario").css("display","block");
          jQuery("#alerta_formulario").html("¿No esta de acuerdo con nuestra politica de términos y condiciones?");
        }
      }
      else
      {
        for (var i = 0; i < errores.length; i++) 
        {
          jQuery("#alerta_formulario").css("display","block");
          jQuery("#alerta_formulario").html("");
          jQuery("#alerta_formulario").append('> '+errores[i]+'<br>');
        }
      }
    }

  });

  /*popup("Nuevo Usuario", "<div id=\"signup_container\"></div>", function () {
    submitSignUp();
  }, true);

  jQuery("#signup_container").load("pages/sign_up.html", function() {

    //LLENADO DE CAMPOS DE FORMULARIO DE RGISTRO AUTOMATICAMENTE
    var username = response.email.split("@");

    jQuery("#signup_form #first_name").val(response.first_name);
    jQuery("#signup_form #last_name").val(response.last_name);
    jQuery("#signup_form #email").val(response.email);
    jQuery("#signup_form #username").val(username[0]);
    jQuery("#signup_form #password").val('');
    jQuery("#signup_form #password2").val('');

    jQuery("#signup_form").on("submit", function(e) {
    e.preventDefault();
    var error = "";
    jQuery("#signup_form #msgs").empty();
    jQuery("#signup_form input[required]").each(function() {
      if (jQuery(this).val() === "") {
        error += "<strong>" + jQuery(this).attr("placeholder") + "</strong> es un campo requerido<br>";
      }
    });
    if (jQuery("#signup_form #password").val() !== jQuery("#signup_form #password2").val()) {
      error += "Las contraseñas no coinciden";
    }
    if (! jQuery("#signup_form #terms_and_conditions").prop("checked")) {
      error += "<br><b>Terminos y condiciones</b>:Debe aceptar los terminos y condiciones y las politicas de privacidad para realizar el registro.";
    }

    //VALIDAR CORREO ELECTRONICO
    var validate_email = validateInput('email',jQuery("#signup_form #email").val());
    if (jQuery("#validate_email").val() != "permitido") {
      error += "<br><b>Email</b>: El Email ingresado ya se encuentra en uso.";
    }

    //VALIDAR NOMBRE DE USUARIO
    var validate_username = validateInput('username',jQuery("#signup_form #username").val());
    if (jQuery("#validate_username").val() != "permitido") {
      error += "<br><b>Nombre de Usuario</b>: El Nombre de Usuario ingresado ya esta en uso, intente uno diferente.";         
    }

    if (error !== "") {
      jQuery("#signup_form #msgs").html(error).removeClass("hide");
    } else {
      jQuery("#signup_form #msgs").addClass("hide");
      var form_data = {};

      jQuery("#signup_form :input").each(function(key, item) {
        if(jQuery(item).attr("name") == "is_room") {
          if (jQuery(item).is(":checked")) {
            form_data[jQuery(item).attr("name")] = jQuery(item).val();
          }
        } else {
          form_data[jQuery(item).attr("name")] = jQuery(item).val();
        }
      });

      jQuery.post(api_url, {
        module: "users",
        action: "signUp",
        user: JSON.stringify(form_data)
      }, function(data){
        console.log(data);
        try {
          jsonResponse = jQuery.parseJSON(data);
          if (jsonResponse.success) {
            gtag('event', 'sign_up');
            popup("Cuenta Registrada", "Tu cuenta en <strong>Zepara</strong> ha sido creada con éxito pero aún no ha sido activada. Te invitamos a revisar tu email para activar tu cuenta y poder acceder a nuestra plataforma.", function() {
              window.location.reload();
            });
          } else if (jsonResponse.exists){
            console.log(jsonResponse.data);
            jQuery("#inshaka_login #msgs").html("El usuario <strong>" + jsonResponse.data.username + "</strong> ya se encuentra registrado").removeClass("hide");
          } else {
            console.log(jsonResponse.data);
            jQuery("#inshaka_login #msgs").html("Lo sentimos, ha ocurrido un error").removeClass("hide");
          }
        } catch (e) {
          console.log(data);
          jQuery("#signup_form #msgs").html("Lo sentimos, ha ocurrido un error: <br>" + data).removeClass("hide");
        }
      });
    }
  })
  });*/
}
