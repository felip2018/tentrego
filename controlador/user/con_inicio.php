<?php
	/**
	* CONTROLADOR DE INICIO
	*/
	class InicioCon
	{
		#	SOLICITAR CIERRE DE SESION
		public function cerrarSesionCon($usuario)
		{
			$respuesta = InicioMod::cerrarSesionMod($usuario);
			print $respuesta;
		}

		#	SOLICITAR INFORMACION DE USUARIO
		public function infoUsuarioCon($email)
		{
			$respuesta = InicioMod::infoUsuarioMod($email);
			print $respuesta;
		}

		#	SOLICITAR ACTUALIZACION DE INFORMACION DE USUARIO
		public function actualizarInfoCon($datosUsuario)
		{
			$respuesta = InicioMod::actualizarInfoMod($datosUsuario);
			print $respuesta;	
		}

		#	SOLICITAR INFORME DE CANTIDAD DE PEDIDOS REALIZADOS POR USUARIO DISTRIMINADOS POR ESTADO
		public function pedidosUsuarioCon($email)
		{
			$respuesta = InicioMod::pedidosUsuarioMod($email);
			print $respuesta;	
		}

		#	SOLICITAR VALIDACION DE PERFIL DE USUARIO
		public function validarPerfilCon($email,$id_perfil)
		{
			$respuesta = InicioMod::validarPerfilMod($email,$id_perfil);
			print $respuesta;
		}
		
	}
?>