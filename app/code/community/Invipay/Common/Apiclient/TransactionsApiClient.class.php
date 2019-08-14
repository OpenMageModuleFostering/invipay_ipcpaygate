<?php

/**
*	Copyright (C) 2016 inviPay.com
*	
*	http://www.invipay.com
*
*	@author Kuba Pilecki (kpilecki@invipay.com)
* 	@version 1.0.4
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

require_once(dirname(__FILE__) ."/lib/AbstractRestApiClient.class.php");
require_once(dirname(__FILE__) ."/dto/transactionapiservice/InvoiceData.class.php");
require_once(dirname(__FILE__) ."/dto/transactionapiservice/OrderData.class.php");
require_once(dirname(__FILE__) ."/dto/transactionapiservice/TransactionDetails.class.php");
require_once(dirname(__FILE__) ."/dto/transactionapiservice/TransactionItemDetails.class.php");
require_once(dirname(__FILE__) ."/dto/transactionapiservice/TransactionsFilter.class.php");
require_once(dirname(__FILE__) ."/dto/transactionapiservice/TransactionSide.enum.php");
require_once(dirname(__FILE__) ."/dto/transactionapiservice/TransactionType.enum.php");
require_once(dirname(__FILE__) ."/dto/FileInfo.class.php");

class TransactionsApiClient extends AbstractRestApiClient
{
	protected function getServiceAddress(){ return '/transactions'; }

	////////////////////////////////////////////////////////////////////////////

	public function createInvoice(InvoiceData $data)
	{
		return $this->__call_ws_action('/createInvoice', $data, 'POST', 'TransactionDetails');
	}

	public function createOrder(OrderData $data)
	{
		return $this->__call_ws_action('/createOrder', $data, 'POST', 'TransactionDetails');
	}

	public function getTransaction($id)
	{
		return $this->__call_ws_action('/details', array('id' => $id), 'GET', 'TransactionDetails');
	}

	public function listTransactions(TransactionsFilter $filter)
	{
		return $this->__call_ws_action('/list', $filter, 'POST', 'TransactionDetails', true);
	}

	public function getDocumentInfo($id)
	{
		return $this->__call_ws_action('/document_info', array('id' => $id), 'GET', 'FileInfo');
	}

	public function downloadDocument($id)
	{
		return $this->__call_ws_action('/document', array('id' => $id), 'GET', function($str){ return base64_decode($str); });
	}
}

?>