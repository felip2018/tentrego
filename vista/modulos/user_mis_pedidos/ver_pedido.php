<?php
	
	require_once "../../../controlador/con_mis_pedidos.php";
	require_once "../../../modelo/mod_mis_pedidos.php";

	if (isset($_POST['id_pedido'])) 
	{
		setlocale(LC_TIME, 'spanish');
		$pedido = new MisPedidosCon();
		$maestro = $pedido->maestroPedidoCon($_POST['id_pedido']);
		$detalle = $pedido->detallePedidoCon($_POST['id_pedido']);

		$fecha = strftime("%d de %B del %Y", strtotime($maestro['fecha']));

		if ($maestro['estado'] == "por pagar" || $maestro['estado'] == "pendiente" || $maestro['estado'] == "contra entrega") {
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
		<div class="col-xs-12 col-md-4">
			<button type="button" class="btn btn-primary" onclick="loadPage('mis_pedidos')">
				<i class="fa fa-chevron-left"></i> Volver a mis pedidos
			</button>
			<hr>
			<div class="alert alert-success">
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
			<?php
				if ($maestro['estado'] == "por pagar") 
				{
					# MOSTRAR LOS MEDIOS DE PAGO PARA EL ACTUAL PEDIDO
					$apiKey 			= "pmS3DR565nis3uURHKWf32W33Z";
					$merchantId 		= "735030";
					$accountId 			= "740086";
					$description 		= "Pedido No ".$maestro['id_pedido'];
					$referenceCode 		= $maestro['codigo_pedido'];
					$amount 			= $maestro['total'];
					$tax 				= 0;
					$taxReturnBase 		= 0;
					$currency 			= "COP";

					//FIRMA
					//ApiKey - MerchantId - Referencia - Valor - Currency
					$str 				= $apiKey.'~'.$merchantId.'~'.$referenceCode.'~'.$amount.'~'.$currency;
					$signature 			= md5($str);

					$test 				= 1;
					$buyerEmail 		= $maestro['email'];
					$payerFullName 		= "Felipe Garzon";
					$responseUrl 		= "http://www.clickstore.co/response";
					$confirmationUrl 	= "http://www.clickstore.co/confirmation";

					/*
					Una vez generes el formulario HTML deberás apuntar a la siguiente URL:

					Pruebas: https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/

					Producción: https://checkout.payulatam.com/ppp-web-gateway-payu/
 
					*/

			?>
			<div class="alert alert-warning">
				<b>Selecciona el medio de pago</b>
				<!--<form method="post" action="https://checkout.payulatam.com/ppp-web-gateway-payu/" target="_blank">
				  <input name="merchantId"    	type="hidden"  value="<?php //echo $merchantId;?>">
				  <input name="accountId"     	type="hidden"  value="<?php //echo $accountId;?>">
				  <input name="description"   	type="hidden"  value="<?php //echo $description;?>">
				  <input name="referenceCode" 	type="hidden"  value="<?php //echo $referenceCode;?>">
				  <input name="amount"        	type="hidden"  value="<?php //echo $amount;?>">
				  <input name="tax"           	type="hidden"  value="<?php //echo $tax;?>">
				  <input name="taxReturnBase" 	type="hidden"  value="<?php //echo $taxReturnBase;?>">
				  <input name="currency"      	type="hidden"  value="<?php //echo $currency;?>">
				  <input name="signature"     	type="hidden"  value="<?php //echo $signature;?>">
				  <input name="test"          	type="hidden"  value="<?php //echo $test;?>">
				  <input name="buyerEmail"    	type="hidden"  value="<?php //echo $buyerEmail;?>">
				  <input name="payerFullName"   type="hidden"  value="<?php //echo $payerFullName;?>">
				  <input name="responseUrl"    	type="hidden"  value="<?php //echo $responseUrl;?>">
				  <input name="confirmationUrl" type="hidden"  value="<?php //echo $confirmationUrl;?>">
				  <input name="Submit"       	type="submit"  value="Pago en linea" class="btn btn-primary btn-block">
				</form>-->
				<hr>
				<button class="btn btn-primary btn-block" type="button" onclick="pago_contraentrega('<?php echo $_POST['id_pedido'];?>')">
					Pago contraentrega
				</button>

			</div>
			<?php
				}
			?>
		</div>
		<div class="col-xs-12 col-md-8">
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
										<button type="button" class="btn btn-info m-2" title="Crear una reseña del producto" onclick="crear_resena('<?php echo $producto['id_pedido'];?>','<?php echo $producto['id_producto'];?>','<?php echo $maestro['email'];?>')">
											<i class="fa fa-star"></i> Reseña del producto
										</button>
										<button type="button" class="btn btn-warning m-2" title="Generar devolución del producto" onclick="producto_caso('devolucion','<?php echo $producto['id_pedido'];?>','<?php echo $producto['id_producto'];?>')">
											<i class="fa fa-exclamation-triangle"></i> Devolución
										</button>
										<button type="button" class="btn btn-success m-2" title="Solicitar garantía del producto" onclick="producto_caso('garantia','<?php echo $producto['id_pedido'];?>','<?php echo $producto['id_producto'];?>')">
											<i class="fa fa-sun"></i> Garantía
										</button>
								<?php
									}
									elseif ($producto['estado'] == "devolucion") 
									{
								?>
										<div class="alert alert-warning">
											<p>En proceso de devolución</p>
										</div>
								<?php
									}
									elseif ($producto['estado'] == "garantia") 
									{
								?>
										<div class="alert alert-success">
											<p>En proceso de garantía</p>
										</div>
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