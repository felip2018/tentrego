<?php
	/**
	* CONTROLADOR DE PRODUCTOS
	*/
	class ProductosCon
	{
		#	SOLICITAR EL LISTADO DE CATEGORIAS DE PRODUCTOS
		public function listaCategoriasCon($type)
		{
			$respuesta = ProductosMod::listaCategoriasMod();
			
			switch ($type) 
			{
				case 'button':
					foreach ($respuesta as $categoria) 
					{
						?>
						<button type="button" class="btn btn-info btn-block" onclick="filtro_productos('<?php echo $categoria['id_categoria'];?>')"><?php echo $categoria['nombre'];?></button>
						<?php
					}
					break;
				
				case 'options':
					foreach ($respuesta as $categoria) 
					{
						?>
							<option value="<?php echo $categoria['id_categoria'];?>"><?php echo $categoria['nombre'];?></option>
						<?php
					}
					break;
				
				default:
					# code...
					break;
			}
			
		}

		#	SOLICITAR LISTA DE CLASIFICACION DE CATEGORIA SELECCIONADA
		public function listaClasificacionCon($id_categoria)
		{
			$respuesta = ProductosMod::listaClasificacionMod($id_categoria);
			print $respuesta;
		}

		#	SOLICITAR LISTADO DE CLASIFICACION
		public function listadoClasificacionCon($id_categoria)
		{
			$respuesta = ProductosMod::listadoClasificacionMod($id_categoria);
			//print_r($respuesta);
			foreach ($respuesta as $key) 
			{
				echo "<option value='".$key['id_clasificacion']."'>".$key['nombre']."</option>";
			}
		}

		#	SOLICITAR EL LISTADO DE MARCAS DE PRODUCTOS
		public function listaMarcasCon($type)
		{
			$respuesta = ProductosMod::listaMarcasMod();
			
			switch ($type) 
			{
				case 'button':
					foreach ($respuesta as $marca) 
					{
						?>
						<button type="button" class="btn btn-info btn-block"><?php echo $marca['nombre'];?></button>
						<?php
					}
					break;
				
				case 'options':
					foreach ($respuesta as $marca) 
					{
						?>
							<option value="<?php echo $marca['id_marca'];?>"><?php echo $marca['nombre'];?></option>
						<?php
					}
					break;
				
				default:
					# code...
					break;
			}
		}

		#	SOLICITAR EL LISTADO DE UNIDADES DE MEDIDA
		public function listaUnidadesCon()
		{
			$respuesta = ProductosMod::listaUnidadesMod();
			foreach ($respuesta as $unidades) 
			{
				?>
					<option value="<?php echo $unidades['id_unidad'];?>"><?php echo $unidades['nombre']." | ".$unidades['descripcion'];?></option>
				<?php
			}
		}

		#	SOLICITAR EL LISTADO DE ATRIBUTOS
		public function listaAtributosCon()
		{
			$respuesta = ProductosMod::listaAtributosMod();
			foreach ($respuesta as $atributo) 
			{
				?>
					<tr>
						<td style="text-align: center;">
							<input type="checkbox" name="atributos[]" value="<?php echo $atributo['id_atributo'];?>" style="width: 25px;height: 25px;">
						</td>
						<td>
							<b><?php echo $atributo['nombre'];?></b>
						</td>
						<td>
							<input class="form-control" type="text" name="<?php echo 'attr_'.$atributo['id_atributo'];?>" value="">
						</td>
					</tr>
				<?php
			}
		}

		#	SOLICITAR LISTADO DE ATRIBUTOS REGISTRADOS PARA EL PRODUCTO SELECCIONADO
		public function listaAtributosRegistradosCon($id_producto)
		{
			$respuesta = ProductosMod::listaAtributosRegistradosMod($id_producto);
			foreach ($respuesta as $atributo) 
			{
				?>
					<tr>
						<td style="text-align: center;">
							<input type="checkbox" name="atributos[]" value="<?php echo $atributo['id_atributo'];?>" style="width: 25px;height: 25px;" checked="true">
						</td>
						<td>
							<b><?php echo $atributo['nombre'];?></b>
						</td>
						<td>
							<input class="form-control" type="text" name="<?php echo 'attr_'.$atributo['id_atributo'];?>" value="<?php echo $atributo['valor'];?>">
						</td>
						<td>
							<button type="button" class="btn btn-danger" onclick="eliminar_atributo('<?php echo $atributo['id_atributo'];?>','<?php echo $id_producto;?>')">
								<i class="fa fa-times"></i>
							</button>
						</td>
					</tr>
				<?php
			}
		}

		#	SOLICITAR LISTA DE ATRIBUTOS SIN REGISTRAR EN EL PRODUCTO
		public function listaAtributosPendientesCon($id_producto)
		{
			$respuesta = ProductosMod::listaAtributosPendientesMod($id_producto);
			foreach ($respuesta as $atributo) 
			{
				?>
					<tr>
						<td style="text-align: center;">
							<input type="checkbox" name="atributos[]" value="<?php echo $atributo['id_atributo'];?>" style="width: 25px;height: 25px;">
						</td>
						<td>
							<b><?php echo $atributo['nombre'];?></b>
						</td>
						<td>
							<input class="form-control" type="text" name="<?php echo 'attr_'.$atributo['id_atributo'];?>" value="">
						</td>
					</tr>
				<?php
			}
		}

		#	SOLICITAR REGISTRO DE PRODUCTO EN EL SISTEMA
		public function registrarProductoCon($datosProducto)
		{
			$respuesta = ProductosMod::registrarProductoMod($datosProducto);
			print $respuesta;
			//print_r($respuesta);
		}

		#	CONSULTAR TODO EL LISTADO DE PRODUCTOS REGISTRADOS
		public function listaProductosCon()
		{
			$respuesta = ProductosMod::listaProductosMod();
			foreach ($respuesta as $producto) 
			{
				$imagen = (empty($producto['imagen'])) ? "sin_imagen.png" : $producto['imagen'];
				?>
					<div class="col-xs-12 col-md-3">
						<div class="contenedor_producto">
							<div class="card-body">
						    	<h5 class="card-title"><?php echo $producto['nombre'];?></h5>
						    	<p class="card-text">
						    		<?php
						    			if ($producto['estado_promocion'] == null) 
						    			{
						    				echo "<b>$".number_format($producto['venta'])."</b>";
						    			}
						    			else
						    			{
						    				echo "<b>Dcto ".$producto['descuento']."%</b><br>";
						    				echo "<s>$".number_format($producto['venta'])."</s> <b>$".number_format($producto['promocion'])."</b>";
						    			}
						    		?>
						    	</p>
						  	</div>
						  	<img class="card-img-top" src="vista/img/productos/<?php echo $imagen;?>" alt="<?php echo $producto['nombre'];?>" width="100%" height="auto">
						  	<table>
								<tr>
									<td>
										<button type="button" class="btn btn-primary float-left" onclick="editar_producto('<?php echo $producto['id_producto'];?>')"><i class="fa fa-edit"></i> Editar</button>			
									</td>
									<td>
										<?php
											if ($producto['estado'] == "Activo") 
											{
										?>
												<button type="button" class="btn btn-danger float-right" onclick="estado_producto('Inactivo','<?php echo $producto['id_producto'];?>')"><i class="fa fa-trash-alt"></i> Inactivar</button>
										<?php
											}
											else
											{
										?>
												<button type="button" class="btn btn-success float-right" onclick="estado_producto('Activo','<?php echo $producto['id_producto'];?>')"><i class="fa fa-check"></i> Activar</button>
										<?php
											}
										?>
									</td>
								</tr>
							</table>
							<button type="button" class="btn btn-success btn-block" onclick="promocion_producto('<?php echo $producto['id_producto'];?>','<?php echo $producto['venta'];?>','<?php echo $producto['nombre'];?>')">
								<i class="fa fa-bell"></i> Promoción
							</button>
						</div>
					</div>
				<?php
			}
		}

		#	SOLICITAR INFORMACION REGISTRADA DE UN PRODUCTO SELECCIONADO
		public function infoProductoCon($id_producto)
		{
			$respuesta = ProductosMod::infoProductoMod($id_producto);
			return $respuesta;
		}

		#	SOLICITAR ACTUALIZACION DE INFORMACION DE PRODUCTO
		public function actualizarProductoCon($datosProducto)
		{
			$respuesta = ProductosMod::actualizarProductoMod($datosProducto);
			print $respuesta;
		}

		#	SOLICITAR CAMBIO DE ESTADO DE PRODUCTO
		public function estadoProductoCon($datosProducto)
		{
			$respuesta = ProductosMod::estadoProductoMod($datosProducto);
			print $respuesta;
		}

		#	SOLICITAR LISTA DE PRODUCTOS POR CATEGORIA SELECCIONADA
		public function filtroProductosCon($id_categoria)
		{
			$respuesta = ProductosMod::filtroProductosMod($id_categoria);
			foreach ($respuesta as $producto) 
			{
				?>
					<div class="col-xs-12 col-md-3">
						<div class="contenedor_producto">
							<div class="card-body">
						    	<h5 class="card-title"><?php echo $producto['nombre'];?></h5>
						    	<p class="card-text">
						    		<?php
						    			if ($producto['estado_promocion'] == null) 
						    			{
						    				echo "<b>$".number_format($producto['venta'])."</b>";
						    			}
						    			else
						    			{
						    				echo "<b>Dcto ".$producto['descuento']."%</b><br>";
						    				echo "<s>$".number_format($producto['venta'])."</s> <b>$".number_format($producto['promocion'])."</b>";
						    			}
						    		?>
						    	</p>
						  	</div>
						  	<img class="card-img-top" src="vista/img/productos/<?php echo $producto['imagen'];?>" alt="<?php echo $producto['nombre'];?>" width="100%" height="auto">
						  	<table>
								<tr>
									<td>
										<button type="button" class="btn btn-primary float-left" onclick="editar_producto('<?php echo $producto['id_producto'];?>')"><i class="fa fa-edit"></i> Editar</button>			
									</td>
									<td>
										<?php
											if ($producto['estado'] == "Activo") 
											{
										?>
												<button type="button" class="btn btn-danger float-right" onclick="estado_producto('Inactivo','<?php echo $producto['id_producto'];?>')"><i class="fa fa-trash-alt"></i> Inactivar</button>
										<?php
											}
											else
											{
										?>
												<button type="button" class="btn btn-success float-right" onclick="estado_producto('Activo','<?php echo $producto['id_producto'];?>')"><i class="fa fa-check"></i> Activar</button>
										<?php
											}
										?>
									</td>
								</tr>
							</table>
							<button type="button" class="btn btn-success btn-block" onclick="promocion_producto('<?php echo $producto['id_producto'];?>','<?php echo $producto['venta'];?>','<?php echo $producto['nombre'];?>')">
								<i class="fa fa-bell"></i> Promoción
							</button>
						</div>
					</div>
				<?php
			}
		}

		#	SOLICITAR INACTIVACION DE ATRIBUTO DE UN PRODUCTO
		public function estadoAtributoCon($datosAtributo)
		{
			$respuesta = ProductosMod::estadoAtributoMod($datosAtributo);
			print $respuesta;
		}

		#	SOLICITAR LISTADO DE IMAGENES REGISTRADAS DEL PRODUCTO
		public function imagenesProductoCon($id_producto)
		{
			$respuesta = ProductosMod::imagenesProductoMod($id_producto);
			return $respuesta;
		}

		#	SOLICITAR CARGUE DE IMAGEN DE PRODUCTO
		public function subirImagenCon($id_producto)
		{
			$respuesta = ProductosMod::subirImagenMod($id_producto);
			print $respuesta;
		}

		#	SOLICITAR CAMBIO DE ESTADO DE IMAGEN
		public function estadoImagenCon($datosImagen)
		{
			$respuesta = ProductosMod::estadoImagenMod($datosImagen);
			print $respuesta;
		}

		#	SOLICITAR EL REGISTRO DE UNA NUEVA PROMOCION PARA UN PRODUCTO INDICADO
		public function crearPromocionCon($datosPromocion)
		{
			$respuesta = ProductosMod::crearPromocionMod($datosPromocion);
			print $respuesta;
		}
	}
?> 