<?php
	require_once "../../../controlador/adm_con_promociones.php";
	require_once "../../../modelo/adm_mod_promociones.php";

	$promociones = new PromocionesCon();

?>
<div class="col-12 alert alert-info">
	<table>
		<tr>
			<td>
				<h4>Promociones</h4>
			</td>
			<td>
				
			</td>
		</tr>
	</table>
</div>
<div class="col-12" id="contenido_productos">
	<div class="row">
		<div class="col-12">
			<div class="row view_products">
			<?php
				$listado = $promociones -> listaPromocionesCon();
				if (!empty($listado)) 
				{
					# 	MOSTRAR LISTA DE PROMOCIONES
					foreach ($listado as $promo) 
					{
						$imagen = (empty($promo['imagen'])) ? "sin_imagen.png" : $promo['imagen'];
				?>
					<div class="col-xs-12 col-md-3">
						<div class="contenedor_producto">
							<div class="card-body">
						    	<h5 class="card-title"><?php echo $promo['nombre'];?></h5>
						    	<p class="card-text">
						    		<?php
						    			if ($promo['estado_promocion'] == null) 
						    			{
						    				echo "<b>$".number_format($promo['venta'])."</b>";
						    			}
						    			else
						    			{
						    				echo "<b>Dcto ".$promo['descuento']."%</b><br>";
						    				echo "<s>$".number_format($promo['venta'])."</s> <b>$".number_format($promo['promocion'])."</b>";
						    			}
						    		?>
						    	</p>
						  	</div>
						  	<img class="card-img-top" src="vista/modulos/productos/imagenes/<?php echo $imagen;?>" alt="<?php echo $promo['nombre'];?>" width="100%" height="auto">
						  	<table>
								<tr>
									<td>
										<?php
											if ($promo['estado_promocion'] == "Activo") 
											{
										?>
												<button type="button" class="btn btn-danger btn-block" onclick="estado_promocion('Inactivo','<?php echo $promo['id_promocion'];?>')"><i class="fa fa-trash-alt"></i> Inactivar promoción</button>
										<?php
											}
											else
											{
										?>
												<button type="button" class="btn btn-success btn-block" onclick="estado_promocion('Activo','<?php echo $promo['id_promocion'];?>')"><i class="fa fa-check"></i> Activar promoción</button>
										<?php
											}
										?>
									</td>
								</tr>
							</table>
						</div>
					</div>
			<?php
					}
				}
				else
				{
					#	NO HAY PROMOCIONES PARA MOSTRAR
			?>
					<div class="col-12 alert alert-warning">
						No hay promociones registradas.
					</div>
			<?php
				}
			?>
			</div>
		</div>
	</div>
</div>