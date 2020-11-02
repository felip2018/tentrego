<?php
	/**
	* CONTROLADOR DE CATEGORIAS DE PRODUCTOS
	*/
	class CategoriasCon
	{
		#	SOLICITAR LISTADO DE CATEGORIAS DE PRODUCTOS
		public function listaCategoriasCon()
		{
			$respuesta = CategoriasMod::listaCategoriasMod();
			//print_r($respuesta);
			
			$i = 1;
			foreach ($respuesta as $categoria) 
			{
				$nombre_categoria = str_replace(' ', '_', $categoria['nombre']);
			?>
				<div class="col-xs-6 col-md-4 p-2" style="border: 1px solid #DDD;">
					<table>
						<tr>
							<td style="text-align: right;">
								<button title="Editar categoria" class="btn btn-primary" onclick="editar_categoria('<?php echo $categoria['id_categoria'];?>')">
									<i class="fa fa-edit"></i>
								</button>
								<button title="Agregar clasificacion" class="btn btn-success" onclick="agregar_clasificacion('<?php echo $categoria['id_categoria'];?>','<?php echo $nombre_categoria;?>')">
									<i class="fa fa-plus"></i>
								</button>
								<?php
									if ($categoria['estado'] == "Activo") 
									{
								?>
									<button title="Inactivar categoria" class="btn btn-danger" onclick="estado_categoria('Inactivo','<?php echo $categoria['id_categoria'];?>')">
										<i class="fa fa-trash"></i>
									</button>
								<?php
									}
									else
									{
								?>
									<button title="Activar categoria" class="btn btn-success" onclick="estado_categoria('Activo','<?php echo $categoria['id_categoria'];?>')">
										<i class="fa fa-check"></i>
									</button>
								<?php
									}
								?>
							</td>
						</tr>
					</table>

					<h5><?php echo $categoria['nombre'];?></h5>
					
					<table class="table table-striped">
						<tr>
							<td style="width: 10%;"><b>#</b></td>
							<td style="width: 60%;"><b>CLASIFICACIÓN</b></td>
							<td style="width: 30%;">
								
							</td>
						</tr>
						<?php
							$listaClasificacion = CategoriasMod::listaClasificacionMod($categoria['id_categoria']);
							
							$j = 1;

							foreach ($listaClasificacion as $clasificacion) 
							{
								$nombre_clasificacion = str_replace(' ', '_', $clasificacion['nombre']);
						?>
							<tr>
								<td><?php echo $j;?></td>
								<td><?php echo $clasificacion['nombre'];?></td>
								<td>
									
									<button title="Editar clasificacion" class="btn btn-primary" onclick="editar_clasificacion('<?php echo $clasificacion['id_clasificacion'];?>','<?php echo $nombre_clasificacion;?>')">
										<i class="fa fa-edit"></i>
									</button>

									<?php
										if ($clasificacion['estado'] == "Activo") 
										{
									?>
										<button title="Inactivar clasificacion" class="btn btn-danger" onclick="estado_clasificacion('Inactivo','<?php echo $clasificacion['id_clasificacion'];?>')">
											<i class="fa fa-trash"></i>
										</button>
									<?php
										}
										else
										{
									?>
										<button title="Activar clasificacion" class="btn btn-success" onclick="estado_clasificacion('Activo','<?php echo $clasificacion['id_clasificacion'];?>')">
											<i class="fa fa-check"></i>
										</button>
									<?php
										}
									?>
								</td>
							</tr>
						<?php
								$j = $j + 1;
							}
						?>
					</table>

				</div>
			<?php
				$i = $i + 1;
			}
		}

		#	SOLICITAR REGISTRO DE CATEGORIA
		public function registrarCategoriaCon($datosCategoria)
		{
			$respuesta = CategoriasMod::registrarCategoriaMod($datosCategoria);
			print $respuesta;
		}

		#	SOLICITAR INFORMACION DE CATEGORIA
		public function infoCategoriaCon($id_categoria)
		{
			$respuesta = CategoriasMod::infoCategoriaMod($id_categoria);
			return $respuesta;
		}

		#	SOLICITAR ACTUALIZACION DE CATEGORIA
		public function actualizarCategoriaCon($datosCategoria)
		{
			$respuesta = CategoriasMod::actualizarCategoriaMod($datosCategoria);
			print $respuesta;
		}

		#	SOLICITAR CAMBIO DE ESTADO DE CATEGORIA
		public function estadoCategoriaCon($datosCategoria)
		{
			$respuesta = CategoriasMod::estadoCategoriaMod($datosCategoria);
			print $respuesta;
		}

		#	SOLICITAR REGISTRO DE CLASIFICACION
		public function registrarClasificacionCon($datosClasificacion)
		{
			$respuesta = CategoriasMod::registrarClasificacionMod($datosClasificacion);
			print $respuesta;
		}

		#	SOLICITAR ACTUALIZACION DE CLASIFICACION
		public function actualizarClasificacionCon($datosClasificacion)
		{
			$respuesta = CategoriasMod::actualizarClasificacionMod($datosClasificacion);
			print $respuesta;	
		}

		#	SOLICITAR CAMBIO DE ESTADO DE CLASIFICACION
		public function estadoClasificacionCon($datosClasificacion)
		{
			$respuesta = CategoriasMod::estadoClasificacionMod($datosClasificacion);
			print $respuesta;
		}
		
	}
?>