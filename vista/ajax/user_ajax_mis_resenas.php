<?php
	require_once "../../controlador/user_con_mis_resenas.php";
	require_once "../../modelo/user_mod_mis_resenas.php";

	if (isset($_POST['action'])) 
	{
		switch ($_POST['action']) 
		{
			case 'validarResena':
				# VALIDAR SI YA ESTA HECHA UNA RESEÑA DE PRODUCTO
				$id_pedido 		= $_POST['id_pedido'];
				$id_producto 	= $_POST['id_producto'];
				$email 			= $_POST['email'];

				$datosConsulta 	= array("id_pedido"		=> $id_pedido,
										"id_producto"	=> $id_producto,
										"email"			=> $email);

				$mis_resenas 	= new MisResenasCon();
				$mis_resenas 	-> validarResenaCon($datosConsulta); 

				break;

			case 'salvarResena':
				# SALVAR RESEÑA DEL PRODUCTO
				$id_pedido 		= $_POST['id_pedido'];
				$id_producto 	= $_POST['id_producto'];
				$email 			= $_POST['email'];
				$calificacion 	= (!isset($_POST['calificacion']) ? 0 : $_POST['calificacion']);
				$comentarios 	= $_POST['comentarios'];

				$datosResena  	= array("id_pedido"		=> $id_pedido,
										"id_producto"	=> $id_producto,
										"email"			=> $email,
										"calificacion"	=> $calificacion,
										"comentarios"	=> $comentarios);

				$mis_resenas 	= new MisResenasCon();
				$mis_resenas 	-> salvarResenaCon($datosResena); 

				break;

			case 'actualizarResena':
				# ACTUALIZAR RESEÑA SELECCIONADA
				$id_resena		= $_POST['id_resena'];
				$calificacion 	= $_POST['calificacion'];
				$comentarios 	= $_POST['comentarios'];

				$datosResena 	= array("id_resena"		=> $id_resena,
										"calificacion"	=> $calificacion,
										"comentarios" 	=> $comentarios);

				$mis_resenas 	= new MisResenasCon();
				$mis_resenas 	-> actualizarResenaCon($datosResena); 

				break;

			case 'estadoResena':
				# CAMBIAR ESTADO DE RESEÑA
				$estado 	= $_POST['estado'];
				$id_resena 	= $_POST['id_resena'];

				$datosResena= array("estado"	=> $estado,
									"id_resena"	=> $id_resena); 

				$mis_resenas 	= new MisResenasCon();
				$mis_resenas 	-> estadoResenaCon($datosResena); 

				break;
			
			default:
				print json_encode(array("estado" => "No hay respuesta"));
				break;
		}
	}

?>