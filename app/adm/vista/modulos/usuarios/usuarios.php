<?php
	require_once "../../../controlador/con_usuarios.php";
	require_once "../../../modelo/mod_usuarios.php";
?>
	<div class="col-12">
		<h4 class="alert alert-info">Usuarios</h4>
		<button style="float: right;" title="Registrar Usuario" class="btn btn-success" onclick="nuevo_usuario()"><i class="fa fa-plus"></i> Registrar usuario</button>
	</div>
	<div class="col-12">
		<div id="lista_usuarios">
			<?php
				$areas = new UsuariosCon();
				$areas -> listaUsuariosCon();
			?>
		</div>
	</div>
	
<script type="text/javascript">
	$(document).ready(function () {
		//$("#tabla_usuarios").DataTable();
	})
</script>
