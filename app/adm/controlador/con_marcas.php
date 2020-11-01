<?php
	/**
	* CONTROLADOR DE MARCAS DE PRODUCTOS
	*/
	class MarcasCon
	{
		#	SOLICITAR LISTADO DE MARCAS DE PRODUCTOS
		public function listaMarcasCon()
		{
			$respuesta = MarcasMod::listaMarcasMod();
			
			$i = 1;
			foreach ($respuesta as $marca) 
			{
				$nombre_marca = str_replace(' ', '_', $marca['nombre']);
			?>
				<div class="col-xs-6 col-md-3 p-2" style="border: 1px solid #DDD;">
					<table>
						<tr>
							<td style="text-align: right;">
								<button title="Editar marca" class="btn btn-primary" onclick="editar_marca('<?php echo $marca['id_marca'];?>')">
									<i class="fa fa-edit"></i>
								</button>
								<?php
									if ($marca['estado'] == "Activo") 
									{
								?>
									<button title="Inactivar marca" class="btn btn-danger" onclick="estado_marca('Inactivo','<?php echo $marca['id_marca'];?>')">
										<i class="fa fa-trash"></i>
									</button>
								<?php
									}
									else
									{
								?>
									<button title="Activar marca" class="btn btn-success" onclick="estado_marca('Activo','<?php echo $marca['id_marca'];?>')">
										<i class="fa fa-check"></i>
									</button>
								<?php
									}
								?>
							</td>
						</tr>
					</table>

					<h5><?php echo $marca['nombre'];?></h5>
					
					<img src="vista/modulos/marcas/logos/<?php echo $marca['logo'];?>" alt="<?php echo $marca['nombre'];?>" style="width: 100%;height: auto;">

				</div>
			<?php
				$i = $i + 1;
			}
		}

		#	SOLICITAR REGISTRO DE MARCA
		public function registrarMarcaCon($datosMarca)
		{
			$respuesta = MarcasMod::registrarMarcaMod($datosMarca);
			print $respuesta;
		}

		#	SOLICITAR INFORMACION DE MARCA
		public function infoMarcaCon($id_marca)
		{
			$respuesta = MarcasMod::infoMarcaMod($id_marca);
			return $respuesta;
		}

		#	SOLICITAR ACTUALIZACION DE MARCA
		public function actualizarMarcaCon($datosMarca)
		{
			$respuesta = MarcasMod::actualizarMarcaMod($datosMarca);
			print $respuesta;
		}

		#	SOLICITAR CAMBIO DE ESTADO DE MARCA
		public function estadoMarcaCon($datosMarca)
		{
			$respuesta = MarcasMod::estadoMarcaMod($datosMarca);
			print $respuesta;
		}
		
	}
?>