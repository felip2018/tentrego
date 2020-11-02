<?php
	require_once "../../../controlador/adm_con_atributos.php";
	require_once "../../../modelo/adm_mod_atributos.php";
?>
<div class="col-12 alert alert-info">
	<table>
		<tr>
			<td>
				<h4>Atributos</h4>
			</td>
			<td>
				<button style="float: right;" title="Registrar Usuario" class="btn btn-success" onclick="nuevo_atributo()"><i class="fa fa-plus"></i> Registrar atributo</button>
			</td>
		</tr>
	</table>
</div>
<div class="col-12">
	<div class="row">
		<?php
			$categorias = new AtributosCon();
			$categorias -> listaAtributosCon();
		?>
	</div>
</div>