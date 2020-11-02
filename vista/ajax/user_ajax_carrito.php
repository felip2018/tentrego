<?php
	require_once "../../controlador/user_con_carrito.php";
	require_once "../../modelo/user_mod_carrito.php";

	if (isset($_GET['action'])) 
	{
		switch ($_GET['action']) 
		{
			case 'agregar_producto':
				# 	AGREGAR PRODUCTO AL CARRITO DE COMPRAS
				$id_producto 	= $_POST['id_producto'];
				$nombre 		= $_POST['nombre'];
				$venta 			= $_POST['venta'];
				$imagen 		= $_POST['imagen'];

				#	EVALUAMOS SI EXISTE LA COOKIE DEL USUARIO QUE COMPARTIO EL ENLACE AL SITIO PARA DARLE CREDITO POR LA COMPRA. LA COOKIE CONTENDRA EL EMAIL DE LA CUENTA DEL USUARIO QUE COMPARTIO EL ENLACE

				if (isset($_COOKIE['origen']) &&
					isset($_COOKIE['recomienda'])) 
				{
					$origen 		= $_COOKIE['origen'];
					$recomienda 	= $_COOKIE['recomienda'];	
				}
				else
				{
					$origen 		= "Web";
					$recomienda 	= "";
				}

				$datosProducto 	= array("id_producto"	=> $id_producto,
										"nombre"		=> $nombre,
										"cantidad"		=> 1,
										"venta"			=> $venta,
										"imagen"		=> $imagen,
										"origen"		=> $origen,
										"recomienda" 	=> $recomienda,
										"estado"		=> "Activo");

				$carrito = new CarritoCon();
				$carrito -> agregarProductoCon($datosProducto);

				break;

			case 'ver_carrito':
				# 	VER CARRITO DE COMPRAS
				$carrito = new CarritoCon();
				$carrito -> verCarritoCon();
				break;

			case 'eliminar_producto':
				# 	ELIMINAR PRODUCTO DEL CARRITO DE COMPRAS
				$indice  = $_POST['indice'];

				$carrito = new CarritoCon();
				$carrito -> eliminarProductoCon($indice);
				break;
			
			case 'cambiar_cantidad':
				# 	CAMBIAR CANTIDAD DE PRODUCTO EN EL CARRITO DE COMPRAS
				$indice 	= $_POST['indice'];
				$cantidad 	= $_POST['cantidad'];

				$carrito = new CarritoCon();
				$carrito -> cantidadProductoCon($indice,$cantidad);

				break;

			case 'realizar_pedido':
				# 	REALIZAR PEDIDO
				$email 			= $_POST['email'];
				$observaciones 	= $_POST['observaciones'];

				$carrito = new CarritoCon();
				$carrito -> realizarPedidoCon($email,$observaciones);

				break;

			case 'vaciar_carrito':
				# 	VACIAR EL CARRITO DE COMPRAS
				$carrito = new CarritoCon();
				$carrito -> vaciarCarritoCon();				
				break;

			default:
				print json_encode(array("estado" => "No hay respuesta"));
				break;
		}
	}
?>