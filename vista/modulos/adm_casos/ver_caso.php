<?php
	require_once "../../../controlador/adm_con_casos.php";
	require_once "../../../modelo/adm_mod_casos.php";
	setlocale(LC_TIME, 'spanish');
	$id_caso = $_POST['id_caso'];

	$caso = new CasosCon();

	$info = $caso -> infoCasoCon($id_caso);
	$trazabilidad = $caso -> trazabilidadCasoCon($id_caso); 

	$foto_usuario = ($info['foto'] == '') ? 'sin_imagen.png' : $info['foto'];
	$imagen = ($info['imagen'] == '') ? 'sin_imagen.png' : $info['imagen'];

	if ($info['motivo'] == "garantia") {
		$back_motivo = "#ff9f43";
	}else{
		$back_motivo = "#ee5253";
	}

	if ($info['estado'] == "Activo") {
		$back_estado = "#00d2d3";
	}elseif ($info['estado'] == "En proceso") {
		$back_estado = "#54a0ff";
	}elseif ($info['estado'] == "Finalizado") {
		$back_estado = "#1dd1a1";
	}

	$fecha = strftime("%d de %B del %Y", strtotime($info['fecha']));
?>
<div class="col-12">
	<button class="btn btn-primary" onclick="loadPage('casos')">
		<i class="fa fa-chevron-left"></i> Volver
	</button>
</div>
<div class="col-12">
	<h4 class="alert alert-info">
		Detalle de caso #<?php echo $id_caso;?>
	</h4>	
</div>
<div class="col-xs-12 col-md-5">
	<h4 class="alert alert-success">Información del cliente</h4>
	<div style="text-align: center;">
		<img src="vista/modulos/usuarios/fotos/<?php echo $foto_usuario;?>" alt="Foto de usuario" style="width:50%;height: auto;">
	</div>
	<table class="table">
		<tr>
			<td>Cliente</td><td><b><?php echo $info['cliente'];?></b></td>
		</tr>
		<tr>
			<td>E-mail</td><td><b><?php echo $info['email'];?></b></td>
		</tr>
		<tr>
			<td>Teléfono</td><td><b><?php echo $info['telefono'];?></b></td>
		</tr>
		<tr>
			<td>Dirección</td><td><b><?php echo $info['direccion'];?></b></td>
		</tr>
	</table>
	<h5 class="alert alert-warning">Actualizar estado del caso</h5>
	<table class="table">
		<tr>
			<td>Estado</td>
			<td>
				<select class="form-control" name="estado" id="estado">
					<option value="">-Seleccione estado</option>
					<option value="En proceso">En proceso</option>
					<option value="Finalizado">Finalizado</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Descripción</td>
			<td>
				<textarea class="form-control" name="descripcion" id="descripcion" rows="5"></textarea>
			</td>
		</tr>
	</table>
	<div class="alert alert-warning alert_estado" style="display: none;"></div>
	<button type="button" class="btn btn-primary btn-block" onclick="agregar_proceso('<?php echo $id_caso;?>','<?php echo $info['cliente'];?>','<?php echo $info['email'];?>')">
		<i class="fa fa-save"></i> Actualizar estado
	</button>
</div>
<div class="col-xs-12 col-md-7">
	<h4 class="alert alert-success">Información del caso</h4>
	<div style="text-align: center;">
		<img src="vista/modulos/productos/imagenes/<?php echo $imagen;?>" alt="Imagen de producto" style="width:50%;height: auto;">
	</div>
	<table class="table">
		<tr>
			<td>Referencia de pedido</td><td><b><?php echo $info['codigo_pedido'];?></b></td>
		</tr>
		<tr>
			<td>Producto</td><td><b><?php echo $info['producto'];?></b></td>
		</tr>
		<tr>
			<td>Caso</td><td style="background: <?php echo $back_motivo;?>"><b><?php echo $info['motivo'];?></b></td>
		</tr>
		<tr>
			<td>Estado</td><td style="background: <?php echo $back_estado;?>"><b><?php echo $info['estado'];?></b></td>
		</tr>
		<tr>
			<td>Fecha</td><td><b><?php echo $fecha;?></b></td>
		</tr>
		<tr>
			<td>Descripción</td><td><b><?php echo $info['descripcion'];?></b></td>
		</tr>
	</table>

	<?php
		if (!empty($trazabilidad)) 
		{
	?>
			<h4 class="alert alert-success">Trazabilidad</h4>		
	<?php
			foreach ($trazabilidad as $proceso) 
			{
				$fecha_proceso = strftime("%d de %B del %Y a las %r", strtotime($proceso['fecha']));
	?>
				Estado: <b><?php echo $proceso['estado'];?></b> / Fecha: <b><?php echo $fecha_proceso;?></b><br>
				<p>
					"<?php echo $proceso['descripcion'];?>"
				</p>
				<hr>
	<?php
			}
		}
	?>
</div>