<?php
	/**
	* MODELO DEL CARRITO DE COMPRAS
	*/
	class CarritoMod
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
					//print_r($this->array_origen);
					//print_r($this->array_recomendacion);
					$sub_total = ($this->array_cantidad_productos[$i] * $this->array_precio_productos[$i]);
					# IMPRIMIR LOS PRODUCTOS
					$producto = str_replace('_', ' ', $this->array_nombre_productos[$i]);
					$imagen = $this->array_imagenes_productos[$i];
				?>
							<div class="row p-2" style="border:1px solid #DDD;">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<table style="width: 100%;">
										<tr>
											<td style="width: 20%;">
												<img src="app/adm/vista/modulos/productos/imagenes/<?php echo $imagen;?>" alt="Producto" style="width: 100px;height: 100px;">
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

				<button class="btn btn-success btn-block" onclick="validar_sesion()">
					<b>Procesar Pedido</b>
				</button>
			</div>
		<?php
			
		}

		//	VACIAR CARRITO DE COMPRAS
		public function vaciar_carrito()
		{
			$this->cant_productos = 0;
		   	$this->array_id_productos 		= [];
		   	$this->array_nombre_productos 	= [];
		   	$this->array_cantidad_productos = [];
		   	$this->array_precio_productos 	= [];
		   	$this->array_estado_productos 	= [];
		   	$this->suma_total = 0;
		   	$this->envio = 10000;
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