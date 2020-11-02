<?php
	require_once "../../../controlador/adm_con_pedidos.php";
	require_once "../../../modelo/adm_mod_pedidos.php";
	setlocale(LC_TIME, 'spanish');
	$email = $_POST['email'];

	$pedidos = new PedidosCon();
	$listado = $pedidos -> listaPedidosCon();

	//print_r($listado);

	if (!empty($listado)) 
	{
?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Id</th><th>Referencia</th><th>Fecha</th><th>Total</th><th>Estado</th><th></th>
				</tr>
			</thead>
			<tbody>
<?php
		foreach ($listado as $pedido) 
		{

			if ($pedido['estado'] == "por pagar" || $pedido['estado'] == "pendiente" || $pedido['estado'] == "contra entrega") {
				$colorEstado = "#f1c40f";
			}else if ($pedido['estado'] == "cancelado") {
				$colorEstado = "#c0392b";
			}else if ($pedido['estado'] == "pagado") {
				$colorEstado = "#2980b9";
			}else if ($pedido['estado'] == "entregado") {
				$colorEstado = "#27ae60";
			}

			$fecha = strftime("%d de %B del %Y", strtotime($pedido['fecha']));

?>
			<tr>
 				<td><?php echo $pedido['id_pedido'];?></td>
 				<td><?php echo $pedido['codigo_pedido'];?></td>
 				<td><?php echo $fecha;?></td>
 				<td><?php echo "$".number_format($pedido['total']);?></td>
 				<td style="background:<?php echo $colorEstado;?>;color:#FFF;"><?php echo $pedido['estado'];?></td>
 				<td>
 					<button type="button" class="btn btn-secondary" onclick="ver_pedido('<?php echo $pedido['id_pedido'];?>')"><i class="fa fa-search"></i> Ver pedido</button>
 				</td>
 			</tr>
<?php
		}
?>
			</tbody>
		</table>
<?php
	}
	else
	{
?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Id</th><th>Referencia</th><th>Fecha</th><th>Total</th><th>Estado</th><th></th>
				</tr>
			</thead>
			<tbody>
				<tr><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td></tr>
			</tbody>
		</table>
<?php
	}
?>