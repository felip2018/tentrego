<?php
	require_once "conexion.php";
	/**
	* MODELO DE RESPUESTA DE TRANSACCION
	*/
	class ResponseMod extends Conexion
	{
		
		#	ACTUALIZAR PEDIDO CON LOS DATOS DE LA TRANSACCION
		public static function actualizarPedidoMod($datosTransaccion)
		{
			$transactionState 		= $datosTransaccion['transactionState'];
			$lapTransactionState 	= $datosTransaccion['lapTransactionState'];
			$message 				= $datosTransaccion['message'];

			//	CODIGO DE REFERENCIA DEL PEDIDO
			$referenceCode 			= $datosTransaccion['referenceCode'];

			$polTransactionState	= $datosTransaccion['polTransactionState'];
			$polResponseCode 		= $datosTransaccion['polResponseCode'];
			$lapResponseCode 		= $datosTransaccion['lapResponseCode'];
			$reference_pol 			= $datosTransaccion['reference_pol'];
			$transactionId 			= $datosTransaccion['transactionId'];
			$polPaymentMethod 		= $datosTransaccion['polPaymentMethod'];
			$lapPaymentMethod 		= $datosTransaccion['lapPaymentMethod'];
			$polPaymentMethodType 	= $datosTransaccion['polPaymentMethodType'];
			$lapPaymentMethodType 	= $datosTransaccion['lapPaymentMethodType'];

			//	CONSULTAMOS EL ESTADO DEL PEDIDO
			$consulta = Conexion::conectar()->prepare("SELECT * FROM pedido WHERE codigo_pedido = :referenceCode");
			$consulta -> bindParam(":referenceCode", $referenceCode, PDO::PARAM_STR);
			$consulta -> execute();

			$pedido = $consulta -> fetch(PDO::FETCH_ASSOC);

			if ($pedido['estado'] == "por pagar") 
			{
				# PROCEDEMOS A ACTUALIZAR EL PEDIDO CON LOS DATOS DE LA TRANSACCION Y A ACTUALIZAR SU ESTADO DE ACUERDO AL ESTADO DE LA TRANSACCION
				if ($transactionState == 4 || $transactionState == 7) 
				{
					
					switch ($transactionState) 
					{
						case 4:
							# APROBADA
							$estado = "pago";
							break;
						
						case 7:
							# PENDIENTE
							$estado = "pendiente";
							break;
					}

					$update = Conexion::conectar()->prepare("UPDATE pedido
																SET transactionState 			= :transactionState,
																	lapTransactionState			= :lapTransactionState,
																	message						= :message,
																	polTransactionState 		= :polTransactionState,
																	polResponseCode 			= :polResponseCode,
																	lapResponseCode 			= :lapResponseCode,
																	referencePol				= :reference_pol,
																	transactionId 				= :transactionId,
																	polPaymentMethod 			= :polPaymentMethod,
																	lapPaymentMethod			= :lapPaymentMethod,
																	polPaymentMethodType 		= :polPaymentMethodType,
																	lapPaymentMethodType 		= :lapPaymentMethodType,
																	estado 						= :estado
																WHERE 	id_pedido 				= :id_pedido
																AND 	codigo_pedido 			= :codigo_pedido");

					$update -> bindParam(":transactionState", 		$transactionState, 		PDO::PARAM_INT);
					$update -> bindParam(":lapTransactionState", 	$lapTransactionState, 	PDO::PARAM_STR);
					$update -> bindParam(":message", 				$message, 				PDO::PARAM_STR);
					$update -> bindParam(":polTransactionState", 	$polTransactionState, 	PDO::PARAM_INT);
					$update -> bindParam(":polResponseCode", 		$polResponseCode, 		PDO::PARAM_INT);
					$update -> bindParam(":lapResponseCode", 		$lapResponseCode, 		PDO::PARAM_STR);
					$update -> bindParam(":reference_pol", 			$reference_pol, 		PDO::PARAM_INT);
					$update -> bindParam(":transactionId", 			$transactionId, 		PDO::PARAM_STR);
					$update -> bindParam(":polPaymentMethod", 		$polPaymentMethod, 		PDO::PARAM_INT);
					$update -> bindParam(":lapPaymentMethod", 		$lapPaymentMethod, 		PDO::PARAM_STR);
					$update -> bindParam(":polPaymentMethodType", 	$polPaymentMethodType, 	PDO::PARAM_INT);
					$update -> bindParam(":lapPaymentMethodType", 	$lapPaymentMethodType, 	PDO::PARAM_STR);
					$update -> bindParam(":estado", 				$estado, 				PDO::PARAM_STR);
					$update -> bindParam(":id_pedido", 				$pedido['id_pedido'], 	PDO::PARAM_INT);
					$update -> bindParam(":codigo_pedido", 			$pedido['codigo_pedido'],PDO::PARAM_STR);

					if ($update -> execute()) 
					{
						# ACTUALIZAMOS EL DETALLE DEL PEDIDO
						$update_detalle = Conexion::conectar()->prepare("	UPDATE 	pedido_detalle
																			SET		estado 		= :estado
																			WHERE 	id_pedido	= :id_pedido");

						$update_detalle -> bindParam(":estado",		$estado, 	PDO::PARAM_STR);
						$update_detalle -> bindParam(":id_pedido",	$pedido['id_pedido'], PDO::PARAM_INT);

						$update_detalle -> execute();

					}

				}
			}

		}
	}