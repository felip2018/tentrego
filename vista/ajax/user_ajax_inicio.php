<?php
	require_once "../../controlador/user_con_inicio.php";
	require_once "../../modelo/user_mod_inicio.php";

	//require_once "../../modelo/PHPExcel/Classes/PHPExcel/IOFactory.php";

	/*ENVIO DE MENSAJERIA VIA EMAIL*/
	require_once "../../modelo/PHPMailer/class.phpmailer.php";
	require_once "../../modelo/PHPMailer/class.smtp.php";
	require_once "../../modelo/PHPMailer/PHPMailerAutoload.php";
	
	if (isset($_POST['modulo']) && isset($_POST['action'])) 
	{
		switch ($_POST['modulo']) 
		{
			case 'sesion':
				#	MODULO DE SESION
				switch ($_POST['action']) 
				{
					case 'cerrar_sesion':
						# CERRAR SESION DE USUARIO
						if (isset($_POST['usuario'])) 
						{
							$inicio = new InicioCon();
							$inicio -> cerrarSesionCon($_POST['usuario']);
						}

						break;

					case 'validar_perfil':
						# VALIDACION DE CUENTA PARA PERMITIR SU ACCESO
						if (isset($_POST['usuario']) && isset($_POST['id_perfil'])) 
						{
							$inicio = new InicioCon();
							$inicio -> validarPerfilCon($_POST['usuario'],$_POST['id_perfil']);
 						}
						break;
					
					default:
						echo "No hay respuesta";
						break;
				}
				break;
			
			case 'inicio':
				# 	MODULO DE INICIO
				switch ($_POST['action']) 
				{
					case 'informacionUsuario':
						# CONSULTAR INFORMACION DE USUARIO
						$email 	= $_POST['email'];
						
						$inicio = new InicioCon();
						$inicio -> infoUsuarioCon($email);

						break;

					case 'actualizarInfoUsuario':
						# ACTUALIZAR INFORMACION DE USUARIO
						$pk_email 	= $_POST['pk_email'];
						$nombre 	= strtoupper($_POST['nombre']);
						$apellido 	= strtoupper($_POST['apellido']);
						$num_identi = $_POST['num_identi'];
						$telefono 	= $_POST['telefono'];
						$direccion 	= $_POST['direccion'];

						$datosUsuario = array(	"email"		=> $pk_email,
												"nombre"	=> $nombre,
												"apellido"	=> $apellido,
												"num_identi"=> $num_identi,
												"telefono"	=> $telefono,
												"direccion"	=> $direccion);

						$inicio = new InicioCon();
						$inicio -> actualizarInfoCon($datosUsuario);

						break;

					case 'pedidosUsuario':
						# CONSULTAR PEDIDOS DEL USUARIO
						$email 	= $_POST['email'];

						$inicio = new InicioCon();
						$inicio -> pedidosUsuarioCon($email);

						break;
					
					default:
						echo "No hay respuesta";
						break;
				}
				break;

			default:
				echo "No hay respuesta";
				break;
		}
	}
?>