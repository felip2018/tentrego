<?php
	require_once "conexion.php";
	/**
	* MODELO DE CONFIRMACION DE LA TRANSACCION
	*/
	class ConfirmationMod extends Conexion
	{
		
		#	CONFIRMACION DE PAGO DE LA TRANSACCION
		public static function confirmacionPedidoMod($datosConfirmacion)
		{
			$state_pol 			= $datosConfirmacion['state_pol'];
			$response_code_pol 	= $datosConfirmacion['response_code_pol'];
			$reference_sale 	= $datosConfirmacion['reference_sale'];
			$reference_pol 		= $datosConfirmacion['reference_pol'];
			$transaction_id 	= $datosConfirmacion['transaction_id'];

			switch ($state_pol) 
			{
				case 4:
					# APROBADA
					$estado = "pagado";
					break;
				
				case 6:
					# DECLINADA
					$estado = "pago declinado";
					break;
			}

			#	CONSULTAMOS LA INFORMACION DEL PEDIDO
			$consulta = Conexion::conectar()->prepare("SELECT * 
														FROM 	pedido 
														WHERE 	codigo_pedido 	= :reference_sale
														AND 	referencePol 	= :reference_pol
														AND 	transactionId 	= :transaction_id");

			$consulta -> bindParam(":reference_sale", 	$reference_sale, 	PDO::PARAM_STR);
			$consulta -> bindParam(":reference_pol", 	$reference_pol, 	PDO::PARAM_STR);
			$consulta -> bindParam(":transaction_id", 	$transaction_id, 	PDO::PARAM_STR);

			$consulta -> execute();

			$pedido = $consulta -> fetch(PDO::FETCH_ASSOC);


			$update = Conexion::conectar()->prepare("	UPDATE 	pedido
														SET 	estado 			= :estado
														WHERE	id_pedido 		= :id_pedido
														AND	 	codigo_pedido	= :codigo_pedido");

			$update -> bindParam(":estado",			$estado,					PDO::PARAM_STR);
			$update -> bindParam(":id_pedido",		$pedido['id_pedido'],		PDO::PARAM_INT);
			$update -> bindParam(":codigo_pedido",	$pedido['codigo_pedido'],	PDO::PARAM_STR);

			if ($update -> execute()) 
			{
				# ACTUALIZAMOS EL DETALLE DEL PEDIDO
				$update_detalle = Conexion::conectar()->prepare("	UPDATE 	pedido_detalle
																	SET 	estado 		= :estado
																	WHERE	id_pedido	= :id_pedido");

				$update_detalle -> bindParam(":estado", 	$estado, 				PDO::PARAM_STR);
				$update_detalle -> bindParam(":id_pedido", 	$pedido['id_pedido'], 	PDO::PARAM_INT);

				$update_detalle -> execute();

			}

		}
	}