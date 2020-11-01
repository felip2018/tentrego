<?php
	require_once "../../controlador/con_categorias.php";
	require_once "../../modelo/mod_categorias.php";

	$ac = $_GET['ac'];

	switch ($ac) 
	{
		case '1':
			# REGISTRAR CATEGORIAS
			$nombre 		= strtoupper($_POST['nombre']);
			$descripcion 	= strtoupper($_POST['descripcion']);

			$datosCategoria = array("nombre"			=> $nombre,
									"descripcion"		=> $descripcion);

			$categoria = new CategoriasCon();
			$categoria -> registrarCategoriaCon($datosCategoria);

			break;
		
		case '2':
			# ACTUALIZAR CATEGORIA
			$id_categoria 	= $_POST['id_categoria'];
			$nombre 		= strtoupper($_POST['nombre']);
			$descripcion 	= strtoupper($_POST['descripcion']);

			$datosCategoria = array("id_categoria"	=> $id_categoria,
									"nombre"		=> $nombre,
									"descripcion"	=> $descripcion);

			$categoria = new CategoriasCon();
			$categoria -> actualizarCategoriaCon($datosCategoria);

			break;

		case '3':
			# ESTADO DE CATEGORIA
			$estado 		= $_POST['estado'];
			$id_categoria 	= $_POST['id_categoria'];

			$datosCategoria = array("id_categoria"	=> $id_categoria,
									"estado"		=> $estado);

			$categoria = new CategoriasCon();
			$categoria -> estadoCategoriaCon($datosCategoria);

			break;

		case '4':
			# REGISTRAR CLASIFICACION DE CATEGORIA
			$id_categoria 	= $_POST['id_categoria'];
			$nombre 		= strtoupper($_POST['nombre']);

			$datosClasificacion = array('id_categoria' 	=> $id_categoria, 
										'nombre'		=> $nombre,
										'estado'		=> "Activo");

			$categoria = new CategoriasCon();
			$categoria -> registrarClasificacionCon($datosClasificacion);

			break;

		case '5':
			# ACTUALIZAR CLASIFICACION
			$id_clasificacion 	= $_POST['id_clasificacion'];
			$nombre 			= strtoupper($_POST['nombre']);

			$datosClasificacion = array('id_clasificacion' 	=> $id_clasificacion, 
										'nombre'			=> $nombre);

			$categoria = new CategoriasCon();
			$categoria -> actualizarClasificacionCon($datosClasificacion);

			break;

		case '6':
			# ACTUALIZAR ESTADO DE CLASIFICACION
			$estado 			= $_POST['estado'];
			$id_clasificacion 	= $_POST['id_clasificacion'];

			$datosClasificacion = array('id_clasificacion' 	=> $id_clasificacion, 
										'estado'			=> $estado);

			$categoria = new CategoriasCon();
			$categoria -> estadoClasificacionCon($datosClasificacion);

			break;
	}

?>