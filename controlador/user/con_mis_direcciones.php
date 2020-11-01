<?php
	/**
	* CONTROLADOR DE MIS DIRECCIONES
	*/
	class MisDireccionesCon
	{
		#	SOLICITAR LISTADO DE DIRECCIONES
		public function listadoDireccionesCon($email)
		{
			$respuesta = MisDireccionesMod::listadoDireccionesMod($email);
			return $respuesta;
		}	

		#	SOLICITAR LISTADO DE DEPARTAMENTOS
		public function listaDptosCon()
		{
			$respuesta = MisDireccionesMod::listaDptosMod();
			return $respuesta;
		}

		#	SOLICITAR LISTADO DE CIUDADES
		public function listadoCiudadesCon($id_dpto)
		{
			$respuesta = MisDireccionesMod::listadoCiudadesMod($id_dpto);
			return $respuesta;
		}

		#	SOLICITAR REGISTRO DE DIRECCION
		public function registrarDireccionCon($datosDireccion)
		{
			$respuesta = MisDireccionesMod::registrarDireccionMod($datosDireccion);
			print $respuesta;
		}

		#	SOLICITAR INFORMACION DE DIRECCION
		public function infoDireccionCon($id_direccion)
		{
			$respuesta = MisDireccionesMod::infoDireccionMod($id_direccion);
			return $respuesta;
		}

		#	SOLICITAR ACTUALIZACION DE DIRECCION
		public function actualizarDireccionCon($datosDireccion)
		{
			$respuesta = MisDireccionesMod::actualizarDireccionMod($datosDireccion);
			print $respuesta;
		}

		#	SOLICITAR CAMBIO DE ESTADO DE DIRECCION
		public function estadoDireccionCon($datosDireccion)
		{
			$respuesta = MisDireccionesMod::estadoDireccionMod($datosDireccion);
			print $respuesta;	
		}

	}	
?>