<?php
	
	require_once "controlador/con_compartir.php";
	require_once "modelo/mod_compartir.php";

	#	RECIBIMOS LAS VARIABLES GET
	$modulo 	= $_GET['modulo'];
	$origen 	= $_GET['origen'];
	$recomienda = $_GET['recomienda'];

	#	EVALUAMOS SI EXISTE LA COOKIE

	if (!isset($_COOKIE['origen']) && !isset($_COOKIE['recomienda'])) 
	{
		// setcookie(NAME,VALUE,EXPIRED_ON);
		// 84600 -> 1 Dia

		// REGISTRAMOS LAS COOKIES EN EL NAVEGADOR DEL USUARIO
		setcookie("origen",$origen,time() + 84600,'/');
		setcookie("recomienda",$recomienda,time() + 84600,'/');

		// HACEMOS EL CONTEO DE VISITA A LA PAGINA
		$compartir = new CompartirCon();
		$conteo = $compartir -> conteoVisitaCon($origen,$recomienda);

		if ($conteo) {
			header('Location: http://localhost/click_store/');
		}

	}
	else
	{
		
		header('Location: http://localhost/click_store/');
		//header('Location: https://www.clickstore.co/');
	}

?>