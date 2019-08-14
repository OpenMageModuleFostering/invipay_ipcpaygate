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

class TransactionItemDetails
{
	protected $id;
	protected $name;
	protected $description;
	protected $code;
	protected $priceGross;
	protected $priceNet;
	protected $priceTax;
	protected $quantity;
	protected $quantityUnit;
	protected $totalPriceGross;
	protected $totalPriceNet;
	protected $totalPriceTax;

	public function getId(){ return $this->id; }
	public function setId($id){ $this->id = $id; }

	public function getName(){ return $this->name; }
	public function setName($name){ $this->name = $name; }

	public function getDescription(){ return $this->description; }
	public function setDescription($description){ $this->description = $description; }

	public function getCode(){ return $this->code; }
	public function setCode($code){ $this->code = $code; }

	public function getPriceGross(){ return $this->priceGross; }
	public function setPriceGross($priceGross){ $this->priceGross; } 

	public function getPriceNet(){ return $this->priceNet; }
	public function setPriceNet($priceNet){ $this->priceNet = $priceNet; }

	public function getPriceTax(){ return $this->priceTax; }
	public function setPriceTax($priceTax){ $this->priceTax; }

	public function getQuantity(){ return $this->quantity; }
	public function setQuantity($quantity){ $this->quantity = $quantity; }

	public function getQuantityUnit(){ return $this->quantityUnit; }
	public function setQuantityUnit($quantityUnit){ $this->quantityUnit = $quantityUnit; }

	public function getTotalPriceGross(){ return $this->totalPriceGross; }
	public function setTotalPriceGross($totalPriceGross){ $this->totalPriceGross = $totalPriceGross; }

	public function getTotalPriceTax(){ return $this->totalPriceTax; }
	public function setTotalPriceTax($totalPriceTax){ $this->totalPriceTax = $totalPriceTax; }
}

?>