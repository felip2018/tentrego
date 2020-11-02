<?php
	require_once "../../../../controlador/adm/con_productos.php";
	require_once "../../../../modelo/adm/mod_productos.php";
	$producto = new ProductosCon();
?>
<div class="row">
	<div class="col-xs-12 col-md-12">
		<button class="btn btn-danger" style="float: right;" onclick="loadPage('productos')">
			<i class="fa fa-times"></i> Cancelar
		</button>
	</div>
	<div class="col-12">
		<form id="form_registro_producto">
		<div class="row">
			<div class="col-xs-12 col-md-9">
				<caption>Registrar producto en el sistema</caption>
				<h5>Ajustes básicos</h5>
				<table style="width: 100%;">
					<tbody>
						<tr>
							<td>
								<table>
									<tr>
										<td style="width: 50%;">
											<p>Nombre del producto</p>
											<input class="form-control" type="text" name="nombre" id="nombre" data-name="Nombre del producto">
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
											<select class="form-control" name="id_clasificacion" id="id_clasificacion" data-name="Clasificacion" disabled>
												<option value="">-Seleccione la clasificación del producto</option>
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
											<input class="form-control" type="text" name="cantidad" id="cantidad" data-name="Cantidad">
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
											<input class="form-control" type="number" name="costo" id="costo" data-name="Costo">
										</td>
										<td>
											<p>Utilidad (%)</p>
											<input class="form-control" type="number" name="utilidad" id="utilidad" onblur="calcularVenta()" data-name="Utilidad">
										</td>
										<td>
											<p>Venta ($)</p>
											<input class="form-control" type="number" name="venta" id="venta" onblur="calcularUtilidad()" data-name="Venta">
										</td>
									</tr>
								</table>
							</td>
						</tr>
						
					</tbody>
				</table>
				<hr>

				<h5>Atributos</h5>

				<table style="width: 100%;" border="0">
					<tbody>
						<?php
							$producto -> listaAtributosCon();
						?>
					</tbody>
				</table>

				<h5>Descripción del producto</h5>
				<textarea class="form-control" rows="4" name="descripcion" id="descripcion"></textarea>
		
				<hr>

				<div class="alert alert-warning" id="alert_registro" style="display: none;"></div>
				<button type="button" class="btn btn-primary btn-block" onclick="salvar_producto('registrar')">
					<i class="fa fa-save"></i> Salvar Producto
				</button>
			</div>
			<div class="col-xs-12 col-md-3">
				<p>Imagen</p>
				<img id="previsualizar" src="vista/img/productos/sin_imagen.png" alt="Previsualizacion" style="width: 100%;height: auto;border: 1px solid #CCC;">
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