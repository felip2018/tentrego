<?php
	require_once "controlador/con_confirmation.php";
	require_once "modelo/mod_confirmation.php";

	$state_pol 			= $_POST['state_pol']; // Indica el estado de la transacción en el sistema. 4 = APROBADA ; 6 = DECLINADA
	$response_code_pol 	= $_POST['response_code_pol']; //El código de respuesta de PayU.
	$reference_sale  	= $_POST['reference_sale']; // Es la referencia de la venta o pedido. Deber ser único por cada transacción que se envía al sistema.
	$reference_pol		= $_POST['reference_pol']; // La referencia o número de la transacción generado en PayU.
	$transaction_id 	= $_POST['transaction_id']; // Identificador de la transacción.

	$datosConfirmacion 	= array("state_pol"			=> $state_pol,
								"response_code_pol" => $response_code_pol,
								"reference_sale"	=> $reference_sale,
								"reference_pol"		=> $reference_pol,
								"transaction_id"	=> $transaction_id);

	$confirmation = new ConfirmationCon();
	$confirmation -> confirmacionPedidoCon($datosConfirmacion);

/*
response_code_pol=5
phone=
additional_value=0.00
test=1
transaction_date=2015-05-27 13:07:35
cc_number=************0004
cc_holder=test_buyer
error_code_bank=
billing_country=CO
bank_referenced_name=
description=test_payu_01
administrative_fee_tax=0.00
value=100.00
administrative_fee=0.00
payment_method_type=2
office_phone=
email_buyer=test@payulatam.com
response_message_pol=ENTITY_DECLINED
error_message_bank=
shipping_city=
transaction_id=f5e668f1-7ecc-4b83-a4d1-0aaa68260862
sign=e1b0939bbdc99ea84387bee9b90e4f5c
tax=0.00
payment_method=10
billing_address=cll 93
payment_method_name=VISA
pse_bank=
state_pol=6
date=2015.05.27 01:07:35
nickname_buyer=
reference_pol=7069375
currency=USD
risk=1.0
shipping_address=
bank_id=10
payment_request_state=R
customer_number=
administrative_fee_base=0.00
attempts=1
merchant_id=508029
exchange_rate=2541.15
shipping_country=
installments_number=1
franchise=VISA
payment_method_id=2
extra1=
extra2=
antifraudMerchantId=
extra3=
nickname_seller=
ip=190.242.116.98
airline_code=
billing_city=Bogota
pse_reference1=
reference_sale=2015-05-27 13:04:37
pse_reference3=
pse_reference2=
*/