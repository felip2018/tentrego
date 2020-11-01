<?php
	require_once "controlador/con_tienda.php";
	require_once "modelo/mod_tienda.php";
?>
<div class="col-xs-12 col-md-12">
	<h4 class="alert alert-success">Tienda</h4>
</div>
<div class="col-12" id="contenido_productos">
	<div class="row">
		<div class="col-xs-12 col-md-2 alert alert-info">
			Categorias
			<hr>
			<?php
				$producto = new TiendaCon();
				$producto -> listaCategoriasCon('button');
			?>
		</div>
		<div class="col-xs-12 col-md-10">
			<div class="row p-2">
				<div class="col-12 text-left view_clasifications">
					
				</div>
			</div>
			<div class="row view_products">
			<?php
				$producto -> listaProductosCon();
			?>
			</div>
		</div>
	</div>
</div>