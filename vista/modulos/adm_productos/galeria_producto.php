<?php
	require_once "../../../../controlador/adm/con_productos.php";
	require_once "../../../../modelo/adm/mod_productos.php";

	$id_producto = $_POST['id_producto'];

	$producto = new ProductosCon();
	$info = $producto -> infoProductoCon($id_producto);
	$imagenes = $producto -> imagenesProductoCon($id_producto);
?>
<script type="text/javascript">
	
	$("#id_marca").val('<?php echo $info['id_marca'];?>');
	$("#id_categoria").val('<?php echo $info['id_categoria'];?>');
	$("#id_unidad").val('<?php echo $info['id_unidad'];?>');
	//buscarClasificaciones();
	$("#id_clasificacion").val('<?php echo $info['id_clasificacion'];?>');

</script>
<div class="row">
	<div class="col-xs-12 col-md-12">
		<button class="btn btn-primary" style="float: left;" onclick="editar_producto('<?php echo $id_producto;?>')">
			<i class="fa fa-chevron-left"></i> Volver
		</button>
		<button class="btn btn-danger" style="float: right;" onclick="loadPage('productos')">
			<i class="fa fa-times"></i> Cancelar
		</button>
	</div>
	<div class="col-12">
		<div class="row">
			<div class="col-xs-12 col-md-8">
				<div class="alert alert-info">
					<b>Galeria de imagenes</b>
				</div>
				<?php
					if (!empty($imagenes)) 
					{
				?>
						<div class="row">
				<?php
						foreach ($imagenes as $foto) 
						{
				
				?>
							<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 p-2">
								<div style="text-align: right;">
									<button type="button" class="btn btn-warning" title="Eliminar imagen del servidor" onclick="estado_imagen('Eliminar','<?php echo $id_producto;?>','<?php echo $foto['id_imagen'];?>')"><i class="fa fa-ban"></i></button>
									<?php
										if ($foto['estado'] == "Activo") 
										{
									?>
											<button type="button" class="btn btn-danger" title="Inactivar imagen" onclick="estado_imagen('Inactivo','<?php echo $id_producto;?>','<?php echo $foto['id_imagen'];?>')"><i class="fa fa-trash"></i></button>
									<?php
										}
										else
										{
									?>
											<button type="button" class="btn btn-success" title="Activar imagen" onclick="estado_imagen('Activo','<?php echo $id_producto;?>','<?php echo $foto['id_imagen'];?>')"><i class="fa fa-check"></i></button>
									<?php
										}
									?>
								</div>
								<div style="box-shadow: 0px 0px 5px #AAA">
									<img src="vista/modulos/productos/imagenes/<?php echo $foto['imagen'];?>" alt="<?php echo $foto['imagen'];?>" style="width: 100%;height: auto;">
								</div>
							</div>
				<?php

						}
				?>
						</div>
				<?php

					}
					else
					{
				?>
						<div class="alert alert-danger">
							<b>No se han cargado imagenes a la galeria de este producto.</b>
						</div>
				<?php
					}
				?>
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="alert alert-info">
					<b>Subir imagen</b>
				</div>

				<img id="previsualizar" src="vista/img/productos/sin_imagen.png" alt="Previsualizacion" style="width: 100%;height: auto;">

				<form id="form_subir_imagen">
					<input type="hidden" name="id_producto" value="<?php echo $id_producto;?>">
					<hr>
					<input class="form-control" type="file" name="imagen" id="imagen" data-name="Imagen">
					<hr>
						
					<div class="alert alert-danger alert_imagen" style="display: none;"></div>

					<button type="button" class="btn btn-primary btn-block" onclick="subir_imagen('<?php echo $id_producto;?>')">
						<i class="fa fa-upload"></i> Subir imagen
					</button>

				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		// 	PREVISUALIZACION DE IMAGEN
		$('#imagen').change(function(e) {
			if ($("#imagen").val() != "") {
		    	addImage(e); 
			}else{
				$('#previsualizar').attr("src","vista/modulos/productos/imagenes/sin_imagen.png");
			}
		});

		function addImage(e){
		var file = e.target.files[0],
		imageType = /image.*/;

		if (!file.type.match(imageType))
		return;

		var reader = new FileReader();
		reader.onload = fileOnload;
		reader.readAsDataURL(file);
		}

		function fileOnload(e) {
		var result=e.target.result;
		$('#previsualizar').attr("src",result);
		}
	});
</script>