<?php
	require_once "../../../controlador/con_categorias.php";
	require_once "../../../modelo/mod_categorias.php";
?>
<div class="col-12 alert alert-info">
	<table>
		<tr>
			<td>
				<h4>Categorias</h4>
			</td>
			<td>
				<button style="float: right;" title="Registrar Usuario" class="btn btn-success" onclick="nueva_categoria()"><i class="fa fa-plus"></i> Registrar categoria</button>
			</td>
		</tr>
	</table>
</div>
<div class="col-12">
	<div class="row" id="lista_usuarios">
		<?php
			$categorias = new CategoriasCon();
			$categorias -> listaCategoriasCon();
		?>
	</div>
</div>