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

require_once(dirname(__FILE__) ."/example.common.php");
require_once(dirname(__FILE__) ."/../PaygateApiClient.class.php");

$api_config = getConfig();

$client = new PaygateApiClient($api_config['url'], $api_config['apiKey'], $api_config['signatureKey']);

$paymentId = null;

// Create new payment
{
	println('<h1>createPayment</h1>');

	$request = new PaymentCreationData();
	$request->setReturnUrl("http://your.server.com/payment/return");
	$request->setStatusUrl("http://your.server.com/payment/status");
	$request->setStatusDataFormat(CallbackDataFormat::JSON);
	$request->setDocumentNumber("No risk ąśłśł ustawiony ręcznie " . uniqid());
	$request->setIssueDate('2016-02-01');
	$request->setDueDate('2016-03-21');
	$request->setPriceGross(123.00);
	$request->setCurrency("PLN");
	$request->setNote("My note");
	$request->setNoRisk(true);
	$request->setIsInvoice(false);
	$request->setBuyerGovId('7895653737');
	$request->setBuyerEmail('test@test.pl');

	try
	{
		$result = $client->createPayment($request);

		$paymentId = $result->getPaymentId();

		printDump('<h2>Request</h2>', $request);
		printDump('<h2>Result</h2>', $result);
	}
	catch (Exception $ex)
	{
		printDump('<h2>Exception</h2>', $ex);
	}


	println('<hr>');
}

// // Get payment current informations
// {
// 	println('<h1>getPayment</h1>');

// 	try
// 	{	
// 		$result = $client->getPayment($paymentId);
		
// 		printDump('<h2>Result</h2>', $result);
// 	}
// 	catch (Exception $ex)
// 	{
// 		printDump('<h2>Exception</h2>', $ex);
// 	}

// 	println('<hr>');
// }

// // Manage payment
// {
// 	println('<h1>managePayment</h1>');

// 	try
// 	{	
// 		$request = new PaymentManagementData();
// 		$request->setPaymentId($paymentId);
// 		$request->setDoConfirmDelivery(true);

// 		{
// 			$conversionData = new OrderToInvoiceData();
// 			$conversionData->setInvoiceDocumentNumber("TestInvoice/1/2/3/".uniqid());
// 			$conversionData->setIssueDate(time() * 1000);
// 			$conversionData->setDueDate((time() + 60 * 60 * 24 * 7) * 1000);

// 			$request->setConversionData($conversionData);
// 		}

// 		{
// 			$document = new FileData();
// 			$document->setFromFile(dirname(__FILE__).'/data/test.pdf');

// 			$request->setDocument($document);
// 		}

// 		$result = $client->managePayment($request);
		
// 		printDump('<h2>Result</h2>', $result);
// 	}
// 	catch (Exception $ex)
// 	{
// 		printDump('<h2>Exception</h2>', $ex);
// 	}

// 	println('<hr>');
// }


// ?>