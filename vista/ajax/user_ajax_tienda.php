<?php
	require_once "../../controlador/con_tienda.php";
	require_once "../../modelo/mod_tienda.php";

	if (isset($_GET['action'])) 
	{
		switch ($_GET['action']) 
		{
			case 'buscarClasificacion':
				# BUSCAR LISTA DE CLASIFICACION POR CATEGORIA
				$id_categoria 	= $_POST['id_categoria'];

				$producto = new TiendaCon();
				$producto -> listaClasificacionCon($id_categoria);

				break;

			case 'filtro':
				# FILTRO DE PRODUCTOS POR CATEGORIA SELECCIONADA
				$id_categoria = $_POST['id_categoria'];
				$producto = new TiendaCon();
				$producto -> filtroProductosCon($id_categoria);
				break;

			case 'filtro_clasificacion':
				# FILTRO DE PRODUCTOS POR CATEGORIA Y CLASIFICACION SELECCIONADA
				$id_categoria 		= $_POST['id_categoria'];
				$id_clasificacion 	= $_POST['id_clasificacion'];

				$producto = new TiendaCon();
				$producto -> filtroProductosClasificacionCon($id_categoria,$id_clasificacion);

				break;
			
			default:
				print "no hay respuesta";
				break;
		}
	}
?>