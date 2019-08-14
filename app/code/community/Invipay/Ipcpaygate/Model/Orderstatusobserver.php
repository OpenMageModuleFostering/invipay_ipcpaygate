<?php

class Invipay_Ipcpaygate_Model_Orderstatusobserver
{
	public function orderSaved(Varien_Event_Observer $observer)
	{
		$order = $observer->getEvent()->getOrder();
		$data = $order->getData();

		$id = $data['entity_id'];
		$state = $data['state'];
		$status = $data['status'];
		$invipayStatus = $data['invipay_status'];
		$invipayPaymentId = $data['invipay_payment_id'];
		$invipayCompleted = $data['invipay_completed'];

		if ($state == 'complete' && $status == 'complete' && $invipayStatus == 'COMPLETED' && $invipayCompleted == false)
		{
			Mage::helper('ipcpaygate')->confirmDeliveryAndSendInvoice($order);
		}
	}
}

?>