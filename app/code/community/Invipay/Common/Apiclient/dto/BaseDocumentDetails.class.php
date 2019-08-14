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

require_once(dirname(__FILE__) ."/BaseApiData.class.php");
require_once(dirname(__FILE__) ."/Contractor.class.php");
require_once(dirname(__FILE__) ."/DocumentAttachmentDownloadInfo.class.php");

abstract class BaseDocumentDetails extends BaseApiData
{
	protected $id;
	protected $documentNumber;
	protected $contractor;
	protected $totalGross;
	protected $totalNet;
	protected $totalTax;
	protected $currency;
	protected $issueDate;
	protected $dueDate;
	protected $attachment;

	public function getId(){ return $this->id; }
	public function setId($id){ $this->id = $id; }

	public function getDocumentNumber(){ return $this->documentNumber; }
	public function setDocumentNumber($documentNumber){ $this->documentNumber = $documentNumber; }

	public function getContractor(){ return $this->contractor; }

	public function setContractor(Contractor $contractor){ $this->contractor = $contractor; }

	public function getTotalGross(){ return $this->totalGross; }
	public function setTotalGross($totalGross){ $this->totalGross = $totalGross; }

	public function getTotalNet(){ return $this->totalNet; }
	public function setTotalNet($totalNet){ $this->totalNet = $totalNet; }

	public function getTotalTax(){ return $this->totalTax; }
	public function setTotalTax($totalTax){ $this->totalTax = $totalTax; }

	public function getCurrency(){ return $this->currency; }
	public function setCurrency($currency){ $this->currency = $currency; }

	public function getIssueDate(){ return $this->issueDate; }
	public function setIssueDate($issueDate){ $this->issueDate = $issueDate; }

	public function getDueDate(){ return $this->dueDate; }
	public function setDueDate($dueDate){ $this->dueDate = $dueDate; }

	public function getAttachment(){ return $this->attachment; }
	public function setAttachment(DocumentAttachmentDownloadInfo $attachment){ $this->attachment = $attachment; }
}

?>