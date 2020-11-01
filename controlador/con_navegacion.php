<?php
	/**
	* CONTROLADOR DE NAVEGACION
	*/
	class NavegacionCon
	{
		
		#	MOSTRAR EL CONTENIDO DE LA PAGINA
		public function navegacionPagCon()
		{
			$respuesta = NavegacionMod::navegacionPagMod();
			include $respuesta;
		}
		
	}