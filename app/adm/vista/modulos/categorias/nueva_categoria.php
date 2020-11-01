<div class="row">
	<div class="col-xs-12 col-md-12">
		<button class="btn btn-danger" style="float: right;" onclick="$('#panel_animado').css('display','none');">
			<i class="fa fa-close"></i> Cerrar
		</button>
	</div>
	<div class="col-xs-12 col-md-12">
		<caption>Registrar una nueva categoria en el sistema</caption>
		<form id="form_registro_categoria">
			<table style="width: 100%;" >
				<tbody>
					<tr>
						<td>
							<p>Nombres</p>
							<input class="form-control" type="text" name="nombre" id="nombre">
						</td>
					</tr>
					<tr>
						<td>
							<p>Descripción</p>
							<textarea class="form-control" name="descripcion" id="descripcion" rows="5"></textarea>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<div class="alert alert-warning" id="alert_registro" style="display: none;"></div>
		<hr>
		<button class="btn btn-primary btn-block" onclick="salvar_categoria('1')">
			<i class="fa fa-save"></i> Salvar Categoria
		</button>
		
	</div>
</div>