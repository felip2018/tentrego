<?php
	require_once "../../../controlador/con_marcas.php";
	require_once "../../../modelo/mod_marcas.php";
?>
<div class="col-12 alert alert-info">
	<table>
		<tr>
			<td>
				<h4>Marcas</h4>
			</td>
			<td>
				<button style="float: right;" title="Registrar Usuario" class="btn btn-success" onclick="nueva_marca()"><i class="fa fa-plus"></i> Registrar marca</button>
			</td>
		</tr>
	</table>
</div>
<div class="col-12">
	<div class="row" id="lista_usuarios">
		<?php
			$categorias = new MarcasCon();
			$categorias -> listaMarcasCon();
		?>
	</div>
</div>