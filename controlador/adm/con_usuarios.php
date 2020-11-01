<?php
	/**
	* 	CONTROLADOR DE USUARIOS 
	*/
	class UsuariosCon
	{
		
		#	SOLICITAR LISTADO DE USUARIOS DEL SISTEMA
		public function listaUsuariosCon()
		{
			$respuesta = UsuariosMod::listaUsuariosMod();
			//print_r($respuesta);
			?>
				<table class="table table-striped" id="tabla_usuarios">
					<thead>
						<tr class="alert alert-danger">
							<th>#</th>
							<th>Identificación</th>
							<th>Apellidos</th>
							<th>Nombres</th>
							<th>Email</th>
							<th>Telefono</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i = 1;
							foreach ($respuesta as $usuario) 
							{
						?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $usuario['identi'];?></td>
									<td><?php echo $usuario['apellido'];?></td>
									<td><?php echo $usuario['nombre'];?></td>
									<td><?php echo $usuario['email'];?></td>
									<td><?php echo $usuario['telefono'];?></td>
									<td>
										<button title="Editar usuario" class="btn btn-primary" onclick="editar_usuario('<?php echo $usuario['pk_usuario'];?>')">
											<i class="fa fa-edit"></i>
										</button>
										<?php
											if ($usuario['estado'] == "Activo") 
											{
										?>
											<button title="Inactivar usuario" class="btn btn-danger" onclick="estado_usuario('Inactivo','<?php echo $usuario['pk_usuario'];?>')">
												<i class="fa fa-trash"></i>
											</button>
										<?php
											}
											else
											{
										?>
											<button title="Activar usuario" class="btn btn-success" onclick="estado_usuario('Activo','<?php echo $usuario['pk_usuario'];?>')">
												<i class="fa fa-check"></i>
											</button>
										<?php
											}
										?>
									</td>
								</tr>
						<?php
								$i = $i + 1;
							}
						?>
					</tbody>
				</table>
			<?php
		}

		#	SOLICITAR LISTADO DE TIPOS DE IDENTIFICACION
		public function listaTipoIdentiCon()
		{
			$respuesta = UsuariosMod::listaTipoIdentiMod();
			foreach ($respuesta as $tipo_identi) 
			{
				echo "<option value='$tipo_identi[id_tipo_identi]'>".$tipo_identi['nombre']."</option>";
			}
		}

		#	SOLICITAR LISTA DE PERFILES
		public function listaPerfilesCon()
		{
			$respuesta = UsuariosMod::listaPerfilesMod();
			foreach ($respuesta as $perfil) 
			{
				echo "<option value='$perfil[id_perfil]'>".$perfil['nombre']."</option>";
			}
		}

		#	SOLICITAR REGISTRO DE USUARIO
		public function registrarUsuarioCon($datosUsuario)
		{
			$respuesta = UsuariosMod::registrarUsuarioMod($datosUsuario);
			print $respuesta;
		}

		#	SOLICITAR INFORMACION DE USUARIO
		public function infoUsuarioCon($pk_usuario)
		{
			$respuesta = UsuariosMod::infoUsuarioMod($pk_usuario);
			return $respuesta;
		}

		#	SOLICITAR ACTUALIZACION DE USUARIO
		public function actualizarUsuarioCon($datosUsuario)
		{
			$respuesta = UsuariosMod::actualizarUsuarioMod($datosUsuario);
			print $respuesta;
		}

		#	SOLICITAR CAMBIO DE ESTADO DE USUARIO
		public function estadoUsuarioCon($datosUsuario)
		{
			$respuesta = UsuariosMod::estadoUsuarioMod($datosUsuario);
			print $respuesta;
		}
	}
?>