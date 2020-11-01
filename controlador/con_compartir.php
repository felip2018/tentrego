<?php
	/**
	* CONTROLADOR DE LA SECCION DE COMPARTIR
	*/
	class CompartirCon
	{
		
		#	REALIZAR EL CONTEO DE VISITAS POR SEGUIMIENTO DE ENLACE COMPARTIDO DESDE FACEBOOK
		public function conteoVisitaCon($origen,$recomienda)
		{
			$resultado = CompartirMod::conteoVisitaMod($origen,$recomienda);
			return $resultado;
		}

	}
?>