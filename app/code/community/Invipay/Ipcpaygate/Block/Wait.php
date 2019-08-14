<?php

class Invipay_Ipcpaygate_Block_Wait extends Mage_Core_Block_Template
{
	protected $orderId;

	public function _construct()
	{
		parent::_construct();
		$this->setTemplate('ipcpaygate/wait.phtml');
	}

	public function setOrderId($oid)
	{
		$this->orderId = $oid;
	}

	public function getOrderId()
	{
		return $this->orderId;
	}
}

?>