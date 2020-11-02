<?php
	require_once "../../../controlador/user_con_mis_direcciones.php";
	require_once "../../../modelo/user_mod_mis_direcciones.php";

	if (isset($_POST['email'])) 
	{
		$mis_direcciones = new MisDireccionesCon();
		$direcciones = $mis_direcciones -> listadoDireccionesCon($_POST['email']);

		//print_r($direcciones);

		if (!empty($direcciones)) 
		{

			foreach ($direcciones as $dir) 
			{
?>
				<div class="col-xs-12 col-md-4">
					<div class="alert alert-info">
						<p><b><?php echo $dir['direccion'];?></b></p>
						<p><?php echo $dir['barrio'].', '.$dir['ciudad'].', '.$dir['dpto'];?></p>
						<b>Telefono: </b><?php echo $dir['telefono'];?>
						<hr>
						<button type="button" class="btn btn-primary" onclick="editar_direccion('<?php echo $dir['id_direccion'];?>')">
							<i class="fa fa-edit"></i> Editar
						</button>
						<?php
							if ($dir['estado'] == "Activo") 
							{
						?>
								<button type="button" class="btn btn-danger" onclick="estado_direccion('Inactivo','<?php echo $dir['id_direccion'];?>')">
									<i class="fa fa-trash"></i> Eliminar
								</button>
						<?php
							}
							else
							{
						?>	
								<button type="button" class="btn btn-success" onclick="estado_direccion('Activo','<?php echo $dir['id_direccion'];?>')">
									<i class="fa fa-check"></i> Activar
								</button>
						<?php
							}
						?>
					</div>
				</div>
<?php
			}
		}
		else
		{
?>
			<div class="col-12 alert alert-danger">
				No hay direcciones registradas
			</div>
<?php
		}
	}
	else
	{
		echo "Vista no disponible";
	}
?>