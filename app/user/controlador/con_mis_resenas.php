<?php
	/**
	* CONTROLADOR DE MIS RESEÑAS
	*/
	class MisResenasCon
	{
		#	SOLICITAR VALIDACION DE RESEÑA
		public function validarResenaCon($datosConsulta)
		{
			$respuesta = MisResenasMod::validarResenaMod($datosConsulta);
			print $respuesta;
		}	

		#	SOLICITAR REGISTRO DE RESEÑA DE PRODUCTO
		public function salvarResenaCon($datosResena)
		{
			$respuesta = MisResenasMod::salvarResenaMod($datosResena);
			print $respuesta;
		}

		#	SOLICITAR LISTADO DE RESEÑAS CREADAS POR EL USUARIO EN SESION
		public function listaResenasCon($email)
		{
			$respuesta = MisResenasMod::listaResenasMod($email);
			return $respuesta;
		}

		#	SOLICITAR INFORMACION DE RESEÑA SELECCIONADA
		public function infoResenaCon($id_resena)
		{
			$respuesta = MisResenasMod::infoResenaMod($id_resena);
			return $respuesta;
		}

		#	SOLICITAR ACTUALIZACION DE RESEÑA
		public function actualizarResenaCon($datosResena)
		{
			$respuesta = MisResenasMod::actualizarResenaMod($datosResena);
			print $respuesta;
		}

		#	SOLICITAR CAMBIO DE ESTADO DE LA RESEÑA
		public function estadoResenaCon($datosResena)
		{
			$respuesta = MisResenasMod::estadoResenaMod($datosResena);
			print $respuesta;	
		}
	
	}
?>