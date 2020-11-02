<?php
	require_once "../../../controlador/adm/con_promociones.php";
	require_once "../../../modelo/adm/mod_promociones.php";

	if (isset($_GET['action'])) 
	{
		switch ($_GET['action']) 
		{
			case 'estadoPromocion':
				# 	ESTADO DE LA PROMOCION SELECCIONADA
				$estado 		= $_POST['estado'];
				$id_promocion 	= $_POST['id_promocion'];

				$datosPromocion = array("estado"		=> $estado,
										"id_promocion" 	=> $id_promocion);

				$promocion = new PromocionesCon();
				$promocion -> estadoPromocionCon($datosPromocion);

				break;
			
			default:
				# code...
				break;
		}
	}

?>