<?php
	require_once "../../controlador/adm_con_atributos.php";
	require_once "../../modelo/adm_mod_atributos.php";

	$ac = $_GET['ac'];

	switch ($ac) 
	{
		case '1':
			# REGISTRAR ATRIBUTO
			$nombre 		= strtoupper($_POST['nombre']);
			$descripcion 	= strtoupper($_POST['descripcion']);

			$datosAtributo 	= array("nombre" 		=> $nombre,
									"descripcion"	=> $descripcion);

			$atributo = new AtributosCon();
			$atributo -> registrarAtributoCon($datosAtributo);

			break;
		
		case '2':
			# ACTUALIZAR ATRIBUTO
			$id_atributo 	= $_POST['id_atributo'];
			$nombre 		= strtoupper($_POST['nombre']);
			$descripcion 	= strtoupper($_POST['descripcion']);

			$datosAtributo = array(	"id_atributo"	=> $id_atributo,
									"nombre"		=> $nombre,
									"descripcion"	=> $descripcion);

			$atributo = new AtributosCon();
			$atributo -> actualizarAtributoCon($datosAtributo);

			break;

		case '3':
			# ESTADO DE ATRIBUTO
			$estado 		= $_POST['estado'];
			$id_atributo 	= $_POST['id_atributo'];

			$datosAtributo = array(	"id_atributo"	=> $id_atributo,
									"estado"		=> $estado);

			$atributo = new AtributosCon();
			$atributo -> estadoAtributoCon($datosAtributo);

			break;

		
	}

?>