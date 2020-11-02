<?php
	require_once "../../controlador/adm_con_marcas.php";
	require_once "../../modelo/adm_mod_marcas.php";

	$ac = $_GET['ac'];

	switch ($ac) 
	{
		case '1':
			# REGISTRAR MARCAS
			$nombre 	= strtoupper($_POST['nombre']);

			$datosMarca = array("nombre" => $nombre);

			$marca = new MarcasCon();
			$marca -> registrarMarcaCon($datosMarca);

			break;
		
		case '2':
			# ACTUALIZAR MARCA
			$id_marca 	= $_POST['id_marca'];
			$nombre 	= strtoupper($_POST['nombre']);

			$datosMarca = array("id_marca"	=> $id_marca,
								"nombre"	=> $nombre);

			$marca = new MarcasCon();
			$marca -> actualizarMarcaCon($datosMarca);

			break;

		case '3':
			# ESTADO DE MARCA
			$estado 	= $_POST['estado'];
			$id_marca 	= $_POST['id_marca'];

			$datosMarca = array("id_marca"	=> $id_marca,
								"estado"	=> $estado);

			$marca = new MarcasCon();
			$marca -> estadoMarcaCon($datosMarca);

			break;

		
	}

?>