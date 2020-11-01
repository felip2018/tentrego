<div class="row">
	<div class="col-xs-12 col-md-12">
		<button class="btn btn-danger" style="float: right;" onclick="$('#panel_animado').css('display','none');">
			<i class="fa fa-close"></i> Cerrar
		</button>
	</div>
	<div class="col-xs-12 col-md-12">
		<caption>Registrar una nuevo atributo en el sistema</caption>
		<form id="form_registro_atributo">
			<table style="width: 100%;" >
				<tbody>
					<tr>
						<td>
							<p>Nombre de atributo</p>
							<input class="form-control" type="text" name="nombre" id="nombre">
						</td>
					</tr>
					<tr>
						<td>
							<p>Descripción</p>
							<textarea class="form-control" rows="5" name="descripcion" id="descripcion"></textarea>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<div class="alert alert-warning" id="alert_registro" style="display: none;"></div>
		<hr>
		<button class="btn btn-primary btn-block" onclick="salvar_atributo('1')">
			<i class="fa fa-save"></i> Salvar Atributo
		</button>
		
	</div>
</div>