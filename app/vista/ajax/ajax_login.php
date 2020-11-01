<?php
	require_once "../../controlador/con_login.php";
	require_once "../../modelo/mod_login.php";

	$salt 			= '$2a$10$softwarebynextytechnet$';
	
	$login 			= $_POST['login'];
	$clave 			= $_POST['clave'];

	$encrypt 		= crypt($clave,$salt);

	$datosUsuario 	= array("login"		=> $login,
							"clave"		=> $encrypt,
							"estado"	=> "Activo");

	$login = new LoginCon();
	$login -> validacionCon($datosUsuario);

?>