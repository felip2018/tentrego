<?php
	require_once "conexion.php";
	require_once "mod_emails.php";
	/**
	* MODELO DEL CARRITO DE COMPRAS
	*/
	class CarritoMod extends Conexion
	{
		public $cant_productos;
	   	public $array_id_productos 			= array();
	   	public $array_nombre_productos 		= array();
	   	public $array_cantidad_productos 	= array();
	   	public $array_precio_productos 		= array();
	   	public $array_imagenes_productos 	= array();
	   	public $array_origen		 		= array();
	   	public $array_recomendacion 		= array();
	   	public $array_estado_productos 		= array();
	   	public $suma_total;
	   	public $envio 						= 10000;


		public function agregarProductoMod($datosProducto)
		{
			$id_producto = $datosProducto['id_producto'];
			$nombre 	 = $datosProducto['nombre'];
			$cantidad 	 = $datosProducto['cantidad'];
			$venta 		 = $datosProducto['venta'];
			$imagen 	 = $datosProducto['imagen'];
			$origen 	 = $datosProducto['origen'];
			$recomienda  = $datosProducto['recomienda'];
			$estado 	 = $datosProducto['estado'];

			// 	EVALUAR SI EL PRODUCTO YA ESTA EN EL CARRITO
			if (in_array($id_producto, $this->array_id_productos)) 
			{
				// 	EXTRAEMOS EL INDICE PARA AUMENTAR LA CANTIDAD DEL PRODUCTO
				while ($valor = current($this->array_id_productos)) 
				{
				    if ($valor == $id_producto) 
				    {
				        $index = key($this->array_id_productos); 
				    }
				    next($this->array_id_productos);
				}
				
				// 	CONSULTAMOS EL ESTADO DEL PRODUCTO CON EL INDICE ENCONTRADO
				if ($this->array_estado_productos[$index] == 'Activo') 
				{
					//	AUMENTAMOS LA CANTIDAD DEL PRODUCTO
					$this->array_cantidad_productos[$index]++;	
				}
				else
				{
					// 	ACTUALIZAMOS EL ESTADO DEL REGISTRO Y COLOCAMOS 1 UNIDAD DEL PRODUCTO
					$this->array_estado_productos[$index] = 'Activo';
					$this->array_cantidad_productos[$index] = 1;
				}
				
			}
			else
			{
			
				//AGREGAR EL ID DEL PRODUCTO AL ARREGLO: $array_id_producto
				$this->array_id_productos[$this->cant_productos] = $id_producto;
				//AGREGAR EL NOMBRE DEL PRODUCTO AL ARREGLO: $array_nombre_productos
				$this->array_nombre_productos[$this->cant_productos] = $nombre;
				//AGREGAR LA CANTIDAD DEL PRODUCTO AL ARREGLO: $array_cantidad_productos
				$this->array_cantidad_productos[$this->cant_productos] = $cantidad;
				//AGREGAR EL PRECIO DEL PRODUCTO AL ARREGLO: $array_precio_producto
				$this->array_precio_productos[$this->cant_productos] = $venta;
				//AGREGAR LA IMAGEN DEL PRODUCTO AL ARREGLO: $array_imagenes_producto
				$this->array_imagenes_productos[$this->cant_productos] = $imagen;
				//AGREGAR EL ORIGEN DEL PRODUCTO: WEB O RECOMENDACION: $array_origen
				$this->array_origen[$this->cant_productos] = $origen;
				//AGREGAR LA IDENTIFICACION DE RECOMENDACION DEL PRODUCTO: web o usuario que comparte contenido
				$this->array_recomendacion[$this->cant_productos] = $recomienda;
				//AGREGAR EL ESTADO DEL PRODUCTO AL ARREGLO: $array_precio_producto
				$this->array_estado_productos[$this->cant_productos] = $estado;
				//INCREMENTAMOS EL NUMERO DE PRODUCTOS EN EL CARRITO
				$this->cant_productos++;
			}

			$respuesta = json_encode(array("estado" => "agregado"));
			return $respuesta;

		}

		//	ELIMINAR PRODUCTO DEL CARRITO DE COMPRA
		public function eliminarProductoMod($indice)
		{
			$this->array_estado_productos[$indice] = 'Inactivo';
			$respuesta = json_encode(array("estado" => "eliminado"));
			return $respuesta;
		}

		//	ACTUALIZAR CANTIDAD DE PRODUCTO SELECCIONADO
		public function cantidadProductoMod($indice,$cantidad)
		{
			$this->array_cantidad_productos[$indice] = $cantidad;
			$respuesta = json_encode(array("estado" => "actualizado"));
			return $respuesta;
		}

		//	VER PRODUCTOS REGISTRADOS EN LE CARRITO DE COMPRAS
		public function verCarritoMod()
		{
			$this->suma_total = 0;
			$sub_total 	= 0;
		?>
			<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
		<?php
			for ($i=0; $i < $this->cant_productos; $i++) 
			{ 
				if ($this->array_estado_productos[$i] == "Activo") 
				{
					$sub_total = ($this->array_cantidad_productos[$i] * $this->array_precio_productos[$i]);
					# IMPRIMIR LOS PRODUCTOS
					$producto = str_replace('_', ' ', $this->array_nombre_productos[$i]);
					$imagen = $this->array_imagenes_productos[$i];
					//print_r($this->array_origen);
					//print_r($this->array_recomendacion);
				?>
							<div class="row p-2" style="border:1px solid #DDD;">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<table style="width: 100%;">
										<tr>
											<td style="width: 20%;">
												<img src="vista/img/productos/<?php echo $imagen;?>" alt="Producto" style="width: 100px;height: 100px;">
											</td>
											<td style="width: 80%;">
												<table style="width: 100%;">
													<tr>
														<td style="text-align: left;">
															<h5><?php echo $producto;?></h5>			
														</td>
													</tr>
													<tr>
														<td>
															<table>
																<tr>
																	<td style="width: 10%;">
																		<b>Valor Unitario</b><br>
																		<h5>$ <?php echo number_format($this->array_precio_productos[$i]);?></h5>
																	</td>										
																	<td style="width: 10%;">
																		<b>Cantidad</b><br>
																		<input type="number" min="1" id="cantidad" value="<?php echo $this->array_cantidad_productos[$i];?>" onchange="cambiar_valor('<?php echo $i;?>',this.value)" style="width: 50px;">
																	</td>
																	<td style="width: 10%;">
																		<b>Sub Total</b><br>
																		<h5>$ <?php echo number_format($this->array_precio_productos[$i]*$this->array_cantidad_productos[$i]);?></h5>
																	</td>
																	<td style="width: 10%;">
																		<button class="btn btn-danger" onclick="eliminar_producto('<?php echo $i;?>')"><i class="fa fa-times"></i></button>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>										
										</tr>
									</table>									
								</div>
							</div>
			<?php
					$this->suma_total = $this->suma_total + $sub_total;
				}
					
			}

			?>
			<hr>
				<div class="row">
					<p>Agrega las observaciones sobre tu pedido, como las características deseadas de tus producto de compra y demás.</p>
					<textarea class="form-control" rows="5" name="observaciones" id="observaciones"></textarea>
				</div>
			</div>	
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 p-2" style="border:1px solid #CCC;">
				<h5 class="titulo">RESUMEN DE TU PEDIDO</h5>
				<table style="width: 100%;">
					<tr>
						<td>
							<label class="texto">Subtotal</label>
						</td>
						<td>
							<h5 style="float:right;color:red;">$ <?php echo number_format($this->suma_total);?></h5>
						</td>
					</tr>
					<tr>
						<td>
							<label class="texto">Pagos</label>
						</td>
						<td>
							<h5 style="float:right;color: red;">1</h5>
						</td>
					</tr>
					<tr>
						<td>
							<label class="texto">Total</label>
						</td>
						<td>
							<h5 style="float:right;color:red;">$ <?php echo number_format($this->suma_total);?></h5>
						</td>
					</tr>
				</table>

				<button class="btn btn-success btn-block" onclick="realizar_pedido()">
					<b>Realizar Pedido</b>
				</button>

			</div>
		<?php
			
		}

		//	VACIAR CARRITO DE COMPRAS
		public function vaciarCarritoMod()
		{
			$this->cant_productos = 0;
		   	$this->array_id_productos 		= [];
		   	$this->array_nombre_productos 	= [];
		   	$this->array_cantidad_productos = [];
		   	$this->array_precio_productos 	= [];
		   	$this->array_estado_productos 	= [];
		   	$this->suma_total = 0;
		   	$this->envio = 10000;

		   	return 1;

		}


		//	REALIZAR PEDIDO PARA EL USUARIO EN SESION
		public function realizarPedidoMod($email,$observaciones)
		{
			#	CONSULTAMOS SI HAY PEDIDOS PENDIENTES POR PAGAR PARA ESTE USUARIO Y SI SU INFORMACION BASICA ESTA REGISTRADA
			$consulta = Conexion::conectar()->prepare("	SELECT 
						(SELECT num_identi FROM usuarios WHERE email = :email) num_identi,
						(SELECT telefono FROM usuarios WHERE email = :email) telefono,
						(SELECT direccion FROM usuarios WHERE email = :email) direccion,
						(SELECT COUNT(*) FROM pedido WHERE email = :email AND estado IN ('por pagar','pendiente','contra entrega')) pendientes
						FROM DUAL");

			$consulta -> bindParam(":email",	$email,	PDO::PARAM_STR);
			$consulta -> execute();
			$info = $consulta->fetch(PDO::FETCH_ASSOC);

			$errores = array();

			if ($info['pendientes'] == 0) 
			{
				#	EVALUAMOS SI LA INFORMACION BASICA ESTA COMPLETA PARA PODER REALIZAR EL PEDIDO: cedula, telefono y direccion.

				if ($info['num_identi'] == 0 || $info['num_identi'] == "") {
					array_push($errores, "num_identi");
				}

				if ($info['telefono'] == "") {
					array_push($errores, "telefono");
				}

				if ($info['direccion'] == "") {
					array_push($errores, "direccion");
				}

				if (empty($errores)) 
				{
					# 	SE PUEDE REALIZAR EL PEDIDOS YA QUE NO TIENE PAGOS PENDIENTES Y SU INFORMACION BASICA ESTA REGISTRADA

					#	CONSULTAMOS EL CONSECUTIVO DEL PEDIDO
					$consulta = Conexion::conectar()->prepare("SELECT MAX(id_pedido) id_pedido
																FROM pedido");
					$consulta->execute();
					$consecutivo = $consulta->fetch(PDO::FETCH_ASSOC);

					$id_pedido 		= ($consecutivo['id_pedido'] == null) ? 1 : $consecutivo['id_pedido'] + 1;
					$total 			= $this->suma_total;
					$codigo_pedido 	= CarritoMod::generateRandomString(10);
					$fecha 			= date('Y-m-d H:i:s');
					$estado 		= "por pagar";

					$transactionState 		= 0;
					$lapTransactionState 	= "";
					$message 				= "";
					$polTransactionState	= 0;
					$polResponseCode 		= 0;
					$lapResponseCode		= "";
					$referencePol	 		= 0;
					$transactionId 			= "";
					$polPaymentMethod 		= 0;
					$lapPaymentMethod 		= "";
					$polPaymentMethodType 	= 0;
					$lapPaymentMethodType 	= "";

					$insert = Conexion::conectar()->prepare("INSERT INTO pedido(id_pedido, email, total, codigo_pedido, transactionState, lapTransactionState, message, polTransactionState, polResponseCode, lapResponseCode, referencePol, transactionId, polPaymentMethod, lapPaymentMethod, polPaymentMethodType, lapPaymentMethodType, observaciones, fecha, estado) VALUES (:id_pedido, :email, :total, :codigo_pedido, :transactionState, :lapTransactionState, :message, :polTransactionState, :polResponseCode, :lapResponseCode, :referencePol, :transactionId, :polPaymentMethod, :lapPaymentMethod, :polPaymentMethodType, :lapPaymentMethodType, :observaciones, :fecha, :estado)");

					$insert -> bindParam(":id_pedido", 			$id_pedido, 			PDO::PARAM_INT);
					$insert -> bindParam(":email", 				$email, 				PDO::PARAM_STR);
					$insert -> bindParam(":total", 				$total, 				PDO::PARAM_INT);
					$insert -> bindParam(":codigo_pedido", 		$codigo_pedido, 		PDO::PARAM_STR);
					$insert -> bindParam(":transactionState", 	$transactionState, 		PDO::PARAM_STR);
					$insert -> bindParam(":lapTransactionState",$lapTransactionState, 	PDO::PARAM_STR);
					$insert -> bindParam(":message", 			$message, 				PDO::PARAM_STR);
					$insert -> bindParam(":polTransactionState",$polTransactionState, 	PDO::PARAM_STR);
					$insert -> bindParam(":polResponseCode", 	$polResponseCode, 		PDO::PARAM_STR);
					$insert -> bindParam(":lapResponseCode", 	$lapResponseCode, 		PDO::PARAM_STR);
					$insert -> bindParam(":referencePol", 		$referencePol, 			PDO::PARAM_STR);
					$insert -> bindParam(":transactionId", 		$transactionId, 		PDO::PARAM_STR);
					$insert -> bindParam(":polPaymentMethod", 	$polPaymentMethod, 		PDO::PARAM_STR);
					$insert -> bindParam(":lapPaymentMethod", 	$lapPaymentMethod, 		PDO::PARAM_STR);
					$insert -> bindParam(":polPaymentMethodType",$polPaymentMethodType,PDO::PARAM_STR);
					$insert -> bindParam(":lapPaymentMethodType",$lapPaymentMethodType,PDO::PARAM_STR);
					$insert -> bindParam(":observaciones", 		$observaciones, 		PDO::PARAM_STR);
					$insert -> bindParam(":fecha", 				$fecha, 				PDO::PARAM_STR);
					$insert -> bindParam(":estado", 			$estado, 				PDO::PARAM_STR);

					if ($insert -> execute()) 
					{
						#	SE HA REGISTRADO EL MAESTRO DEL PEDIDO CORRECTAMENTE, AHORA REGISTRAMOS EL DETALLE DEL PEDIDO.
						$errores = array();

						for ($i=0; $i < $this->cant_productos; $i++) 
						{ 
							if ($this->array_estado_productos[$i] == "Activo") 
							{
								$sub_total = ($this->array_cantidad_productos[$i] * $this->array_precio_productos[$i]);
								
								#	CONSECUTIVO DE DETALLE
								$consulta = Conexion::conectar()->prepare("SELECT 	MAX(id_pdetalle) id_pdetalle
																			FROM 	pedido_detalle
																			WHERE 	id_pedido 	= :id_pedido");
								
								$consulta -> bindParam(":id_pedido",$id_pedido,	PDO::PARAM_INT);
								$consulta -> execute();
								$consecutivo = $consulta -> fetch(PDO::FETCH_ASSOC);
								
								$id_pdetalle = ($consecutivo['id_pdetalle'] == null) ? 1 : $consecutivo['id_pdetalle'] + 1;

								$id_producto 	= $this->array_id_productos[$i];
								$valor_unitario = $this->array_precio_productos[$i];
								$cantidad 		= $this->array_cantidad_productos[$i];
								$valor_total    = ($valor_unitario * $cantidad);

								if ($this->array_recomendacion[$i] == $email) {
									$origen     	= "Web";
									$recomienda    	= "";
								}else{
									$origen     	= $this->array_origen[$i];
									$recomienda    	= $this->array_recomendacion[$i];
								}

								$insert = Conexion::conectar()->prepare("INSERT INTO pedido_detalle(id_pdetalle, id_pedido, id_producto, valor_unitario, cantidad, valor_total, origen, recomienda, fecha, estado) VALUES (:id_pdetalle, :id_pedido, :id_producto, :valor_unitario, :cantidad, :valor_total, :origen, :recomienda, :fecha, :estado)");

								$insert -> bindParam(":id_pdetalle", 	$id_pdetalle, 	PDO::PARAM_INT);
								$insert -> bindParam(":id_pedido", 		$id_pedido, 	PDO::PARAM_INT);
								$insert -> bindParam(":id_producto", 	$id_producto, 	PDO::PARAM_INT);
								$insert -> bindParam(":valor_unitario", $valor_unitario,PDO::PARAM_INT);
								$insert -> bindParam(":cantidad", 		$cantidad, 		PDO::PARAM_INT);
								$insert -> bindParam(":valor_total", 	$valor_total, 	PDO::PARAM_INT);
								$insert -> bindParam(":origen", 		$origen, 		PDO::PARAM_STR);
								$insert -> bindParam(":recomienda", 	$recomienda, 	PDO::PARAM_STR);
								$insert -> bindParam(":fecha", 			$fecha, 		PDO::PARAM_STR);
								$insert -> bindParam(":estado", 		$estado, 		PDO::PARAM_STR);

								if(!$insert -> execute())
								{
									array_push($errores, $insert->errorInfo());
								}
								
							}
								
						}

						if (empty($errores)) 
						{
							#	NOTIFICACION DE PEDIDO AL ADMINISTRADOR
							$consulta = Conexion::conectar()->prepare("	SELECT 	
										(SELECT CONCAT(nombre,' ',apellido) FROM usuarios WHERE email = :email) nombre_usuario,
										(SELECT telefono FROM usuarios WHERE email = :email) telefono_usuario,
										(SELECT email FROM 	usuarios WHERE 	id_perfil = 1) email_admin
										FROM DUAL");
							
							$consulta -> bindParam(":email", $email, PDO::PARAM_STR);
							$consulta -> execute();
							
							$admin = $consulta -> fetch(PDO::FETCH_ASSOC);

							$asunto 	= "Nuevo pedido";
							$plantilla 	= "nuevoPedido";
							$parametros = json_encode(array("email_usuario" 	=> $email,
															"id_pedido"  		=> $id_pedido,
															"nombre_usuario" 	=> $admin['nombre_usuario'],
															"telefono_usuario" 	=> $admin['telefono_usuario'],
															"codigo_pedido"		=> $codigo_pedido));

							$notificacion = Email::programarCorreo($admin['email_admin'],"Administrador",$asunto,$plantilla,$parametros);

							$resultado = json_encode(array("estado" => "success"));
						}
						else
						{
							$resultado = json_encode(array("estado" => "error detalle", "data" => $errores));
						}						

					}
					else
					{
						#	ERROR AL INSERTAR EL MAESTRO DEL PEDIDO
						$resultado = json_encode(array("estado" => "error insert", "data" => $insert->errorInfo));
					}
				}
				else
				{
					#	ERROR, FALTA DILIGENCIAR INFORMACION BASICA
					$resultado = json_encode(array("estado" => "error de informacion", "data" => "No se puede realizar el pedido, por favor completa tu información de contacto en el panel de inicio para continuar con el proceso de pedidos."));
				}

				return $resultado;
			}
			else
			{
				#	EL USUARIO TIENE UN PAGO DE PEDIDO ANTERIOR PENDIENTE, NO PUEDE SOLICITAR OTRO PEDIDO HASTA QUE CANCELE EL ANTERIOR.
				$resultado = json_encode(array("estado" => "error de pago", "data" => "No es posible realizar el pedido por que el usuario tiene un pago pendiente de un pedido anterior."));

				return $resultado;

			}
		}


		// GENERAR RANDOM STRING
		public static function generateRandomString($length) 
		{
		    //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $charactersLength = strlen($characters);
		    $randomString = '';
		    
		    for ($i = 0; $i < $length; $i++) 
		    {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }

		    return $randomString;
		}

		//	CONTRUCTOR
		function __construct()
		{
			$this->cant_productos 	= 0;
			$this->envio 			= 10000;
			$this->suma_total 		= 0;
		}
	}
?>