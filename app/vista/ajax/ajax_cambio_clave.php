<?php
	require_once "../../controlador/con_cambio_clave.php";
	require_once "../../modelo/mod_cambio_clave.php";

	if (isset($_GET['action'])) 
	{
		switch ($_GET['action']) 
		{
			case 'cambiarClave':
				# CAMBIAR CLAVE DE ACCESO
				$email 			= $_POST['email'];
				$codigo 		= $_POST['codigo'];
				$nueva_clave 	= $_POST['nueva_clave'];

				$datosCambio 	= array("email"		=> $email,
										"codigo"	=> $codigo,
										"clave"		=> $nueva_clave);

				$cambio_clave = new CambioClaveCon();
				$cambio_clave -> actualizarClaveCon($datosCambio);

				break;

			case 'solicitarCambioClave':
				# SOLICITAR CASO PARA CAMBIO DE CLAVE
				$email = $_POST['email'];

				$cambio_clave = new CambioClaveCon();
				$cambio_clave -> solicitarCambioClaveCon($email);

				break;
			
			default:
				# code...
				break;
		}
	}
?>