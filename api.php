<?php
defined( 'ABSPATH' ) || exit;

function getToken() {
	$curl = curl_init();
	$headers = array(
    	'Content-Type:application/json',
    	'Authorization: Basic '. base64_encode("username:password")
	);
	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://merchant-sandbox.qpay.mn/v2/auth/token",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => $headers,
	));

	$response = curl_exec($curl);
	curl_close($curl);
	
	return json_decode($response, true);
}
$token = getToken();
$access_token = $token["access_token"];

$curl = curl_init();
$post_array = array(
    	"invoice_code"=> "invoice_code",
	"sender_invoice_no"=> "5646542",
	"invoice_receiver_code"=> "terminal",
	"invoice_description"=>"test",
	"amount"=>100,
	"callback_url"=>"https://bd5492c3ee85.ngrok.io/payments?payment_id=5646542"
);

$post_data = json_encode($post_array);

curl_setopt_array($curl, array(
	CURLOPT_URL => "https://merchant-sandbox.qpay.mn/v2/invoice",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => $post_data,
	CURLOPT_HTTPHEADER => array(
		"Content-Type: application/json",
		"Authorization: Bearer " . $access_token
	),
));
$response = curl_exec($curl);
$qpay = json_decode($response, true);
?>
