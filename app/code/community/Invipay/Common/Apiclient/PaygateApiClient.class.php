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
require_once(dirname(__FILE__) ."/dto/paygateapiservice/PaymentStartInfo.class.php");
require_once(dirname(__FILE__) ."/dto/paygateapiservice/PaymentData.class.php");
require_once(dirname(__FILE__) ."/dto/paygateapiservice/PaymentCreationData.class.php");
require_once(dirname(__FILE__) ."/dto/paygateapiservice/PaymentManagementData.class.php");

class PaygateApiClient extends AbstractRestApiClient
{
	protected function getServiceAddress(){ return '/paygate'; }

	////////////////////////////////////////////////////////////////////////////

	public function paymentStatusFromCallbackPost($callbackDataFormat)
	{
		return $this->paymentStatusFromCallback(file_get_contents('php://input'), $callbackDataFormat);
	}

	public function paymentStatusFromCallback($callbackData, $callbackDataFormat = CallbackDataFormat::JSON)
	{
		$output = null;

		switch ($callbackDataFormat) {
			case CallbackDataFormat::JSON: $output = $this->__mapArrayToObject(json_decode($callbackData, true), 'PaymentData', false); break;
			case CallbackDataFormat::XML: $output = $this->__mapArrayToObject($this->__xmlToArray($callbackData), 'PaymentData', false); break;
			default: break;
		}

		return $output;
	}

	////////////////////////////////////////////////////////////////////////////

	public function createPayment(PaymentCreationData $paymentData)
	{
		return $this->__call_ws_action('/create', $paymentData, 'POST', 'PaymentStartInfo');
	}

	public function getPayment($id)
	{
		return $this->__call_ws_action('/details', array('id' => $id), 'GET', 'PaymentData');
	}

	public function managePayment(PaymentManagementData $managementData)
	{
		return $this->__call_ws_action('/manage', $managementData, 'POST', 'PaymentData');
	}
}

?>