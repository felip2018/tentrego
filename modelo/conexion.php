<?php
	/**
	* CLASE QUE CONECTA A LA BASE DE DATOS MEDIANTE EL OBJETO DE CONEXION PDO
	*/
	class Conexion
	{
		public static function conectar()
		{
			$con = new PDO("mysql:host=localhost;dbname=te_entrego","nextyt","IbMKDNHcQxUPpro");
			return $con;
		}
	}