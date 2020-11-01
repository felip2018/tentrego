<?php 
	$id_categoria 	= $_POST['id_categoria'];
	$categoria 		= str_replace('_', ' ', $_POST['categoria']);
?>
<div class="row">
	<div class="col-xs-12 col-md-12">
		<button class="btn btn-danger" style="float: right;" onclick="$('#panel_animado').css('display','none');">
			<i class="fa fa-close"></i> Cerrar
		</button>
	</div>
	<div class="col-xs-12 col-md-12">
		<caption>Registrar una nueva clasificación en el sistema</caption>
		<form id="form_registro_clasificacion">
			<input type="hidden" name="id_categoria" id="id_categoria" value="<?php echo $id_categoria;?>">
			<table style="width: 100%;" >
				<tbody>
					<tr>
						<td>
							<p>Categoria</p>
							<input class="form-control" type="text" name="categoria" id="categoria" value="<?php echo $categoria;?>" readonly>
						</td>
					</tr>
					<tr>
						<td>
							<p>Nueva clasificación</p>
							<input class="form-control" type="text" name="nombre" id="nombre">
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<div class="alert alert-warning" id="alert_registro" style="display: none;"></div>
		<hr>
		<button class="btn btn-primary btn-block" onclick="salvar_clasificacion('4')">
			<i class="fa fa-save"></i> Salvar Clasificación
		</button>
		
	</div>
</div>