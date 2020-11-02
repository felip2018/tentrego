<?php
	require_once "../../../controlador/adm_con_categorias.php";
	require_once "../../../modelo/adm_mod_categorias.php";

	$id_categoria 	= $_POST['id_categoria'];

	$categoria 		= new CategoriasCon();
	$info 			= $categoria -> infoCategoriaCon($id_categoria);

?>
<div class="row">
	<div class="col-xs-12 col-md-12">
		<button class="btn btn-danger" style="float: right;" onclick="$('#panel_animado').css('display','none');">
			<i class="fa fa-close"></i> Cerrar
		</button>
	</div>
	<div class="col-xs-12 col-md-12">
		<caption>Editar información de Categoria</caption>
		<form id="form_registro_categoria">
	
			<input type="hidden" name="id_categoria" value="<?php echo $id_categoria;?>">

			<table style="width: 100%;" >
				
				<tbody>
					<tr>
						<td>
							<p>Nombres</p>
							<input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $info['nombre'];?>">
						</td>
					</tr>
					<tr>
						<td>
							<p>Descripción</p>
							<textarea class="form-control" name="descripcion" id="descripcion" rows="5"><?php echo $info['descripcion'];?></textarea>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<hr>
		<button class="btn btn-primary btn-block" onclick="salvar_categoria('2')">
			<i class="fa fa-save"></i> Salvar Categoria
		</button>
		<br>
		<div class="alert alert-warning" id="alert_registro" style="display: none;"></div>
	</div>
</div>