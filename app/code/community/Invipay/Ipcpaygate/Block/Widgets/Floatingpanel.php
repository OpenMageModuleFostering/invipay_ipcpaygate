<?php

class Invipay_Ipcpaygate_Block_Widgets_Floatingpanel extends Mage_Core_Block_Template
{
	protected $enabled = true;
	protected $style = 'right';
	protected $dueDateDays = 14;
	protected $minOrderTotal = 200;

	public function _construct()
	{
		parent::_construct();
		$this->style = Mage::getStoreConfig('payment/ipcpaygate/invipay_widgets_floatingpanel');
		$this->enabled = $this->style !== 'none' && Mage::getStoreConfig('payment/ipcpaygate/active');
		$this->dueDateDays = intval(Mage::getStoreConfig('payment/ipcpaygate/invipay_base_duedate'));
		$this->minOrderTotal = Mage::getStoreConfig('payment/ipcpaygate/min_order_total');
		$this->setTemplate('ipcpaygate/widgets/floatingpanel.phtml');
	}
	
	public function getEnabled()
	{
		return $this->enabled;
	}

	public function getStyle()
	{
		return $this->style;
	}

	public function getDueDateDays()
	{
		return $this->dueDateDays;
	}

	public function getMinOrderTotal()
	{
		return $this->minOrderTotal;
	}
}

?>