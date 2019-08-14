<?php

class Invipay_Ipcpaygate_Block_Widgets_Footericon extends Mage_Core_Block_Template
{
	protected $enabled = true;
	protected $text = 'Wybierz zakup na fakturę z inviPay.com';

	public function _construct()
	{
		parent::_construct();
		$this->enabled = intval(Mage::getStoreConfig('payment/ipcpaygate/invipay_widgets_footericon')) && intval(Mage::getStoreConfig('payment/ipcpaygate/active'));
		$this->text = Mage::getStoreConfig('payment/ipcpaygate/title');
		$this->setTemplate('ipcpaygate/widgets/footericon.phtml');
	}

	public function getEnabled()
	{
		return $this->enabled;
	}

	public function getText()
	{
		return $this->text;
	}
}

?>