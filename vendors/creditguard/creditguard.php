<?php
function calcMAC($key,$iv,$postReq){
	//Calculate the MAC by SHA256 the postReq, Pack() + padding, encrypt by the key + iv (AES) and return
	return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, base64_decode($key), pack('H*', hash('sha256', $postReq) . '10101010101010101010101010101010'), MCRYPT_MODE_CBC, base64_decode($iv)));
}

function postRequest($uniqueID,$key,$iv,$url,$userName,$password,$MID,$terminal,$mainTerminalNumber,$amount,$currency,$transactionType,$creditType,$transactionCode,$authNumber,$numberOfPayments,$firstPayment,$periodicalPayment,$validationType,$dealerNumber,$description,$email,$langID,$clientIP,$xRem,$userData1,$userData2,$userData3,$userData4,$userData5,$userData6,$userData7,$userData8,$userData9,$userData10){

	//Set the request String
	$finalRequest = "userName=".$userName."&password=".$password."&MID=".$MID."&terminal=".$terminal."&mainTerminalNumber=".$mainTerminalNumber."&uniqueID=".$uniqueID."&amount=".$amount."&currency=".$currency."&transactionType=".$transactionType."&creditType=".$creditType."&transactionCode=".$transactionCode."&authNumber=".$authNumber."&numberOfPayments=".$numberOfPayments."&firstPayment=".$firstPayment."&periodicalPayment=".$periodicalPayment."&validationType=".$validationType."&dealerNumber=".$dealerNumber."&description=".$description."&email=".$email."&langID=".$langID."&timestamp=".date('Y-m-d\TH:i:s')."&clientIP=".$clientIP."&xRem=".$xRem."&userData1=".$userData1."&userData2=".$userData2."&userData3=".$userData3."&userData4=".$userData4."&userData5=".$userData5."&userData6=".$userData6."&userData7=".$userData7."&userData8=".$userData8."&userData9=".$userData9."&userData10=".$userData10."&saleDetailsMAC=";
	if ($key!="")
		$finalRequest.=urlencode(calcMAC($key,$iv,$finalRequest));
	
	//Sending POST request
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);

	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_VERBOSE, 1); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

	curl_setopt ($ch, CURLOPT_POSTFIELDS, $finalRequest);
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$response=curl_exec($ch);
	
	if(!curl_errno($ch)){ 
  $info = curl_getinfo($ch); 
  //echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url']; 
} else { 
  echo 'Curl error: ' . curl_error($ch); 
} 


	curl_close($ch);

	
	//Return POST Request response
	return $response;
}
 

?>