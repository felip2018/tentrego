<?php
	/**
	 * CONTROLADOR DE DEVOLUCIONES Y GARANTIAS
	 */
	class CasosCon
	{
		
		#	SOLICITAR LISTADO DE CASOS CREADOS
		public function casosProductosCon()
		{
			$respuesta = CasosMod::casosProductosMod();
			return $respuesta;
		}

		#	SOLICITAR INFORMACION DEL CASO SELECCIONADO
		public function infoCasoCon($id_caso)
		{
			$respuesta = CasosMod::infoCasoMod($id_caso);
			return $respuesta;
		}

		#	SOLICITAR ACTUALIZACION DEL PROCESO DEL CASO
		public function actualizarProcesoCon($datosProceso)
		{
			$respuesta = CasosMod::actualizarProcesoMod($datosProceso);
			print $respuesta;
		}

		#	SOLICITAR LA TRAZABILIDAD DEL CASO
		public function trazabilidadCasoCon($id_caso)
		{
			$respuesta = CasosMod::trazabilidadCasoMod($id_caso);
			return $respuesta;
		}
	}
?>