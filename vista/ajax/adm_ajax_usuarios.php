<?php
	require_once "../../controlador/adm_con_usuarios.php";
	require_once "../../modelo/adm_mod_usuarios.php";

	$ac = $_GET['ac'];

	switch ($ac) 
	{
		case '1':
			# REGISTRAR USUARIO
			$id_tipo_identi = $_POST['id_tipo_identi'];
			$num_identi 	= $_POST['num_identi'];
			$nombre 		= strtoupper($_POST['nombre']);
			$apellido 		= strtoupper($_POST['apellido']);
			$email 			= $_POST['email'];
			$telefono 		= $_POST['telefono'];
			$id_perfil 		= $_POST['id_perfil'];

			$datosUsuario 	= array("id_tipo_identi"	=> $id_tipo_identi,
									"num_identi"		=> $num_identi,
									"nombre"			=> $nombre,
									"apellido"			=> $apellido,
									"email"				=> $email,
									"telefono"			=> $telefono,
									"id_perfil"			=> $id_perfil);

			$usuario = new UsuariosCon();
			$usuario -> registrarUsuarioCon($datosUsuario);

			break;
		
		case '2':
			# ACTUALIZAR USUARIO
			$pk_usuario = $_POST['pk_usuario'];
			$nombre 	= strtoupper($_POST['nombre']);
			$apellido 	= strtoupper($_POST['apellido']);
			$email 		= $_POST['email'];
			$telefono 	= $_POST['telefono'];
			$id_perfil 	= $_POST['id_perfil'];

			$datosUsuario = array(	"pk_usuario"	=> $pk_usuario,
									"nombre"		=> $nombre,
									"apellido"		=> $apellido,
									"email"			=> $email,
									"telefono"		=> $telefono,
									"id_perfil"		=> $id_perfil);

			$usuario = new UsuariosCon();
			$usuario -> actualizarUsuarioCon($datosUsuario);

			break;

		case '3':
			# ESTADO DE USUARIO
			$estado 		= $_POST['estado'];
			$pk_usuario 	= $_POST['pk_usuario'];

			$datosUsuario 	= array("pk_usuario"	=> $pk_usuario,
									"estado"		=> $estado);

			$usuario = new UsuariosCon();
			$usuario -> estadoUsuarioCon($datosUsuario);

			break;
	}

?>