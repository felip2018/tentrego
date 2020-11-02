<div class="row">
	<div class="col-xs-12 col-md-12">
		<button class="btn btn-danger" style="float: right;" onclick="$('#panel_animado').css('display','none');">
			<i class="fa fa-close"></i> Cerrar
		</button>
	</div>
	<div class="col-xs-12 col-md-12">
		<caption>Registrar una nueva marca en el sistema</caption>
		<form id="form_registro_marca">
			<table style="width: 100%;" >
				<tbody>
					<tr>
						<td>
							<p>Nombre de marca</p>
							<input class="form-control" type="text" name="nombre" id="nombre">
						</td>
					</tr>
					<tr>
						<td>
							<table>
								<tr>
									<td>
										<p>Imagen</p>
										<input class="form-control" type="file" name="imagen" id="imagen" data-name="Imagen">
									</td>
									<td>
										<img id="previsualizar" src="" alt="Previsualizacion" width="100px" height="100px">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<div class="alert alert-warning" id="alert_registro" style="display: none;"></div>
		<hr>
		<button class="btn btn-primary btn-block" onclick="salvar_marca('1')">
			<i class="fa fa-save"></i> Salvar Marca
		</button>
		
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		// 	PREVISUALIZACION DE IMAGEN
		$('#imagen').change(function(e) {
			//console.log(e);
		    addImage(e); 
		});

		function addImage(e){
		var file = e.target.files[0],
		imageType = /image.*/;

		if (!file.type.match(imageType))
		return;

		var reader = new FileReader();
		reader.onload = fileOnload;
		reader.readAsDataURL(file);
		}

		function fileOnload(e) {
		var result=e.target.result;
		$('#previsualizar').attr("src",result);
		}
	});
</script>