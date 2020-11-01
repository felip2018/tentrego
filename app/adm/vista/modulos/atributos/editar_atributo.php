<?php
	require_once "../../../controlador/con_atributos.php";
	require_once "../../../modelo/mod_atributos.php";

	$id_atributo 	= $_POST['id_atributo'];

	$marca 		= new AtributosCon();
	$info 		= $marca -> infoAtributoCon($id_atributo);

?>
<div class="row">
	<div class="col-xs-12 col-md-12">
		<button class="btn btn-danger" style="float: right;" onclick="$('#panel_animado').css('display','none');">
			<i class="fa fa-close"></i> Cerrar
		</button>
	</div>
	<div class="col-xs-12 col-md-12">
		<caption>Editar información de Marca</caption>
		<form id="form_registro_atributo">
	
			<input type="hidden" name="id_atributo" value="<?php echo $id_atributo;?>">

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
							<p>Descripción</p>
							<textarea class="form-control" rows="5" name="descripcion" id="descripcion"><?php echo $info['descripcion'];?></textarea>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<hr>
		<button class="btn btn-primary btn-block" onclick="salvar_atributo('2')">
			<i class="fa fa-save"></i> Salvar Atributo
		</button>
		<br>
		<div class="alert alert-warning" id="alert_registro" style="display: none;"></div>
	</div>
</div>