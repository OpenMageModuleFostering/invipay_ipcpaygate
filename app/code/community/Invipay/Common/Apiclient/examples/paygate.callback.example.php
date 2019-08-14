<?php

/**
*	Copyright (C) 2016 inviPay.com
*	
*	http://www.invipay.com
*
*	Redistribution and use in source and binary forms, with or
*	without modification, are permitted provided that the following
*	conditions are met: Redistributions of source code must retain the
*	above copyright notice, this list of conditions and the following
*	disclaimer. Redistributions in binary form must reproduce the above
*	copyright notice, this list of conditions and the following disclaimer
*	in the documentation and/or other materials provided with the
*	distribution.
*	
*	THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED
*	WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
*	MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN
*	NO EVENT SHALL CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
*	INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
*	BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS
*	OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
*	ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR
*	TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE
*	USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH
*	DAMAGE.
*/

ob_start();

require_once(dirname(__FILE__) ."/example.common.php");
require_once(dirname(__FILE__) ."/../PaygateApiClient.class.php");

$api_config = getConfig();

$client = new PaygateApiClient($api_config['url'], $api_config['apiKey'], $api_config['signatureKey']);

$paymentData = $client->paymentStatusFromCallbackPost(CallbackDataFormat::JSON);

if ($paymentData !== null)
{
	$outputPath = dirname(__FILE__).'/output/' . $paymentData->getPaymentId() . '.payment.status.txt';
	file_put_contents($outputPath, print_r($paymentData, true));
}

{
	$outputPath = dirname(__FILE__).'/output/payment.debug.txt';
	$outputData = 	
					"Script execution flush:\r\n-----\r\n" .
					ob_get_flush() . 
					"\r\n\r\n" . 
					"Last error:\r\n-----\r\n" .
					print_r(error_get_last(), true) .
					"\r\n\r\n" . 
					"Script input data:\r\n-----\r\n" .
					file_get_contents('php://input');
	file_put_contents($outputPath, $outputData);
}



?>