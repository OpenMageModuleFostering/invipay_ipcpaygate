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

require_once(dirname(__FILE__) ."/DocumentItem.class.php");

class AccountantReportPaymentItem extends DocumentItem
{
	private $paymentDate;
	private $value;
	private $documentId;
	private $confirmationDocumentId;
	private $settlementValue;
	private $settlementDate;
	private $targetKind;
	private $targetDocumentId;

	public function getPaymentDate(){
		return $this->paymentDate;
	}

	public function setPaymentDate($paymentDate){
		$this->paymentDate = $paymentDate;
	}

	public function getValue(){
		return $this->value;
	}

	public function setValue($value){
		$this->value = $value;
	}

	public function getDocumentId(){
		return $this->documentId;
	}

	public function setDocumentId($documentId){
		$this->documentId = $documentId;
	}

	public function getConfirmationDocumentId(){
		return $this->confirmationDocumentId;
	}

	public function setConfirmationDocumentId($confirmationDocumentId){
		$this->confirmationDocumentId = $confirmationDocumentId;
	}

	public function getSettlementValue(){
		return $this->settlementValue;
	}

	public function setSettlementValue($settlementValue){
		$this->settlementValue = $settlementValue;
	}

	public function getSettlementDate(){
		return $this->settlementDate;
	}

	public function setSettlementDate($settlementDate){
		$this->settlementDate = $settlementDate;
	}

	public function getTargetKind(){
		return $this->targetKind;
	}

	public function setTargetKind($targetKind){
		$this->targetKind = $targetKind;
	}

	public function getTargetDocumentId(){
		return $this->targetDocumentId;
	}

	public function setTargetDocumentId($targetDocumentId){
		$this->targetDocumentId = $targetDocumentId;
	}
}

?>