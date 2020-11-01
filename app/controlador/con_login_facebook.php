<?php
	/**
	* CONTROLADOR DE LOGIN CON FACEBOOK
	*/
	class LoginFacebookCon
	{
		
		#	SOLICITAR VALIDACION DE USUARIO
		public function validarUsuarioCon($datosUsuario)
		{
			$respuesta = LoginFacebookMod::validarUsuarioMod($datosUsuario);
			print $respuesta;
		}

		#	SOLICITAR VALIDACION DE USUARIO
		public function validacionFacebookCon($email)
		{
			$respuesta = LoginFacebookMod::validacionFacebookMod($email);
			print $respuesta;
		}
	}
?>