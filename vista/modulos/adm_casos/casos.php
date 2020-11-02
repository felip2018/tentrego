<?php
	require_once "../../../controlador/adm_con_casos.php";
	require_once "../../../modelo/adm_mod_casos.php";
	setlocale(LC_TIME, 'spanish');
	$casos = new CasosCon();

?>
<div class="col-12">
	<h4 class="alert alert-info">
		Devoluciónes y Garantías
	</h4>	
</div>
<div class="col-xs-12 col-md-12">
	
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Id</th><th>Referencia pedido</th><th>Producto</th><th>Tipo de caso</th><th>Fecha</th><th>Estado</th><th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$listado = $casos -> casosProductosCon();
				if (!empty($listado)) 
				{
					foreach ($listado as $caso) 
					{
						if ($caso['motivo'] == "garantia") {
							$back_motivo = "#ff9f43";
						}else{
							$back_motivo = "#ee5253";
						}

						if ($caso['estado'] == "Activo") {
							$back_estado = "#00d2d3";
						}elseif ($caso['estado'] == "En proceso") {
							$back_estado = "#54a0ff";
						}elseif ($caso['estado'] == "Finalizado") {
							$back_estado = "#1dd1a1";
						}

						$fecha = strftime("%d de %B del %Y", strtotime($caso['fecha']));
			?>
						<tr>
							<td><?php echo $caso['id_caso'];?></td>
							<td><?php echo $caso['codigo_pedido'];?></td>
							<td><?php echo $caso['nombre'];?></td>
							<td style="background: <?php echo $back_motivo;?>;"><?php echo $caso['motivo'];?></td>
							<td><?php echo $fecha;?></td>
							<td style="background: <?php echo $back_estado;?>;"><?php echo $caso['estado'];?></td>
							<td>
								<button type="button" class="btn btn-primary" onclick="ver_caso('<?php echo $caso['id_caso'];?>')">
									<i class="fa fa-search"></i> Ver caso
								</button>
							</td>
						</tr>
			<?php
					}
				}
				else
				{
					# NO HAY CASOS REGISTRADOS
			?>
					<tr>
						<td>--</td><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td>
					</tr>
			<?php
				}
			?>
		</tbody>
	</table>
	
</div>