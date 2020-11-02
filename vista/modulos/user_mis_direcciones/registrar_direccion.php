<?php
	require_once "../../../controlador/user_con_mis_direcciones.php";
	require_once "../../../modelo/user_mod_mis_direcciones.php";

	$mis_direcciones = new MisDireccionesCon();

?>
<form id="form_registro_direccion">
	<input type="hidden" name="action" value="registrarDireccion">
	<input type="hidden" name="email" id="email" value="">
	<b>Dirección</b>
	<input type="text" class="form-control" name="direccion" id="direccion" data-name="Drección">
	<b>Barrio</b>
	<input type="text" class="form-control" name="barrio" id="barrio" data-name="Barrio">
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
	</select>
	<b>Indicaciones </b>(Opcional)
	<textarea name="indicaciones" id="indicaciones" class="form-control" rows="5"></textarea>
	<b>Teléfono / Celular</b>
	<input type="text" class="form-control" name="telefono" id="telefono" data-name="Telefono / Celular">
	<hr>
	<div class="alert alert-danger alert_registro_direccion" style="display: none;"></div>
	<button type="button" class="btn btn-primary btn-block" onclick="salvar_direccion('registrarDireccion')">
		<i class="fa fa-save"></i> Salvar dirección
	</button>
</form>