<?php

class Invipay_Ipcpaygate_Block_Redirect extends Mage_Core_Block_Template
{
	protected $redirectUrl;

	public function _construct()
	{
		parent::_construct();
		$this->setTemplate('ipcpaygate/redirect.phtml');
	}

	public function setRedirectUrl($url)
	{
		$this->redirectUrl = $url;
	}

	public function getRedirectUrl()
	{
		return $this->redirectUrl;
	}
}

?>