<?php
	require_once "../../controlador/con_registro.php";
	require_once "../../modelo/mod_registro.php";

	if (isset($_GET['action'])) 
	{
		switch ($_GET['action']) 
		{
			case 'registrar':
				# REGISTRAR USUARIO EN LA BASE DE DATOS
				//print_r($_POST);
				$nombre 			= strtoupper($_POST['nombre']);
				$apellido 			= strtoupper($_POST['apellido']);
				$telefono 			= $_POST['telefono'];
				$email 				= $_POST['email'];
				$contrasena 		= $_POST['contrasena'];
				$repetir_contrasena = $_POST['repetir_contrasena'];
				$notificaciones 	= (isset($_POST['notificaciones'])) ? $_POST['notificaciones'] : 0;
				$terminos_condiciones = $_POST['terminos_condiciones'];

				$datosUsuario = array(	"nombre" 				=> $nombre,
										"apellido"				=> $apellido,
										"telefono"				=> $telefono,
										"email"					=> $email,
										"contrasena"			=> $contrasena,
										"notificaciones"		=> $notificaciones,
										"terminos_condiciones" 	=> $terminos_condiciones);

				$usuario = new RegistroCon();
				$usuario -> nuevoRegistroCon($datosUsuario);

				break;
			
			default:
				echo "Evento de acción invalido!";
				break;
		}
	}
?>