<?php
	require_once "../../../controlador/adm_con_marcas.php";
	require_once "../../../modelo/adm_mod_marcas.php";

	$id_marca 	= $_POST['id_marca'];

	$marca 		= new MarcasCon();
	$info 		= $marca -> infoMarcaCon($id_marca);

?>
<div class="row">
	<div class="col-xs-12 col-md-12">
		<button class="btn btn-danger" style="float: right;" onclick="$('#panel_animado').css('display','none');">
			<i class="fa fa-close"></i> Cerrar
		</button>
	</div>
	<div class="col-xs-12 col-md-12">
		<caption>Editar información de Marca</caption>
		<form id="form_registro_marca">
	
			<input type="hidden" name="id_marca" value="<?php echo $id_marca;?>">

			<table style="width: 100%;" >
				
				<tbody>
					<tr>
						<td>
							<p>Nombre de marca</p>
							<input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $info['nombre'];?>">
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
										<img id="previsualizar" src="vista/modulos/marcas/logos/<?php echo $info['logo'];?>" alt="Previsualizacion" width="100px" height="100px">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<hr>
		<button class="btn btn-primary btn-block" onclick="salvar_marca('2')">
			<i class="fa fa-save"></i> Salvar Marca
		</button>
		<br>
		<div class="alert alert-warning" id="alert_registro" style="display: none;"></div>
	</div>
</div>