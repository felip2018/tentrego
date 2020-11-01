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

		#	SOLICITAR VALIDACION DE PERFIL DE USUARIO
		public function validarPerfilCon($email,$id_perfil)
		{
			$respuesta = InicioMod::validarPerfilMod($email,$id_perfil);
			print $respuesta;
		}
		
	}
?>