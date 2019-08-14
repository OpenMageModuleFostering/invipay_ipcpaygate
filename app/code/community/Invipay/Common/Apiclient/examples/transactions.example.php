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
require_once(dirname(__FILE__) ."/../TransactionsApiClient.class.php");

$api_config = getConfig();

$client = new TransactionsApiClient($api_config['url'], $api_config['apiKey'], $api_config['signatureKey']);

// createInvoice
{
	println('<h1>createInvoice</h1>');

	try
	{	
		$request = new InvoiceData();
		$request->setDocumentNumber('Test/'.uniqid());
		$request->setIssueDate(time() * 1000); // Note that you must provide date in miliseconds, not seconds
		$request->setDueDate($request->getIssueDate() + (7 * 24 * 60 * 60 * 1000)); // Due date == issue date + 7 days
		$request->setPriceGross(123);
		$request->setCurrency('PLN');
		$request->setNote('Test transaction from API');
		$request->setNoRisk(true);

		$contractor = new Contractor();
		$contractor->setName('Test contractor '.uniqid());
		$contractor->setTaxPayerNumber('5252553735');
		$contractor->setCompanyGovId('146665640');
		$contractor->setEmail('test@invipay.com');
		$contractor->setFax('12312123');
		$contractor->setPhone('234234234');
		$contractor->setWWW('www.esr24.pl');

		$contractorAccount = new BankAccount();
		$contractorAccount->setBankName('Test bank');
		$contractorAccount->setNumber('PL123123123123123123123');

		$contractor->setAccount($contractorAccount);

		$contractorAddress = new AddressData();
		$contractorAddress->setStreet('Test street 1/2');
		$contractorAddress->setCity('Testville');
		$contractorAddress->setPostCode('00-111');
		$contractorAddress->setCountryCode('PL');

		$contractor->setAddress($contractorAddress);

		$request->setContractor($contractor);

		$pdf = new FileData();
		$pdf->setFromFile(dirname(__FILE__).'/data/test.pdf');

		$request->setDocument($pdf);

		$result = $client->createInvoice($request);
		
		printDump('<h2>Request</h2>', $request);
		printDump('<h2>Result</h2>', $result);
	}
	catch (Exception $ex)
	{
		printDump('<h2>Exception</h2>', $ex);
	}

	println('<hr>');
}

// createOrder
{
	println('<h1>createOrder</h1>');

	try
	{	
		$request = new OrderData();
		$request->setDocumentNumber('Test/'.uniqid());
		$request->setIssueDate(time() * 1000); // Note that you must provide date in miliseconds, not seconds
		$request->setPriceGross(123);
		$request->setCurrency('PLN');
		$request->setNote('Test transaction from API');
		$request->setNoRisk(true);

		$contractor = new Contractor();
		$contractor->setName('Test contractor '.uniqid());
		$contractor->setTaxPayerNumber('9379535461');
		$contractor->setCompanyGovId('157381055');
		$contractor->setEmail('test@esr24.pl');
		$contractor->setFax('12312123');
		$contractor->setPhone('234234234');
		$contractor->setWWW('www.esr24.pl');

		$contractorAccount = new BankAccount();
		$contractorAccount->setBankName('Test bank');
		$contractorAccount->setNumber('PL123123123123123123123');

		$contractor->setAccount($contractorAccount);

		$contractorAddress = new AddressData();
		$contractorAddress->setStreet('Test street 1/2');
		$contractorAddress->setCity('Testville');
		$contractorAddress->setPostCode('00-111');
		$contractorAddress->setCountryCode('PL');

		$contractor->setAddress($contractorAddress);

		$request->setContractor($contractor);

		$pdf = new FileData();
		$pdf->setFromFile(dirname(__FILE__).'/data/test.pdf');

		$request->setDocument($pdf);

		$result = $client->createOrder($request);
		
		printDump('<h2>Request</h2>', $request);
		printDump('<h2>Result</h2>', $result);
	}
	catch (Exception $ex)
	{
		printDump('<h2>Exception</h2>', $ex);
	}

	println('<hr>');
}

$randomItemId = null;
$randomItemAttachmentId = null;

// listTransactions
{
	println('<h1>listTransactions</h1>');

	try
	{
		$filter = new TransactionsFilter();
		$filter->setSide(TransactionSide::SALE);

		$result = $client->listTransactions($filter, $api_config['apiKey']);

		$randomItemIndex = array_rand($result);
		
		if ($randomItemIndex !== false && $randomItemIndex !== null)
		{
			$randomItemId = $result[$randomItemIndex]->getId();
			$randomItemAttachmentId = $result[$randomItemIndex]->getAttachment() !== null ? $result[$randomItemIndex]->getAttachment()->getId() : null;
		}
		
		printDump('<h2>Request</h2>', $filter);
		printDump('<h2>Result</h2>', $result);
	}
	catch (Exception $ex)
	{
		printDump('<h2>Exception</h2>', $ex);
	}

	println('<hr>');
}

// getTransaction
{
	println('<h1>getTransaction</h1>');
	try
	{
		$result = $client->getTransaction($randomItemId);

		printDump('<h2>Result</h2>', $result);
	}
	catch (Exception $ex)
	{
		printDump('<h2>Exception</h2>', $ex);
	}

	println('<hr>');
}

// downloadCommissionInvoiceDocument
{
	println('<h1>downloadDocument</h1>');

	try
	{
		if ($randomItemAttachmentId !== null)
		{
			$result = $client->downloadDocument($randomItemAttachmentId);
			$outputPath = dirname(__FILE__).'/output/'.$randomItemAttachmentId.'.pdf';
			file_put_contents($outputPath, $result);

			printDump('<h2>Result</h2>', $outputPath);
		}
		else
		{
			printDump('<h2>Result</h2>', null);
		}
	}
	catch (Exception $ex)
	{
		printDump('<h2>Exception</h2>', $ex);
	}

	println('<hr>');
}

?>