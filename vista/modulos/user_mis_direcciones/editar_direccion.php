<?php
	require_once "../../../controlador/user_con_mis_direcciones.php";
	require_once "../../../modelo/user_mod_mis_direcciones.php";

	$id_direccion = $_POST['id_direccion'];

	$mis_direcciones = new MisDireccionesCon();
	$info = $mis_direcciones -> infoDireccionCon($id_direccion);
?>
<script type="text/javascript">
	$("#id_dpto").val('<?php echo $info['id_dpto'];?>');
	$("#id_ciudad").val('<?php echo $info['id_ciudad'];?>');
</script>
<form id="form_registro_direccion">
	<input type="hidden" name="action" value="actualizarDireccion">
	<input type="hidden" name="email" id="email" value="">
	<input type="hidden" name="id_direccion" value="<?php echo $id_direccion;?>">
	<b>Dirección</b>
	<input type="text" class="form-control" name="direccion" id="direccion" data-name="Drección" value="<?php echo $info['direccion'];?>">
	<b>Barrio</b>
	<input type="text" class="form-control" name="barrio" id="barrio" data-name="Barrio" value="<?php echo $info['barrio'];?>">
	<b>Departamento</b>
	<select class="form-control" name="id_dpto" id="id_dpto" onchange="buscarCiudades()" data-name="Departamento">
		<option value="">-Seleccione</option>
		<?php
			$listaDptos = $mis_direcciones->listaDptosCon();
			foreach ($listaDptos as $dpto) 
			{
		?>
				<option value="<?php echo $dpto['id_dpto'];?>"><?php echo $dpto['nombre'];?></option>
		<?php
			}
		?>
	</select>
	<b>Ciudad</b>
	<select class="form-control" name="id_ciudad" id="id_ciudad" data-name="Ciudad">
		<option value="">-Seleccione</option>
		<?php
			$listaCiudades = $mis_direcciones->listadoCiudadesCon($info['id_dpto']);
			foreach ($listaCiudades as $ciudad) 
			{
		?>
				<option value="<?php echo $ciudad['id_ciudad'];?>"><?php echo $ciudad['nombre'];?></option>
		<?php
			}
		?>
	</select>
	<b>Indicaciones </b>(Opcional)
	<textarea name="indicaciones" id="indicaciones" class="form-control" rows="5"><?php echo $info['indicaciones'];?></textarea>
	<b>Teléfono / Celular</b>
	<input type="text" class="form-control" name="telefono" id="telefono" data-name="Telefono / Celular" value="<?php echo $info['telefono'];?>">
	<hr>
	<div class="alert alert-danger alert_registro_direccion" style="display: none;"></div>
	<button type="button" class="btn btn-primary btn-block" onclick="salvar_direccion('actualizarDireccion')">
		<i class="fa fa-save"></i> Actualizar dirección
	</button>
</form>