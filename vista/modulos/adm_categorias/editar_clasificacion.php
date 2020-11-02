<?php
	$id_clasificacion 	= $_POST['id_clasificacion'];
	$clasificacion 		= str_replace('_', ' ', $_POST['clasificacion']);

?>
<div class="row">
	<div class="col-xs-12 col-md-12">
		<button class="btn btn-danger" style="float: right;" onclick="$('#panel_animado').css('display','none');">
			<i class="fa fa-close"></i> Cerrar
		</button>
	</div>
	<div class="col-xs-12 col-md-12">
		<caption>Editar información de Clasificación</caption>
		<form id="form_registro_clasificacion">
	
			<input type="hidden" name="id_clasificacion" value="<?php echo $id_clasificacion;?>">

			<table style="width: 100%;">
				<tbody>
					<tr>
						<td>
							<p>Nombres</p>
							<input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $clasificacion;?>">
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<hr>
		<button class="btn btn-primary btn-block" onclick="salvar_clasificacion('5')">
			<i class="fa fa-save"></i> Salvar Clasificación
		</button>
		<br>
		<div class="alert alert-warning" id="alert_registro" style="display: none;"></div>
	</div>
</div>