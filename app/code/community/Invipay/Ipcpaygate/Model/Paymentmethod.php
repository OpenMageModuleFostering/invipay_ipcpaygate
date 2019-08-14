<?php

class Invipay_Ipcpaygate_Model_Paymentmethod extends Mage_Payment_Model_Method_Abstract
{
	protected $_code  = 'ipcpaygate';
	protected $_formBlockType = 'ipcpaygate/form_checkout';
	protected $_infoBlockType = 'ipcpaygate/info_checkout';

	public function canUseCheckout()
	{
		return true;
	}

	public function validate()
	{
		parent::validate();

		$info = $this->getInfoInstance();
		
		if ($info !== null)
		{
			$quote = $info->getQuote();

			if ($quote !== null)
			{
				$taxvat = Mage::helper('ipcpaygate')->getNipFromQuote($quote);

				if ($taxvat === null || trim($taxvat) == '')
				{
					Mage::throwException('Brak numeru NIP, dla tego zamówienia, wybrana metoda płatności dostępna jest tylko dla firm.');
				}

				if (!$this->validateNip($taxvat))
				{
		      		Mage::throwException('Podany, dla tego zamówienia, numer NIP (' . $taxvat . ') jest błędny, wybrana metoda płatności wymaga poprawnego numeru NIP klienta.');
				}
			}
		}

		return $this;
	}


	public function getOrderPlaceRedirectUrl()
	{
		return Mage::getUrl('ipcpaygate/payment/redirect', array());
	}

	protected function validateNip($nip)
	{
		$nip = preg_replace('/[^0-9]*/', '', $nip);
		$nsize = strlen($nip);
		if ($nsize != 10) {
			return false;
		}

		$weights = array(6, 5, 7, 2, 3, 4, 5, 6, 7);
		$j = 0;
		$sum = 0;
		$control = 0;

		$csum = intval(substr($nip, $nsize - 1));
		
		for ($i = 0; $i < $nsize - 1; $i++) {
			$c = $nip[$i];
			$j = intval($c);
			$sum += $j * $weights[$i];
		}

		$control = $sum % 11;
		return ($control == $csum);
	}
}