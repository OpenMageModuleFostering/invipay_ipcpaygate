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
require_once(dirname(__FILE__) ."/AccountantReportSaleItem.class.php");
require_once(dirname(__FILE__) ."/AccountantReportPurchaseItem.class.php");
require_once(dirname(__FILE__) ."/AccountantReportSettlementItem.class.php");
require_once(dirname(__FILE__) ."/AccountantReportCommissionInvoiceItem.class.php");
require_once(dirname(__FILE__) ."/AccountantReportInterestInvoiceItem.class.php");
require_once(dirname(__FILE__) ."/AccountantReportInterestNoteItem.class.php");
require_once(dirname(__FILE__) ."/AccountantReportPaymentItem.class.php");
require_once(dirname(__FILE__) ."/AccountantReportPayoffItem.class.php");
require_once(dirname(__FILE__) ."/AccountantReportResaleStatementItem.class.php");
require_once(dirname(__FILE__) ."/AccountantReportRSReversedSettlementItem.class.php");
require_once(dirname(__FILE__) ."/AccountantReportRSSettlementItem.class.php");
require_once(dirname(__FILE__) ."/AccountantReportRSPSettlementItem.class.php");
require_once(dirname(__FILE__) ."/AccountantReportRSBItem.class.php");

class AccountantReportDocument
{
	protected $id;
	protected $createdAt;
	protected $clientName;
	protected $clientNIP;
	protected $collectedFrom;
	protected $collectedTo;

	protected $sales = array();
	protected $purchases = array();
	protected $settlements = array();
	protected $commissionInvoices = array();
	protected $interestInvoices = array();
	protected $interestNotes = array();
	protected $payments = array();
	protected $overpayments = array();
	protected $payoffs = array();
	protected $resaleStatements = array();
	protected $rsReversedSettlements = array();
	protected $rsSettlements = array();
	protected $rspSettlements = array();
	protected $rsbs = array();

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getCreatedAt(){
		return $this->createdAt;
	}

	public function setCreatedAt($createdAt){
		$this->createdAt = $createdAt;
	}

	public function getClientName(){
		return $this->clientName;
	}

	public function setClientName($clientName){
		$this->clientName = $clientName;
	}

	public function getClientNIP(){
		return $this->clientNIP;
	}

	public function setClientNIP($clientNIP){
		$this->clientNIP = $clientNIP;
	}

	public function getCollectedFrom(){
		return $this->collectedFrom;
	}

	public function setCollectedFrom($collectedFrom){
		$this->collectedFrom = $collectedFrom;
	}

	public function getCollectedTo(){
		return $this->collectedTo;
	}

	public function setCollectedTo($collectedTo){
		$this->collectedTo = $collectedTo;
	}

	public function getSales(){
		return $this->sales;
	}

	public function setSales(array $sales, AccountantReportSaleItem $itemTypeHint = null){
		$this->sales = $sales;
	}

	public function getPurchases(){
		return $this->purchases;
	}

	public function setPurchases(array $purchases, AccountantReportPurchaseItem $itemTypeHint = null){
		$this->purchases = $purchases;
	}

	public function getSettlements(){
		return $this->settlements;
	}

	public function setSettlements(array $settlements, AccountantReportSettlementItem $itemTypeHint = null){
		$this->settlements = $settlements;
	}

	public function getCommissionInvoices(){
		return $this->commissionInvoices;
	}

	public function setCommissionInvoices(array $commissionInvoices, AccountantReportCommissionInvoiceItem $itemTypeHint = null){
		$this->commissionInvoices = $commissionInvoices;
	}

	public function getInterestInvoices(){
		return $this->interestInvoices;
	}

	public function setInterestInvoices(array $interestInvoices, AccountantReportInterestInvoiceItem $itemTypeHint = null){
		$this->interestInvoices = $interestInvoices;
	}

	public function getInterestNotes(){
		return $this->interestNotes;
	}

	public function setInterestNotes(array $interestNotes, AccountantReportInterestNoteItem $itemTypeHint = null){
		$this->interestNotes = $interestNotes;
	}

	public function getPayments(){
		return $this->payments;
	}

	public function setPayments(array $payments, AccountantReportPaymentItem $itemTypeHint = null){
		$this->payments = $payments;
	}

	public function getOverpayments(){
		return $this->overpayments;
	}

	public function setOverpayments(array $overpayments, AccountantReportPaymentItem $itemTypeHint = null){
		$this->overpayments = $overpayments;
	}

	public function getPayoffs(){
		return $this->payoffs;
	}

	public function setPayoffs(array $payoffs, AccountantReportPayoffItem $itemTypeHint = null){
		$this->payoffs = $payoffs;
	}

	public function getResaleStatements(){
		return $this->resaleStatements;
	}

	public function setResaleStatements(array $resaleStatements, AccountantReportResaleStatementItem $itemTypeHint = null){
		$this->resaleStatements = $resaleStatements;
	}

	public function getRsReversedSettlements(){
		return $this->rsReversedSettlements;
	}

	public function setRsReversedSettlements(array $rsReversedSettlements, AccountantReportRSReversedSettlementItem $itemTypeHint = null){
		$this->rsReversedSettlements = $rsReversedSettlements;
	}

	public function getRsSettlements(){
		return $this->rsSettlements;
	}

	public function setRsSettlements(array $rsSettlements, AccountantReportRSSettlementItem $itemTypeHint = null){
		$this->rsSettlements = $rsSettlements;
	}

	public function getRspSettlements(){
		return $this->rspSettlements;
	}

	public function setRspSettlements(array $rspSettlements, AccountantReportRSPSettlementItem $itemTypeHint = null){
		$this->rspSettlements = $rspSettlements;
	}

	public function getRsbs(){
		return $this->rsbs;
	}

	public function setRsbs(array $rsbs, AccountantReportRSBItem $itemTypeHint = null){
		$this->rsbs = $rsbs;
	}
}

?>