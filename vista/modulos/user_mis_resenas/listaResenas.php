<?php
	setlocale(LC_TIME, 'spanish');
	require_once "../../../controlador/con_mis_resenas.php";
	require_once "../../../modelo/mod_mis_resenas.php";

	if (isset($_POST['email'])) 
	{
		$email = $_POST['email'];

		$mis_resenas = new MisResenasCon();
		$resenas = $mis_resenas -> listaResenasCon($email);

?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Id</th><th>Producto</th><th>Fecha</th><th>Calificacion</th><th>Estado</th><th></th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($resenas as $resena) 
					{
						$fecha = strftime("%A, %d de %B del %Y", strtotime($resena['fecha']));
						if ($resena['estado'] == "Activo") {
							$colorEstado = "#27ae60";
						}else if ($resena['estado'] == "Inactivo") {
							$colorEstado = "#c0392b";
						}
				?>
						<tr>
							<td><?php echo $resena['id_resena'];?></td>
							<td><?php echo $resena['nombre_producto'];?></td>
							<td><?php echo $fecha;?></td>
							<td>
								<?php
									for ($i=0; $i < $resena['calificacion']; $i++) 
									{ 
										echo '<i class="fa fa-star" style="color:gold;"></i>';
									}
								?>
							</td>
							<td style="background: <?php echo $colorEstado;?>;color:#FFF;"><?php echo $resena['estado'];?></td>
							<td>
								<button type="button" class="btn btn-secondary" onclick="verResena('<?php echo $resena['id_resena'];?>')">
									<i class="fa fa-search"></i> Ver
								</button>
								<?php
									if ($resena['estado'] == "Activo") 
									{
								?>
										<button type="button" class="btn btn-danger" onclick="estado_resena('Inactivo','<?php echo $resena['id_resena'];?>')">
											<i class="fa fa-trash"></i> 
										</button>
								<?php
									}
									else if ($resena['estado'] == "Inactivo") 
									{
								?>
										<button type="button" class="btn btn-success" onclick="estado_resena('Activo','<?php echo $resena['id_resena'];?>')">
											<i class="fa fa-check"></i>
										</button>
								<?php
									}
								?>
							</td>
						</tr>
				<?php
					}
				?>
			</tbody>
		</table>
<?php

	}
	else
	{
		echo "Vista no disponible!";
	}
?>