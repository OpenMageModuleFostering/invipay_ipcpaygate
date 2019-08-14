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
require_once(dirname(__FILE__) ."/dto/ListFilter.class.php");
require_once(dirname(__FILE__) ."/dto/liabilitiesapiservice/CommissionInvoiceDetails.class.php");
require_once(dirname(__FILE__) ."/dto/liabilitiesapiservice/InterestInvoiceDetails.class.php");
require_once(dirname(__FILE__) ."/dto/liabilitiesapiservice/InterestNoteDetails.class.php");

class LiabilitiesApiClient extends AbstractRestApiClient
{
	protected function getServiceAddress(){ return '/liabilities'; }

	////////////////////////////////////////////////////////////////////////////

	public function getCommissionInvoice($id)
	{
		return $this->__call_ws_action('/ci/details', array('id' => $id), 'GET', 'CommissionInvoiceDetails');
	}

	public function listCommissionInvoices(ListFilter $filter)
	{
		return $this->__call_ws_action('/ci/list', $filter, 'POST', 'CommissionInvoiceDetails', true);
	}

	public function downloadCommissionInvoiceDocument($id)
	{
		return $this->__call_ws_action('/ci/document', array('id' => $id), 'GET', function($str){ return base64_decode($str); });
	}

	////////////////////////////////////////////////////////////////////////////

	public function getInterestInvoice($id)
	{
		return $this->__call_ws_action('/ii/details', array('id' => $id), 'GET', 'InterestInvoiceDetails');
	}

	public function listInterestInvoices(ListFilter $filter)
	{
		return $this->__call_ws_action('/ii/list', $filter, 'POST', 'InterestInvoiceDetails', true);
	}

	public function downloadInterestInvoiceDocument($id)
	{
		return $this->__call_ws_action('/ii/document', array('id' => $id), 'GET', function($str){ return base64_decode($str); });
	}

	////////////////////////////////////////////////////////////////////////////

	public function getInterestNote($id)
	{
		return $this->__call_ws_action('/in/details', array('id' => $id), 'GET', 'InterestNoteDetails');
	}

	public function listInterestNotes(ListFilter $filter)
	{
		return $this->__call_ws_action('/in/list', $filter, 'POST', 'InterestNoteDetails', true);
	}

	public function downloadInterestNoteDocument($id)
	{
		return $this->__call_ws_action('/in/document', array('id' => $id), 'GET', function($str){ return base64_decode($str); });
	}
}

?>