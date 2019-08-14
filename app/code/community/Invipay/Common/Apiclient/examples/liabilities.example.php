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
require_once(dirname(__FILE__) ."/../LiabilitiesApiClient.class.php");

$api_config = getConfig();

$client = new LiabilitiesApiClient($api_config['url'], $api_config['apiKey'], $api_config['signatureKey']);

// Commission Invoices
{
	$randomItemId = null;
	$randomItemAttachmentId = null;

	// listCommissionInvoices
	{
		println('<h1>listCommissionInvoices</h1>');

		try
		{
			$filter = new ListFilter();

			$result = $client->listCommissionInvoices($filter);

			$randomItemIndex = array_rand($result);
			if ($randomItemIndex !== null)
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

	// getCommissionInvoice
	{
		println('<h1>getCommissionInvoice</h1>');
		try
		{
			if ($randomItemId !== null )
			{
				$result = $client->getCommissionInvoice($randomItemId);
				printDump('<h2>Result</h2>', $result);
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

	// downloadCommissionInvoiceDocument
	{
		println('<h1>downloadCommissionInvoiceDocument</h1>');

		try
		{
			if ($randomItemAttachmentId !== null)
			{
				$result = $client->downloadCommissionInvoiceDocument($randomItemAttachmentId);
				$outputPath = 'output/'.$randomItemAttachmentId.'.pdf';
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
}

// Interest Invoices
{
	$randomItemId = null;
	$randomItemAttachmentId = null;

	// listCommissionInvoices
	{
		println('<h1>listInterestInvoices</h1>');

		try
		{
			$filter = new ListFilter();

			$result = $client->listInterestInvoices($filter);

			$randomItemIndex = array_rand($result);
			if ($randomItemIndex !== null)
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

	// getInterestInvoice
	{
		println('<h1>getInterestInvoice</h1>');
		try
		{
			if ($randomItemId !== null)
			{
				$result = $client->getInterestInvoice($randomItemId);
				printDump('<h2>Result</h2>', $result);
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

	// downloadCommissionInvoiceDocument
	{
		println('<h1>downloadInterestInvoiceDocument</h1>');

		try
		{
			if ($randomItemAttachmentId !== null)
			{
				$result = $client->downloadInterestInvoiceDocument($randomItemAttachmentId);
				$outputPath = 'output/'.$randomItemAttachmentId.'.pdf';
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
}


// Interest notes
{
	$randomItemId = null;
	$randomItemAttachmentId = null;

	// listCommissionInvoices
	{
		println('<h1>listInterestNotes</h1>');

		try
		{
			$filter = new ListFilter();

			$result = $client->listInterestNotes($filter);

			$randomItemIndex = array_rand($result);
			if ($randomItemIndex !== null)
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

	// getInterestNote
	{
		println('<h1>getInterestNote</h1>');
		try
		{
			if ($randomItemId !== null)
			{
				$result = $client->getInterestNote($randomItemId);
				printDump('<h2>Result</h2>', $result);
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

	// downloadInterestNoteDocument
	{
		println('<h1>downloadInterestNoteDocument</h1>');

		try
		{
			if ($randomItemAttachmentId !== null)
			{
				$result = $client->downloadInterestNoteDocument($randomItemAttachmentId);
				$outputPath = 'output/'.$randomItemAttachmentId.'.pdf';
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
}