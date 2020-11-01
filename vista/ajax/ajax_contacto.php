<?php
	require_once "../../controlador/con_contacto.php";
	require_once "../../modelo/mod_contacto.php";

	if (isset($_GET['action'])) 
	{
		switch ($_GET['action']) {
			case 'enviarFormulario':
				# ENVIAR FORMULARIO DE CONTACTO
				$nombre 	= strtoupper($_POST['nombre']);
				$telefono 	= $_POST['telefono'];
				$email 		= strtoupper($_POST['email']);
				$mensaje 	= strtoupper($_POST['mensaje']);

				$datosContacto = array(	"nombre"	=> $nombre,
										"telefono"	=> $telefono,
										"email"		=> $email,
										"mensaje"	=> $mensaje);

				$parametros = json_encode($datosContacto);

				$contacto = new ContactoCon();
				$contacto -> enviarMensajeCon($parametros);


				break;
			
			default:
				# code...
				break;
		}
	}

?>