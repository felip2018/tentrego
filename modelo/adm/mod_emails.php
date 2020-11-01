<?php
	require_once "conexion.php";
	require_once "PHPMailer/class.phpmailer.php";
	require_once "PHPMailer/class.smtp.php";
	require_once "PHPMailer/PHPMailerAutoload.php";

	/**
	* MODELO DE PROGRAMACION DE EMAILS
	*/
	class Email extends Conexion
	{
		
		#	PROGRAMAR CORREOS EN LA BASE DE DATOS
		public static function programarCorreo($email,$nombre,$asunto,$plantilla,$parametros)
		{
			$estado 		= 0;
			$fecha_registro	= date('Y-m-d H:i:s');
			$fecha_envio 	= "0000-00-00 00:00:00";

			$insert = Conexion::conectar()->prepare("INSERT INTO emails(id, email, nombre, asunto, plantilla, parametros, estado, fecha_registro, fecha_envio) VALUES (null, :email, :nombre, :asunto, :plantilla, :parametros, :estado, :fecha_registro, :fecha_envio)");

			$insert -> bindParam(":email", 		$email, 	PDO::PARAM_STR);
			$insert -> bindParam(":nombre", 	$nombre, 	PDO::PARAM_STR);
			$insert -> bindParam(":asunto", 	$asunto, 	PDO::PARAM_STR);
			$insert -> bindParam(":plantilla", 	$plantilla, PDO::PARAM_STR);
			$insert -> bindParam(":parametros", $parametros,PDO::PARAM_STR);
			$insert -> bindParam(":estado", 	$estado, 	PDO::PARAM_STR);
			$insert -> bindParam(":fecha_registro", $fecha_registro, PDO::PARAM_STR);
			$insert -> bindParam(":fecha_envio",$fecha_envio,PDO::PARAM_STR);

			if ($insert -> execute()) {
				return true;
			}else{
				return false;
			}

		}

		#	CONSULTAR CORREOS PARA ENVIAR
		public static function buscarCorreos()
		{
			$consulta = Conexion::conectar()->prepare("	SELECT COUNT(*) cant 
														FROM emails 
														WHERE estado = 0");
			$consulta -> execute();
			$cantidad = $consulta -> fetchAll(PDO::FETCH_ASSOC);

			if ($cantidad['cant'] > 0) 
			{
				#	CONSULTAMOS LA LISTA DE EMAILS PARA ENVIAR
				$consulta = Conexion::conectar()->prepare("	SELECT * 
															FROM emails 
															WHERE estado = 0
															LIMIT 10");
				$consulta -> execute();
				$emails = $consulta -> fetchAll(PDO::FETCH_ASSOC);

				foreach ($emails as $email) 
				{
					$envio = Email::enviarCorreos($email['email'],$email['nombre'],$email['asunto'],$email['plantilla'],$email['parametros']);

					if ($envio) 
					{
						# 	ACTUALIZAMOS EL REGISTRO DEL EMAIL A ENVIADO
						$update = Conexion::conectar()->prepare("UPDATE emails
																SET 	estado = 1
																WHERE 	id = :id");
						$update -> bindParam(":id", $email['id'], PDO::PARAM_INT);
						$update -> execute();
					}
				}

			}
		}

		#	ENVIAR CORREOS DE LA BASE DE DATOS
		public static function enviarCorreos($email,$nombre,$asunto,$plantilla,$parametros)
		{
			$mail = new PHPMailer();
		    $mail->IsSMTP();
		    //$mail->IsMail();
		    $mail->Host = 'smtp.gmail.com';
		    $mail->SMTPAuth = true;
		    $mail->Port = 465;
		    $mail->Username = 'mgarzonnaranjo@gmail.com';
		    $mail->Password = 'felipegarzon';
		    $mail->SMTPSecure = 'ssl';
		    $mail->IsHTML(true);
		    $mail->CharSet = 'UTF-8';

		    $mail->From = "Click Store";
		    $mail->AddReplyTo('admin@clickstore.co', 'Click Store');
		    $mail->FromName = "Click Store";
		    $mail->AddAddress( $email, $nombre );

		    $mail->Subject = $asunto;
		    
		    $message = file_get_contents('plantillas/' . $plantilla . '.php');

		    if ($parametros != "") 
		    {
		        $arr = json_decode($parametros, true);
		       
		        foreach ($arr as $key => $value) 
		        {
		            $message = preg_replace('({{'.$key.'}})', $value, $message);
		        }

		    }

		    $mail->MsgHTML( stripslashes( $message ) );
		    

		    if( !$mail->Send() )
		    {
		    	//	NO SE PUDO ENVIAR EL CORREO ELECTRONICO 
		      	return false;
		    }
		    else
		    {
		    	// 	CORREO ENVIADO CORRECTAMENTE
		        return true;
		    }
		}
	}