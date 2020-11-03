<?php
	/**
	* CONTROLADOR DE TIENDA
	*/
	class TiendaCon
	{
		#	SOLICITAR EL LISTADO DE CATEGORIAS DE PRODUCTOS
		public function listaCategoriasCon($type)
		{
			$respuesta = TiendaMod::listaCategoriasMod();
			
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
			$respuesta = TiendaMod::listaClasificacionMod($id_categoria);
			print $respuesta;
		}

		#	SOLICITAR LISTADO DE CLASIFICACION
		public function listadoClasificacionCon($id_categoria)
		{
			$respuesta = TiendaMod::listadoClasificacionMod($id_categoria);
			//print_r($respuesta);
			foreach ($respuesta as $key) 
			{
				echo "<option value='".$key['id_clasificacion']."'>".$key['nombre']."</option>";
			}
		}

		#	SOLICITAR EL LISTADO DE MARCAS DE PRODUCTOS
		public function listaMarcasCon($type)
		{
			$respuesta = TiendaMod::listaMarcasMod();
			
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
			$respuesta = TiendaMod::listaUnidadesMod();
			foreach ($respuesta as $unidades) 
			{
				?>
					<option value="<?php echo $unidades['id_unidad'];?>"><?php echo $unidades['nombre']." | ".$unidades['descripcion'];?></option>
				<?php
			}
		}

		

		#	CONSULTAR TODO EL LISTADO DE PRODUCTOS REGISTRADOS
		public function listaProductosCon()
		{
			$respuesta = TiendaMod::listaProductosMod();
			foreach ($respuesta as $producto) 
			{
				$id_producto 		= $producto['id_producto'];
				$imagen 			= (empty($producto['imagen'])) ? "sin_imagen.png" : $producto['imagen'];
				$nombre_producto 	= str_replace(' ', '_', $producto['nombre']);
				$venta 				= $producto['venta'];
				?>
					<div class="col-xs-12 col-md-3">
						<div class="contenedor_producto">
							<img class="card-img-top" src="vista/img/productos/<?php echo $imagen;?>" alt="<?php echo $producto['nombre'];?>" width="100%" height="auto">
						  	<div class="card-body text-left">
						    	<h5 class="card-title"><?php echo $producto['nombre'];?></h5>
						    	<!--<b><?php //echo "$".number_format($producto['venta']);?></b>-->
						    	<p class="card-text">
						    		<?php
						    			if ($producto['estado_promocion'] == null) 
						    			{
						    				echo "<b>$".number_format($producto['venta'])."</b>";
						    				$venta 	= $producto['venta'];
						    			}
						    			else
						    			{
						    				echo "<b>Dcto ".$producto['descuento']."%</b><br>";
						    				echo "<s>$".number_format($producto['venta'])."</s> <b>$".number_format($producto['promocion'])."</b>";
						    				$venta 	= $producto['promocion'];
						    			}
						    		?>
						    	</p>
						  	</div>
							<button class="btn btn-primary" type="button" onclick="info_producto('<?php echo $id_producto;?>')">
								<i class="fa fa-eye"></i> Ver
							</button>

						  	<button class="btn btn-success" onclick="agregar_al_carrito('<?php echo $id_producto;?>','<?php echo $nombre_producto;?>','<?php echo $venta;?>','<?php echo $imagen;?>')">
						  		<i class="fa fa-shopping-cart"></i> Agregar al carrito
						  	</button>
					  	</div>
					</div>
				<?php
			}
		}

		#	SOLICITAR INFORMACION REGISTRADA DE UN PRODUCTO SELECCIONADO
		public function infoProductoCon($id_producto)
		{
			$respuesta = TiendaMod::infoProductoMod($id_producto);
			return $respuesta;
		}

		#	SOLICITAR LISTA DE PRODUCTOS POR CATEGORIA SELECCIONADA
		public function filtroProductosCon($id_categoria)
		{
			$respuesta = TiendaMod::filtroTiendaMod($id_categoria);
			print $respuesta;
		}

		#	SOLICITAR LISTA DE PRODUCTOS POR CATEGORIA Y CLASIFICACION SELECCIONADA
		public function filtroProductosClasificacionCon($id_categoria,$id_clasificacion)
		{
			$respuesta = TiendaMod::filtroProductosClasificacionMod($id_categoria,$id_clasificacion);
			print $respuesta;
		}
	}
?>