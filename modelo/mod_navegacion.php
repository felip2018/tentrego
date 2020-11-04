<?php
	require_once "conexion.php";
	/**
	* MODELO DE NAVEGACION
	*/
	class NavegacionMod extends Conexion {
		
		#	MOSTRAR EL CONTENIDO DE LA PAGINA
		public static function navegacionPagMod() {
			if (isset($_GET['modulo'])) {
				#	LISTA BLANCA DE MODULOS
				if ($_GET['modulo'] == "inicio" ||
					$_GET['modulo'] == "quienes_somos" ||
					$_GET['modulo'] == "tienda" ||
					$_GET['modulo'] == "contactenos" ||
					$_GET['modulo'] == "lista_deseos" ||
					$_GET['modulo'] == "ingresar" ||
					//$_GET['modulo'] == "registrarse" ||
					$_GET['modulo'] == "quienes_somos" ||
					$_GET['modulo'] == "como_comprar" ||
					$_GET['modulo'] == "carrito_compra" ||
					$_GET['modulo'] == "terminos" ||
					$_GET['modulo'] == "politicas" ||
					$_GET['modulo'] == "info" ||
					$_GET['modulo']	== "response" ||
					$_GET['modulo'] == "confirmation" ||
					$_GET['modulo'] == "compartir" || 
					$_GET['modulo'] == "promociones") {

					$vista = "vista/modulos/".$_GET['modulo'].".php";

				} else {

					$vista = "vista/modulos/not_found.php";

				}
			} else {
				$vista = "vista/modulos/inicio.php";
			}

			return $vista;
		}
		
	}
