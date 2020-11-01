<?php
	require_once "controlador/con_response.php";
	require_once "modelo/mod_response.php";

	$transactionState 		= $_GET['transactionState'];
	$lapTransactionState 	= $_GET['lapTransactionState'];
	$message 				= $_GET['message'];

	//	CODIGO DE REFERENCIA DEL PEDIDO
	$referenceCode 			= $_GET['referenceCode'];

	$polTransactionState	= $_GET['polTransactionState'];
	$polResponseCode 		= $_GET['polResponseCode'];
	$lapResponseCode 		= $_GET['lapResponseCode'];
	$reference_pol 			= $_GET['reference_pol'];
	$transactionId 			= $_GET['transactionId'];
	$polPaymentMethod 		= $_GET['polPaymentMethod'];
	$lapPaymentMethod 		= $_GET['lapPaymentMethod'];
	$polPaymentMethodType 	= $_GET['polPaymentMethodType'];
	$lapPaymentMethodType 	= $_GET['lapPaymentMethodType'];

	$datosTransaccion = array(	"referenceCode"				=> $referenceCode,
								"transactionState"			=> $transactionState,
								"lapTransactionState"		=> $lapTransactionState,
								"message"					=> $message,
								"polTransactionState"		=> $polTransactionState,
								"polResponseCode"			=> $polResponseCode,
								"lapResponseCode"			=> $lapResponseCode,
								"reference_pol"				=> $reference_pol,
								"transactionId"				=> $transactionId,
								"polPaymentMethod"			=> $polPaymentMethod,
								"lapPaymentMethod"			=> $lapPaymentMethod,
								"polPaymentMethodType"		=> $polPaymentMethodType,
								"lapPaymentMethodType"		=> $lapPaymentMethodType);

	$response = new ResponseCon();
	$response -> actualizarPedidoCon($datosTransaccion);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Response</title>
	<!--FAVICON-->
	<link rel="icon" href="../vista/img/favicon.png" type="image/png" sizes="20x20">
	
	<!--JQUERY-->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<!--JQUERY-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!--BOOTSTRAP-->
	<link rel="stylesheet" type="text/css" href="../vista/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="../vista/css/style.css">
	<script type="text/javascript" src="../vista/js/bootstrap/bootstrap.min.js"></script>
	
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
	<!--FONT-AWESOME-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		
</head>
<body>
	<div class="container-fluid">
		<div class="row" id="navbar">
			<div class="col-12" style="background: rgb(192,57,43);">
				<div class="row">
					<div class="col-12" style="padding: 10px;text-align: center;">
						<img src="../vista/img/logo_click_store_2.png" alt="Logo Click Store">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container" style="padding: 100px 10px 100px 10px;">
		<div class="row">
			<div class="col-12">
				<h4 style="text-align: center;">RESULTADO DE LA TRANSACCIÓN</h4>
				<?php

					//echo "<pre>";
					//print_r($_GET);
					//echo "</pre>";

					$ApiKey = "4Vj8eK4rloUd272L48hsrarnUA";
					$merchant_id = $_REQUEST['merchantId'];
					$referenceCode = $_REQUEST['referenceCode'];
					$TX_VALUE = $_REQUEST['TX_VALUE'];
					$New_value = number_format($TX_VALUE, 1, '.', '');
					$currency = $_REQUEST['currency'];
					$transactionState = $_REQUEST['transactionState'];
					$firma_cadena = $ApiKey."~".$merchant_id."~".$referenceCode."~".$New_value."~".$currency."~".$transactionState;
					$firmacreada = md5($firma_cadena);
					$firma = $_REQUEST['signature'];
					$reference_pol = $_REQUEST['reference_pol'];
					$cus = $_REQUEST['cus'];
					$extra1 = $_REQUEST['description'];
					$pseBank = $_REQUEST['pseBank'];
					$lapPaymentMethod = $_REQUEST['lapPaymentMethod'];
					$transactionId = $_REQUEST['transactionId'];

					if ($_REQUEST['transactionState'] == 4 ) {
						$estadoTx = "Transacción aprobada";
					}

					else if ($_REQUEST['transactionState'] == 6 ) {
						$estadoTx = "Transacción rechazada";
					}

					else if ($_REQUEST['transactionState'] == 104 ) {
						$estadoTx = "Error";
					}

					else if ($_REQUEST['transactionState'] == 7 ) {
						$estadoTx = "Transacción pendiente";
					}

					else {
						$estadoTx=$_REQUEST['mensaje'];
					}


					?>
						<h5>Resumen Transacción</h5>
						<table class="table table-striped">
						<tr>
							<td>Estado de la transaccion</td>
							<td><?php echo $estadoTx; ?></td>
						</tr>
						<tr>
							<td>ID de la transaccion</td>
							<td><?php echo $transactionId; ?></td>
						</tr>
						<tr>
							<td>Referencia de la venta</td>
							<td><?php echo $reference_pol; ?></td>
						</tr>
						<tr>
							<td>Referencia de la transaccion</td>
							<td><?php echo $referenceCode; ?></td>
						</tr>
						
						<?php
							if($pseBank != null) 
							{
						?>
							<tr>
								<td>cus </td>
								<td><?php echo $cus; ?> </td>
							</tr>
							<tr>
								<td>Banco </td>
								<td><?php echo $pseBank; ?> </td>
							</tr>
						<?php
							}
						?>

						<td>Valor total</td>
						<td>$<?php echo number_format($TX_VALUE); ?></td>
						</tr>
						<tr>
						<td>Moneda</td>
						<td><?php echo $currency; ?></td>
						</tr>
						<tr>
						<td>Descripción</td>
						<td><?php echo ($extra1); ?></td>
						</tr>
						<tr>
						<td>Entidad:</td>
						<td><?php echo ($lapPaymentMethod); ?></td>
						</tr>
						</table>
					
			</div>
		</div>
	</div>
</body>
</html>