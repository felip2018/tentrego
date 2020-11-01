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

		//	VACIAR EL CARRITO DE COMPRAS
		public function vaciarCarritoCon()
		{
			session_start();
			$respuesta = $_SESSION['carrito']->vaciarCarritoMod();
			print $respuesta;
		}

		//	SOLICITAR PEDIDO
		public function realizarPedidoCon($email,$observaciones)
		{
			session_start();
			
			if (isset($_SESSION['carrito'])) 
			{
				$respuesta = $_SESSION['carrito']->realizarPedidoMod($email,$observaciones);
				print $respuesta;
			}
			else
			{
				#	SESION DE CARRITO CADUCADA
				$respuesta = json_encode(array("estado" => "caducado"));
				print $respuesta;
			}
		}

	}
?>