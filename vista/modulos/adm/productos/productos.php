<?php
	require_once "../../../controlador/con_productos.php";
	require_once "../../../modelo/mod_productos.php";
?>
<div class="col-12 alert alert-info">
	<table>
		<tr>
			<td>
				<h4>Productos</h4>
			</td>
			<td>
				<button style="float: right;" title="Registrar Usuario" class="btn btn-success" onclick="nuevo_producto()"><i class="fa fa-plus"></i> Registrar producto</button>
			</td>
		</tr>
	</table>
</div>
<div class="col-12" id="contenido_productos">
	<div class="row">
		<div class="col-xs-12 col-md-2 alert alert-info">
			Categorias
			<hr>
			<?php
				$producto = new ProductosCon();
				$producto -> listaCategoriasCon('button');
			?>
		</div>
		<div class="col-xs-12 col-md-10">
			<div class="row view_products">
			<?php
				$producto -> listaProductosCon();
			?>
			</div>
		</div>
	</div>
</div>