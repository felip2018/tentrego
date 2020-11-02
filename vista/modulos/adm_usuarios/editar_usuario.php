<?php
	require_once "../../../controlador/con_usuarios.php";
	require_once "../../../modelo/mod_usuarios.php";

	$pk_usuario = $_POST['pk_usuario'];

	$usuario = new UsuariosCon();
	$info = $usuario -> infoUsuarioCon($pk_usuario);

?>
<script type="text/javascript">
	$("#id_tipo_identi").val("<?php echo $info['id_tipo_identi'];?>");
	$("#id_perfil").val("<?php echo $info['id_perfil'];?>");
</script>
<div class="row">
	<div class="col-xs-12 col-md-12">
		<button class="btn btn-danger" style="float: right;" onclick="$('#panel_animado').css('display','none');">
			<i class="fa fa-close"></i> Cerrar
		</button>
	</div>
	<div class="col-xs-12 col-md-12">
		<caption>Editar información de Usuario</caption>
		<form id="form_registro_usuario">
	
			<input type="hidden" name="pk_usuario" value="<?php echo $pk_usuario;?>">

			<table style="width: 100%;" >
				
				<tbody>
					<tr>
						<td style="width: 50%;">
							<p>Tipo de Identificación</p>
							<select class="form-control" name="id_tipo_identi" id="id_tipo_identi" disabled="true">
								<!--<option value="0">-Seleccione</option>-->
								<?php
									# CONSULTAMOS LOS TIPOS DE IDENTIFICACIÓN
									$usuarios = new UsuariosCon();
									$usuarios -> listaTipoIdentiCon();
								?>
							</select>
						</td>
						<td style="width: 50%;">
							<p>Número de Identificación</p>
							<input class="form-control" type="number" min="0" name="num_identi" id="num_identi" value="<?php echo $info['num_identi'];?>" disabled="true">
						</td>
					</tr>
					<tr>
						<td>
							<p>Nombres</p>
							<input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $info['nombre'];?>">
						</td>
						<td>
							<p>Apellidos</p>
							<input class="form-control" type="text" name="apellido" id="apellido" value="<?php echo $info['apellido'];?>">
						</td>
					</tr>
					<tr>
						<td>
							<p>E-mail</p>
							<input class="form-control" type="email" name="email" id="email" value="<?php echo $info['email'];?>">
						</td>
						<td>
							<p>Teléfono</p>
							<input class="form-control" type="text" name="telefono" id="telefono" value="<?php echo $info['telefono'];?>">
						</td>
					</tr>
					<tr>
						<td>
							<p>Perfil</p>
							<select class="form-control" name="id_perfil" id="id_perfil">
								<option value="">-Seleccione</option>}
								<?php
									# CONSULTAMOS LOS PERFILES
									$usuarios = new UsuariosCon();
									$usuarios -> listaPerfilesCon();
								?>
							</select>
						</td>
						<td>
							<p>Clave</p>
							<input class="form-control" type="text" disabled="true" placeholder="Por defecto">
						</td>
					</tr>
				</tbody>
			</table>
		</form>
		<hr>
		<button class="btn btn-primary btn-block" onclick="salvar_usuario('2')">
			<i class="fa fa-save"></i> Salvar Usuario
		</button>
		<br>
		<div class="alert alert-warning" id="alert_registro" style="display: none;"></div>
	</div>
</div>