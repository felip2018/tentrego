<?php
	require_once "../../controlador/user_con_casos.php";
	require_once "../../modelo/user_mod_casos.php";

	if (isset($_GET['action'])) 
	{
		switch ($_GET['action']) 
		{
			case 'actualizarProceso':
				# ACTUALIZAR ESTADO DEL CASO SELECCIONADO
				$id_caso 		= $_POST['id_caso'];
				$cliente 		= $_POST['cliente'];
				$email 			= $_POST['email'];
				$estado 		= $_POST['estado'];
				$descripcion 	= $_POST['descripcion'];

				$datosProceso 	= array("id_caso"		=> $id_caso,
										"cliente"		=> $cliente,
										"email"			=> $email,
										"estado"		=> $estado,
										"descripcion"	=> $descripcion);

				$caso = new CasosCon();
				$caso -> actualizarProcesoCon($datosProceso);

				break;
			
			default:
				# code...
				break;
		}
	}
?>