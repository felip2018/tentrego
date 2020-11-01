<?php
	
	require_once "conexion.php";
	require_once "mod_emails.php";
	/**
	* CLASE DEL MODELO DEL LOGIN
	*/
	class LoginMod extends Conexion
	{
		#	VALIDACION DE USUARIO
		public static function validacionMod($datosMod,$usuarios)
		{
			//VALIDAR SI EL USUARIO INGRESADO ESTA REGISTRADO EN LA DB
			$existe = Conexion::conectar()->prepare("SELECT COUNT(*) cant FROM usuarios WHERE email = :login");
			$existe -> bindParam(":login", $datosMod['login'], PDO::PARAM_STR);
			$existe -> execute();
			$val = $existe -> fetch();
			//return "resultado => ".$val['cant'];
			if ($val['cant'] != 0) 
			{
			 	# 	EL USUARIO ESTA EN EL SISTEMA
			 	$consulta = Conexion::conectar()->prepare("SELECT  
				usuarios.id_tipo_identi,
				usuarios.num_identi,
				CONCAT(usuarios.nombre,' ',usuarios.apellido) AS nombre,
				usuarios.email,
				usuarios.telefono,
				usuarios.id_perfil,
				usuarios.clave,
				usuarios.foto,
				usuarios.fecha_usuario,
				usuarios.estado,
				perfil.nombre perfil
				FROM usuarios 
				INNER JOIN perfil 	ON perfil.id_perfil = usuarios.id_perfil
				WHERE 	usuarios.email 		= :login 
				AND 	usuarios.clave 		= :clave
				AND 	usuarios.estado 	= :estado");

				$consulta->bindParam(":login", $datosMod["login"],	PDO::PARAM_STR);
				$consulta->bindParam(":clave", $datosMod["clave"],	PDO::PARAM_STR);
				$consulta->bindParam(":estado",$datosMod["estado"], PDO::PARAM_STR);
				
				if($consulta->execute())
				{
					$resultado = $consulta -> fetch(PDO::FETCH_ASSOC);
					return $resultado;
				}
				else
				{
					return $consulta->errorInfo();
				} 
			}
			else
			{
				#	EL USUARIO INGRESADO NO SE ENCUENTRA REGISTRADO
				return "sin_registro";
			}

			
		}

		#	ACTUALIZAR NUMERO DE INTENTOS DE INICIO DE SESION
		public static function actualizarIntentosMod($type,$login)
		{

			switch ($type) 
			{
				case 1:
					# INCREMENTAR NUMERO DE INTENTOS
					//SELECCIONAMOS EL NUMERO DE INTENTOS HASTA EL MOMENTO
					$select = Conexion::conectar()->prepare("SELECT intentos FROM usuarios WHERE email = :login");
					$select -> bindParam(":login",	$login,	PDO::PARAM_STR);
					$select -> execute();
					$intentos = $select -> fetch(PDO::FETCH_ASSOC);

					if ($intentos['intentos'] < 3) 
					{
						# INCREMENTAMOS EL NUMERO DE INTENTOS
						$update = Conexion::conectar()->prepare("UPDATE usuarios SET intentos = intentos + 1 WHERE email = :login");
						$update -> bindParam(":login",	$login,	PDO::PARAM_STR);
						if($update -> execute())
						{
							return "Actualizado";
						}
					}
					else
					{
						# SE HA SOBREPASADO EL NUMERO DE INTENTOS
						$update = Conexion::conectar()->prepare("UPDATE usuarios SET estado = 'Bloqueado' WHERE email = :login");
						$update -> bindParam(":login",	$login,	PDO::PARAM_STR);
						if($update -> execute())
						{
							return "Bloqueado";
						}
					}
					break;
				
				case 2:
					# RESET NUMERO DE INTENTOS Y CONECTAR SESION
					$update = Conexion::conectar()->prepare("UPDATE usuarios SET intentos = 0, sesion = 'Conectado' WHERE email = :login");
					$update -> bindParam(":login",	$login,	PDO::PARAM_STR);
					if($update -> execute())
					{
						return "Reiniciado";
					}

					break;
			}

		}

		#	NOTIFICAR AL PROPIETARIO DE LA CUENTA SOBRE EL BLOQUEO POR VIOLACION DE SEGURIDAD
		public static function notificarBloqueoMod($email)
		{
			# NOTIFICACION DE BLOQUEO DE CUENTA AL TITULAR
			$info 	= LoginMod::infoCuentaMod($email);
			$codigo = LoginMod::cambioClaveMod($email);

			$nombre 	= $info['nombre']; 
			$asunto 	= "Bloqueo de Cuenta";
			$plantilla 	= "bloqueoCuenta";
			$link_cambio_clave = "https://www.clickstore.co/app/cambio_clave.php?email=" . $email . "&codigo_validacion=" . $codigo;

			$parametros = json_encode(array("nombre" 			=> $nombre,
											"link_cambio_clave" => $link_cambio_clave));

			$bloqueo = Email::programarCorreo($email,$nombre,$asunto,$plantilla,$parametros);

			return $bloqueo;
		}

		#	CONSULTAR INFORMACION DE LA CUENTA QUE ESTA SIENDO ATACADA
		public static function infoCuentaMod($email)
		{
			$consulta = Conexion::conectar()->prepare("SELECT 
														CONCAT(nombre,' ',apellido) AS nombre 
														FROM 	usuarios
														WHERE 	email 	= :email");

			$consulta -> bindParam(":email", $email, PDO::PARAM_STR);
			$consulta -> execute();
			$info = $consulta -> fetch(PDO::FETCH_ASSOC);
			return $info;
		}

		#	GENERAR EL CASO PARA EL CAMBIO DE CLAVE
		public static function cambioClaveMod($email)
		{
			$codigo = LoginMod::generateRandomString(10);
			
			$desde = date('Y-m-j');
			$nuevaFecha = strtotime ( '+2 day' , strtotime ( $desde ) ) ;
			$hasta = date ( 'Y-m-j' , $nuevaFecha );

			$estado = "Activo";
			

			$insert = Conexion::conectar()->prepare("INSERT INTO cambio_clave(id_cambio, email, codigo, desde, hasta, estado) VALUES (null, :email, :codigo, :desde, :hasta, :estado)");

			$insert -> bindParam(":email", 	$email, 	PDO::PARAM_STR);
			$insert -> bindParam(":codigo", $codigo, 	PDO::PARAM_STR);
			$insert -> bindParam(":desde", 	$desde, 	PDO::PARAM_STR);
			$insert -> bindParam(":hasta", 	$hasta, 	PDO::PARAM_STR);
			$insert -> bindParam(":estado", $estado, 	PDO::PARAM_STR);

			$insert -> execute();

			return $codigo;

		}

		#	GENERAR CODIGO DE VALIDACION DE CUENTA
		public static function generateRandomString($length) 
		{
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $charactersLength = strlen($characters);
		    $randomString = '';
		    
		    for ($i = 0; $i < $length; $i++) 
		    {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }

		    return $randomString;
		}
	}