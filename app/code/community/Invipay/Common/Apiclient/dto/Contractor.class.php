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

require_once(dirname(__FILE__) ."/AddressData.class.php");
require_once(dirname(__FILE__) ."/BankAccount.class.php");

class Contractor
{
	protected $name;
	protected $taxPayerNumber;
	protected $companyGovId;
	protected $email;
	protected $fax;
	protected $phone;
	protected $WWW;
	protected $account;
	protected $address;

	public function getName(){ return $this->name; }
	public function setName($name){ $this->name = $name; }

	public function getTaxPayerNumber(){ return $this->taxPayerNumber; }
	public function setTaxPayerNumber($taxPayerNumber){ $this->taxPayerNumber = $taxPayerNumber; }

	public function getCompanyGovId(){ return $this->companyGovId; }
	public function setCompanyGovId($companyGovId){ $this->companyGovId = $companyGovId; }

	public function getEmail(){ return $this->email; }
	public function setEmail($email){ $this->email = $email; }

	public function getFax(){ return $this->fax; }
	public function setFax($fax){ $this->fax = $fax; }

	public function getPhone(){ return $this->phone; }
	public function setPhone($phone){ $this->phone = $phone; }

	public function getWWW(){ return $this->WWW; }
	public function setWWW($WWW){ $this->WWW = $WWW; }

	public function getAccount(){ return $this->account; }
	public function setAccount(BankAccount $account){ $this->account = $account; }

	public function getAddress(){ return $this->address; }
	public function setAddress(AddressData $address){ $this->address = $address; }
}

?>