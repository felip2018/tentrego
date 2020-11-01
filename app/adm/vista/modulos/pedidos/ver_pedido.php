<?php
	require_once "../../../controlador/con_pedidos.php";
	require_once "../../../modelo/mod_pedidos.php";

	if (isset($_POST['id_pedido'])) 
	{
		setlocale(LC_TIME, 'spanish');
		$pedido = new PedidosCon();
		$maestro = $pedido->maestroPedidoCon($_POST['id_pedido']);
		$detalle = $pedido->detallePedidoCon($_POST['id_pedido']);

		$fecha = strftime("%d de %B del %Y", strtotime($maestro['fecha']));

		if ($maestro['estado'] == "por pagar" || $maestro['estado'] == "contra entrega") {
			$colorEstado = "#f1c40f";
		}else if ($maestro['estado'] == "cancelado") {
			$colorEstado = "#c0392b";
		}else if ($maestro['estado'] == "pagado") {
			$colorEstado = "#2980b9";
		}else if ($maestro['estado'] == "entregado") {
			$colorEstado = "#27ae60";
		}

?>
<style type="text/css" media="screen">

#form label {
  font-size: 25px;
}

input[type="radio"] {
  display: none;
}

label {
  color: grey;
  font-size: 15pt;
}

.clasificacion {
  direction: rtl;
  unicode-bidi: bidi-override;
  text-align: center;
}

label:hover,
label:hover ~ label {
  color: orange;
}

input[type="radio"]:checked ~ label {
  color: orange;
  font-size: 15pt;
}
</style>
		<div class="col-xs-12 col-md-5">
			<button type="button" class="btn btn-primary" onclick="loadPage('pedidos')">
				<i class="fa fa-chevron-left"></i> Volver a mis pedidos
			</button>
			<hr>
			<div class="alert alert-success">
				<b>Información del Pedido</b>
				<table class="table table-striped">
					<tr>
						<td>Pedido #</td><td><b><?php echo $maestro['id_pedido'];?></b></td>
					</tr>
					<tr>
						<td>Referencia</td><td><b><?php echo $maestro['codigo_pedido'];?></b></td>
					</tr>
					<tr>
						<td>Fecha</td><td><b><?php echo $fecha;?></b></td>
					</tr>
					<tr>
						<td>Total</td><td><b><?php echo "$ ".number_format($maestro['total']);?></b></td>
					</tr>
					<tr>
						<td>Estado</td><td style="background: <?php echo $colorEstado;?>;color:#FFF;"><b><?php echo $maestro['estado'];?></b></td>
					</tr>
				</table>
			</div>
			<div class="alert alert-info">
				<b>Información de Usuario</b>
				<table class="table table-striped">
					<tr>
						<td>Usuario</td><td><?php echo $maestro['nombre_usuario'];?></td>
					</tr>
					<tr>
						<td>Identificación</td><td><?php echo $maestro['identificacion_usuario'];?></td>
					</tr>
					<tr>
						<td>Email</td><td><?php echo $maestro['email'];?></td>
					</tr>
					<tr>
						<td>Teléfono</td><td><?php echo $maestro['telefono_usuario'];?></td>
					</tr>
					<tr>
						<td>Dirección</td><td><?php echo $maestro['direccion_usuario'];?></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="col-xs-12 col-md-7">
			<h4>Productos</h4>
			<hr>
			<?php
				foreach ($detalle as $producto) 
				{
					$nombre_producto = $producto['marca'].' '.$producto['nombre'];
			?>
					<div class="row">
						<div class="col-xs-12 col-md-2">
							<img src="../adm/vista/modulos/productos/imagenes/<?php echo $producto['imagen'];?>" alt="Producto" style="width: 100%;height: auto;">
						</div>
						<div class="col-xs-12 col-md-10">
							<h5><?php echo $nombre_producto;?></h5>
							<div class="row">
								<div class="col-4">
									<b>Valor Unitario</b><br>
									<h5>$ <?php echo number_format($producto['valor_unitario']);?></h5>
								</div>
								<div class="col-4">
									<b>Cantidad</b><br>
									<h5><?php echo $producto['cantidad'];?></h5>
								</div>
								<div class="col-4">
									<b>Sub Total</b><br>
									<h5>$ <?php echo number_format($producto['valor_unitario'] * $producto['cantidad']);?></h5>
								</div>
							</div>
							<div class="row">
								<?php
									if ($producto['estado'] == "entregado") 
									{
								?>	
										<!--<button type="button" class="btn btn-warning m-2">
											Devolución
										</button>-->
										<button type="button" class="btn btn-info m-2" onclick="crear_resena('<?php echo $producto['id_pedido'];?>','<?php echo $producto['id_producto'];?>','<?php echo $maestro['email'];?>')">
											<i class="fa fa-star"></i> Reseña del producto
										</button>
								<?php
									}
								?>
							</div>
						</div>
					</div>
					<hr>
			<?php
				}
			?>
		</div>
<?php
	}
	else
	{
		echo "Vista no disponible!";
	}
?>