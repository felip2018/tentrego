<?php
	require_once "../../controlador/con_validacion.php";
	require_once "../../modelo/mod_validacion.php";

	if (isset($_POST['action'])) 
	{
		switch ($_POST['action']) 
		{
			case 'validate_account':
				$email 	= $_POST['email'];
				$codigo = $_POST['codigo'];

				$datosValidacion = array(	"email"	=> $email,
											"codigo"=> $codigo);

				$validacion = new ValidacionCon();
				$validacion -> validarCuentaCon($datosValidacion);

				break;
			
			default:
				print json_encode(array("estado" => "Error de autorizacion","data" => "No hay respuesta"));
				break;
		}
	}

?>