<?php

class Invipay_Ipcpaygate_Block_Form_CheckoutLabel extends Mage_Core_Block_Template
{
	protected function _construct()
	{
		$this->setTemplate('ipcpaygate/form/checkout_label.phtml');
	}

	public function getLabelTitle()
	{
		$output = Mage::getStoreConfig('payment/ipcpaygate/title');

		$exploded = explode('(', $output, 2);

		$output = $exploded[0] . (count($exploded) > 1 ? '(' . str_replace(' ', '&nbsp;', $exploded[1]) : '');

		return $output;
	}
}

class Invipay_Ipcpaygate_Block_Form_Checkout extends Mage_Payment_Block_Form
{

	protected function _construct()
	{
		$label = new Invipay_Ipcpaygate_Block_Form_CheckoutLabel();
		$this->setTemplate('ipcpaygate/form/checkout.phtml');
		$this->setMethodTitle('');
		$this->setMethodLabelAfterHtml($label->toHtml());
	}

	public function getBaseDueDate()
	{
		return $this->getMethod()->getConfigData('invipay_base_duedate');
	}

	public function getTotalDueDate()
	{
		return $this->getMethod()->getConfigData('invipay_base_duedate') + 7;
	}
}