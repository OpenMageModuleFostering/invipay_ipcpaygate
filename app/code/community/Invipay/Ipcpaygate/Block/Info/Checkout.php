<?php

class Invipay_Ipcpaygate_Block_Info_Checkout extends Mage_Payment_Block_Info
{
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('ipcpaygate/form/checkout_info.phtml');
	}

	public function getLabelTitle()
	{
		return Mage::getStoreConfig('payment/ipcpaygate/title');
	}
}