<?php
	/**
	* CONTROLADOR DEL CARRITO DE COMPRAS
	*/
	class CarritoCon
	{
		//	AGREGAR PRODUCTO AL CARRITO DE COMPRAS
		public function agregarProductoCon($datosProducto)
		{
			session_start();
			$respuesta = $_SESSION['carrito']->agregarProductoMod($datosProducto);
			print $respuesta;
		}

		//	VER CARRITO DE COMPRAS
		public function verCarritoCon()
		{
			session_start();
			$respuesta = $_SESSION['carrito']->verCarritoMod();
			//print $respuesta;
		}

		//	ELIMINAR PRODUCTO DEL CARRITO DE COMPRAS
		public function eliminarProductoCon($indice)
		{
			session_start();
			$respuesta = $_SESSION['carrito']->eliminarProductoMod($indice);
			print $respuesta;
		}

		// 	ACTUALIZAR CANTIDAD DE PRODUCTO EN EL CARRITO DE COMPRAS
		public function cantidadProductoCon($indice,$cantidad)
		{
			session_start();
			$respuesta = $_SESSION['carrito']->cantidadProductoMod($indice,$cantidad);
			print $respuesta;
		}
	}
?>