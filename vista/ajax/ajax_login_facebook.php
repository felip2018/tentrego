<?php
	require_once "../../controlador/con_login_facebook.php";
	require_once "../../modelo/mod_login_facebook.php";

	if (isset($_POST['action'])) 
	{
		switch ($_POST['action']) 
		{
			case 'validarUsuario':
				# VALIDAR USUARIO QUE INTENTA INGRESAR CON FACEBOOK

				$nombre 	= $_POST['user_first_name'];
				$apellido 	= $_POST['user_last_name'];
				$email 		= $_POST['user_email'];

				$datosUsuario = array(	"nombre"	=> $nombre,
										"apellido"	=> $apellido,
										"email"		=> $email);

				$login = new LoginFacebookCon();
				$login -> validarUsuarioCon($datosUsuario);

				break;

			case 'loginFacebook':
				# INICIO DE SESION CON FAACEBOOK
				
				$email = $_POST['email'];

				$login = new LoginFacebookCon();
				$login -> validacionFacebookCon($email);

				break;
			
			default:
				# NO HAY RESPUESTA
				print json_encode(array("status" => "No hay respuesta"));
				break;
		}
	}
?>