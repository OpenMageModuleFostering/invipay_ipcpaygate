<?php

class Invipay_Ipcpaygate_Block_Widgets_Basketinfo extends Mage_Core_Block_Template
{
	protected $enabled = true;
	protected $dueDateDays = 14;

	public function _construct()
	{
		parent::_construct();
		$this->enabled = intval(Mage::getStoreConfig('payment/ipcpaygate/invipay_widgets_basketinfo')) && Mage::getStoreConfig('payment/ipcpaygate/active');
		$this->dueDateDays = Mage::getStoreConfig('payment/ipcpaygate/invipay_base_duedate');
		$this->setTemplate('ipcpaygate/widgets/basketinfo.phtml');
	}

	public function getEnabled()
	{
		return $this->enabled;
	}

	public function getDueDateDays()
	{
		return $this->dueDateDays;
	}
}

?>