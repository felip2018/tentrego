<?php 
	
	/**
	* CONEXION A LA BASE DE DATOS
	*/
	class Conexion
	{
		
		public static function conectar()
		{
			$con = new PDO("mysql:host=localhost;dbname=click_store","nextyt","IbMKDNHcQxUPpro");
			return $con;
		}

	}