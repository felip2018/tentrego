<?php
	/**
	* CLASE QUE CONECTA A LA BASE DE DATOS MEDIANTE EL OBJETO DE CONEXION PDO
	*/
	class Conexion
	{
		public static function conectar()
		{
			$con = new PDO("mysql:host=localhost;dbname=db_tentrego","tentrego_user","tentrego2020");
			return $con;
		}
	}