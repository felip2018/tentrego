<?php
	require_once "../../controlador/adm_con_inicio.php";
	require_once "../../modelo/adm_mod_inicio.php";

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
 						//print_r($_POST);
						break;
					
					default:
						echo "No hay respuesta";
						break;
				}
				break;
			
			case 'inicio':
				# 	MODULO DE INICIO
				break;

			default:
				echo "No hay respuesta";
				break;
		}
	}
?>