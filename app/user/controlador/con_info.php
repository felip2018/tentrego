<?php
	/**
	* CONTROLADOR DE INFORMACION DE PRODUCTO
	*/
	class InfoCon
	{
		
		#	SOLICITAR INFORMACION DEL PRODUCTO SELECCIONADO
		public function infoProductoCon($productId)
		{
			$respuesta = InfoMod::infoProductoMod($productId);
			return $respuesta;
		}

		#	SOLICITAR LISTADO DE ATRIBUTOS REGISTRADOS DEL PRODUCTO
		public function listaAtributosCon($id_producto)
		{
			$respuesta = InfoMod::listaAtributosMod($id_producto);
			return $respuesta;
		}

		#	SOLICITAR LISTA DE RESEÑAS DEL PRODUCTO
		public function listaResenasCon($id_producto)
		{
			$respuesta = InfoMod::listaResenasMod($id_producto);
			return $respuesta;
		}

		#	SOLICITAR IMAGENES GUARDADAS DEL PRODUCTO SELECCIONADO
		public function imagenesProductoCon($id_producto)
		{
			$respuesta = InfoMod::imagenesProductoMod($id_producto);
			return $respuesta;
		}
	}
?>