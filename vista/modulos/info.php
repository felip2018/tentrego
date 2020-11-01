<?php
	require_once "controlador/con_info.php";
	require_once "modelo/mod_info.php";

	if (isset($_GET['productId'])) 
	{
		$info = new InfoCon();
		$producto = $info -> infoProductoCon($_GET['productId']);
		$imagenes = $info -> imagenesProductoCon($_GET['productId']);
		
		$id_producto 		= $producto['id_producto'];
		$imagen 			= (empty($producto['imagen'])) ? "sin_imagen.png" : $producto['imagen'];
		$nombre_producto 	= str_replace(' ', '_', $producto['nombre']);
		$venta 				= $producto['venta'];

		
?>
		<div class="col-xs-12 col-md-12">
			<div class="row contenedor_producto p-5">
				<div class="col-xs-12 col-md-6 text-left">
					
					<h5><?php echo $producto['nombre'];?></h5>
					<p>
						<b>Categoria: </b><?php echo $producto['categoria'];?> | <b>Clasificación: </b><?php echo $producto['clasificacion'];?>
					</p>
					<!--<b>Precio: </b>
					<h4 style="color:red;"><?php //echo "$".number_format($producto['venta']);?></h4>-->
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
					<button class="btn btn-success" onclick="info_agregar_al_carrito('<?php echo $id_producto;?>','<?php echo $nombre_producto;?>','<?php echo $venta;?>','<?php echo $imagen;?>')">
				  		<i class="fa fa-shopping-cart"></i> Agregar al carrito
				  	</button>
				  	<hr>
					<img class="card-img-top view_img" src="./app/adm/vista/modulos/productos/imagenes/<?php echo $producto['imagen'];?>" alt="<?php echo $producto['nombre'];?>">

					<?php
						if (!empty($imagenes)) 
						{
					?>
							<div class="imagenes_mini" style="width: 100%;/*border: 1px solid red;*/ height: auto;padding: 10px;overflow-x: scroll;">
								<?php
									foreach ($imagenes as $imagen) 
									{
								?>
										<img src="./app/adm/vista/modulos/productos/imagenes/<?php echo $imagen['imagen'];?>" alt="<?php echo $imagen['imagen'];?>" width="150px" height="150px" onclick="ver_imagen('<?php echo $imagen['imagen'];?>')">
								<?php
									}
								?>
							</div>
					<?php
						}
					?>

				</div>
				<div class="col-xs-12 col-md-6 text-left">
					
					<?php
						#	CONSULTAMOS LOS ATRIBUTOS DEL PRODUCTO
						$atributos = $info -> listaAtributosCon($producto['id_producto']);
						foreach ($atributos as $value) 
						{
					?>
							<h5><b><?php echo $value['nombre'];?></b></h5>
							<p>
								<?php echo $value['valor'];?>
							</p>
					<?php
						}
						#	VISUALIZAMOS LA DESCRIPCION DEL PRODUCTO SI LA TIENE
						if ($producto['descripcion'] != '') 
						{
					?>
							<h5><b>DESCRIPCIÓN</b></h5>
							<p>
								<?php echo $producto['descripcion'];?>
							</p>
					<?php
						}

						#	VISUALIZAMOS LAS RESEÑAS DEL PRODUCTO SI LAS TIENE
						$resenas = $info -> listaResenasCon($producto['id_producto']);

						if (sizeof($resenas) > 0) 
						{
					?>
							<h5><b>RESEÑAS DEL PRODUCTO</b></h5>
							<hr>
					<?php
							foreach ($resenas as $value) 
							{
					?>
								<b><?php echo $value['usuario'];?></b> | <b>Fecha: </b><?php echo $value['fecha'];?><br>
								<b>Calificación:</b>
								<?php
									for ($i=0; $i < $value['calificacion']; $i++) 
									{ 
								?>
										<i class="fa fa-star" style="color:gold;"></i>
								<?php
									}
								?>
								<p>
									<?php echo $value['comentarios'];?>
								</p>
								<hr>
					<?php
							}
						}

					?>
				

				</div>
			</div>
		</div>
<?php
	}
	else
	{
?>
<div class="col-xs-12 col-md-12">
	<h4>Error 404</h4>
	<p>Lo sentimos no se ha encontrado la pagina indicada en el sistema.</p>
</div>
<?php
	}
?>