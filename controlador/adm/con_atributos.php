<?php
	/**
	* CONTROLADOR DE ATRIBUTOS DE PRODUCTOS
	*/
	class AtributosCon
	{
		#	SOLICITAR LISTADO DE ATRIBUTOS DE PRODUCTOS
		public function listaAtributosCon()
		{
			$respuesta = AtributosMod::listaAtributosMod();
			
			?>
				<table class="table table-striped" id="tabla_atributos">
					<thead>
						<tr class="alert alert-danger">
							<th>#</th>
							<th>Atributo</th>
							<th>Descripción</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i = 1;
							foreach ($respuesta as $atributo) 
							{
						?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $atributo['nombre'];?></td>
									<td><?php echo $atributo['descripcion'];?></td>
									<td>
										<button title="Editar atributo" class="btn btn-primary" onclick="editar_atributo('<?php echo $atributo['id_atributo'];?>')">
											<i class="fa fa-edit"></i>
										</button>
										<?php
											if ($atributo['estado'] == "Activo") 
											{
										?>
											<button title="Inactivar atributo" class="btn btn-danger" onclick="estado_atributo('Inactivo','<?php echo $atributo['id_atributo'];?>')">
												<i class="fa fa-trash"></i>
											</button>
										<?php
											}
											else
											{
										?>
											<button title="Activar atributo" class="btn btn-success" onclick="estado_atributo('Activo','<?php echo $atributo['id_atributo'];?>')">
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

		#	SOLICITAR REGISTRO DE ATRIBUTO
		public function registrarAtributoCon($datosAtributo)
		{
			$respuesta = AtributosMod::registrarAtributoMod($datosAtributo);
			print $respuesta;
		}

		#	SOLICITAR INFORMACION DE ATRIBUTO
		public function infoAtributoCon($id_atributo)
		{
			$respuesta = AtributosMod::infoAtributoMod($id_atributo);
			return $respuesta;
		}

		#	SOLICITAR ACTUALIZACION DE ATRIBUTO
		public function actualizarAtributoCon($datosAtributo)
		{
			$respuesta = AtributosMod::actualizarAtributoMod($datosAtributo);
			print $respuesta;
		}

		#	SOLICITAR CAMBIO DE ESTADO DE ATRIBUTO
		public function estadoAtributoCon($datosAtributo)
		{
			$respuesta = AtributosMod::estadoAtributoMod($datosAtributo);
			print $respuesta;
		}
		
	}
?>