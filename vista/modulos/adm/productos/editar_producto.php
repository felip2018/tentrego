<?php
	require_once "../../../controlador/con_productos.php";
	require_once "../../../modelo/mod_productos.php";

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
		<button class="btn btn-success" style="float: left;" onclick="galeriaProducto('<?php echo $id_producto;?>')">
			<i class="fa fa-images"></i> Galeria de imagenes
		</button>
		<button class="btn btn-danger" style="float: right;" onclick="loadPage('productos')">
			<i class="fa fa-times"></i> Cancelar
		</button>
	</div>
	<div class="col-12">
		<form id="form_registro_producto">
		<input type="hidden" name="id_producto" id="id_producto" value="<?php echo $id_producto;?>">
		<div class="row">
			<div class="col-xs-12 col-md-9">
				<caption>Actualizar producto en el sistema</caption>
				<h5>Ajustes básicos</h5>
				<table style="width: 100%;">
					<tbody>
						<tr>
							<td>
								<table>
									<tr>
										<td style="width: 50%;">
											<p>Nombre del producto</p>
											<input class="form-control" type="text" name="nombre" id="nombre" data-name="Nombre del producto" value="<?php echo $info['nombre'];?>">
										</td>
										<td style="width: 50%;">
											<p>Marca</p>
											<select class="form-control" name="id_marca" id="id_marca" data-name="Marca">
												<option value="">-Seleccione la marca del producto</option>
												<?php
													$producto -> listaMarcasCon('options');
												?>
											</select>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<table>
									<tr>
										<td style="width: 50%;">
											<p>Categoria</p>
											<select class="form-control" name="id_categoria" id="id_categoria" data-name="Categoria" onchange="buscarClasificaciones()">
												<option value="">-Seleccione la categoria del producto</option>
												<?php
													$producto -> listaCategoriasCon('options');
												?>
											</select>
										</td>
										<td style="width: 50%;">
											<p>Clasificación</p>
											<select class="form-control" name="id_clasificacion" 
											id="id_clasificacion" data-name="Clasificacion">
												<option value="">-Seleccione la clasificación del producto</option>
												<?php
													$producto -> listadoClasificacionCon($info['id_categoria']);
												?>
											</select>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<table>
									<tr>
										<td style="width: 50%;">
											<p>Cantidad</p>
											<input class="form-control" type="text" name="cantidad" id="cantidad" data-name="Cantidad" value="<?php echo $info['cantidad'];?>">
										</td>
										<td style="width: 50%;">
											<p>Unidad de medida</p>
											<select class="form-control" name="id_unidad" id="id_unidad" data-name="Unidad de medida">
												<option value="">-Seleccione</option>
												<?php
													$producto = new ProductosCon();
													$producto -> listaUnidadesCon();
												?>
											</select>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<hr>

				<h5>Precio</h5>
				<table style="width: 100%;">
					<tbody>
						<tr>
							<td>
								<table>
									<tr>
										<td>
											<p>Costo ($)</p>
											<input class="form-control" type="number" name="costo" id="costo" data-name="Costo" value="<?php echo $info['costo'];?>">
										</td>
										<td>
											<p>Utilidad (%)</p>
											<input class="form-control" type="number" name="utilidad" id="utilidad" onblur="calcularVenta()" data-name="Utilidad" value="<?php echo $info['utilidad'];?>">
										</td>
										<td>
											<p>Venta ($)</p>
											<input class="form-control" type="number" name="venta" id="venta" onblur="calcularUtilidad()" data-name="Venta" value="<?php echo $info['venta'];?>">
										</td>
									</tr>
								</table>
							</td>
						</tr>
						
					</tbody>
				</table>
				<hr>

				<h5>Atributos registrados</h5>

				<table style="width: 100%;" border="0">
					<tbody>
						<?php
							$producto -> listaAtributosRegistradosCon($id_producto);
						?>
					</tbody>
				</table>

				<h5>Atributos</h5>

				<table style="width: 100%;" border="0">
					<tbody>
						<?php
							$producto -> listaAtributosPendientesCon($id_producto);
						?>
					</tbody>
				</table>

				<h5>Descripción del producto</h5>
				<textarea class="form-control" rows="4" name="descripcion" id="descripcion"><?php echo $info['descripcion'];?></textarea>
		
				<hr>

				<div class="alert alert-warning" id="alert_registro" style="display: none;"></div>
				<button type="button" class="btn btn-primary btn-block" onclick="salvar_producto('actualizar')">
					<i class="fa fa-save"></i> Salvar Producto
				</button>
			</div>
			<div class="col-xs-12 col-md-3">
				<p>Imagen</p>
				<img id="previsualizar" src="vista/modulos/productos/imagenes/<?php echo $info['imagen'];?>" alt="Previsualizacion" style="width: 100%;height: auto;">
				<input class="form-control" type="file" name="imagen" id="imagen" data-name="Imagen">
			</div>
		</div>
		</form>
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