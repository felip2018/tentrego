<?php
	require_once "conexion.php";
	require_once "mod_emails.php";
	/**
	* MODELO DE CONTACTO
	*/
	class ContactoMod extends Conexion
	{
		
		#	ENVIAR MENSAJE DE CONTACTO DESDE EL SITIO WEB
		public static function enviarMensajeMod($parametros)
		{
			$email 		= 'felipegarxon@hotmail.com';
			$nombre		= 'Click Store';
			$asunto 	= 'Contacto Pagina Web';
			$plantilla  = 'contactoWeb';

			$envio = Email::programarCorreo($email,$nombre,$asunto,$plantilla,$parametros);

			if ($envio) 
			{
				# SE HA ENVIADO EL MENSAJE CORRECTAMENTE
				$resultado = json_encode(array("estado"	=> "enviado"));
			}
			else
			{
				$resultado = json_encode(array("estado" => "error", "data" => "No se ha podido programar tu correo electrónico"));
			}
			return $resultado;
		}
	}