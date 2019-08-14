<?php

class Invipay_Ipcpaygate_PaymentController extends Mage_Core_Controller_Front_Action 
{
	const ORDER_STATUS_PAYMENT_COMPLETED = 'new';
	const ORDER_STATUS_PAYMENT_OUT_OF_LIMIT = 'pending_payment';
	const ORDER_STATUS_PAYMENT_TIMEOUT = 'pending_payment';
	const ORDER_STATUS_PAYMENT_CANCELED = 'pending_payment';
	const ORDER_STATUS_PAYMENT_OTHER = 'pending_payment';

	public function statusAction()
	{
		$client = Mage::helper('ipcpaygate')->getApiClient();
		$receivedData = $client->paymentStatusFromCallbackPost(CallbackDataFormat::JSON);
		$paymentData = $client->getPayment($receivedData->getPaymentId());

		if ($paymentData != null && $this->checkPaymentStatus($paymentData) == true)
		{
			$inviPayPaymentId = $paymentData->getPaymentId();
			$inviPayStatus = $paymentData->getStatus();

			$newOrderStatus = null;
			$newOrderComment = '';

			if ($inviPayStatus == PaymentRequestStatus::COMPLETED)
			{
				$newOrderComment = 'Płatność potwierdzona w inviPay.com.';
				$newOrderStatus = self::ORDER_STATUS_PAYMENT_COMPLETED;
			}
			else if ($inviPayStatus == PaymentRequestStatus::OUT_OF_LIMIT)
			{
				$newOrderComment = 'Klient wyczerpał swój limit w inviPay.com.';
				$newOrderStatus = self::ORDER_STATUS_PAYMENT_OUT_OF_LIMIT;
			}
			else if ($inviPayStatus == PaymentRequestStatus::TIMEDOUT)
			{
				$newOrderComment = 'Klient porzucił płatność przez inviPay.com.';
				$newOrderStatus = self::ORDER_STATUS_PAYMENT_TIMEOUT;
			}
			else if ($inviPayStatus == PaymentRequestStatus::CANCELED)
			{
				$newOrderComment = 'Klient anulował płatność przez inviPay.com.';
				$newOrderStatus = self::ORDER_STATUS_PAYMENT_CANCELED;
			}
			else
			{
				$newOrderComment = 'Nieznany status płatności.';
				$newOrderStatus = self::ORDER_STATUS_PAYMENT_OTHER;
			}

			if ($newOrderStatus !== null)
			{
				$newOrderComment .= ' Numer płatności w inviPay.com: ' . $inviPayPaymentId;
				Mage::helper('ipcpaygate')->changeOrderStateByInvipayPaymentId($inviPayPaymentId, $newOrderStatus, $newOrderComment, $inviPayStatus);
			}
		}
	}

	protected function checkPaymentStatus($receivedData)
	{
		return true;
	}

	public function redirectAction() 
	{
		$order = Mage::helper('ipcpaygate')->getLastSessionOrder();
		$data = $order->getData();
		$orderId = $data['entity_id'];

		Mage::helper('ipcpaygate')->changeOrderState($order, 'pending_payment', true, 'Rozpoczęto proces płatności w inviPay.com.');

		$client = Mage::helper('ipcpaygate')->getApiClient();

		$request = new PaymentCreationData();
		$request->setReturnUrl(Mage::getUrl('ipcpaygate/payment/return', array('order' => $orderId)));
		$request->setStatusUrl(Mage::getUrl('ipcpaygate/payment/status', array()));
		$request->setStatusDataFormat(CallbackDataFormat::JSON);
		$request->setDocumentNumber($data['increment_id']);
		$request->setIssueDate(date('Y-m-d', strtotime($data['created_at'])));
		$request->setPriceGross($data['grand_total']);
		$request->setCurrency($data['base_currency_code']);
		$request->setIsInvoice(false);
		$request->setBuyerGovId(Mage::helper('ipcpaygate')->getNipFromOrder($order));
		$request->setBuyerEmail($data['customer_email']);

		// Any exception will be logged by Magento, so no try-catch here

		$result = $client->createPayment($request);
		$paymentId = $result->getPaymentId();
		$redirectUrl = $result->getRedirectUrl();
		$order->setInvipayPaymentId($paymentId);
		$order->setInvipayCompleted(false);
		$order->setInvipayDeliveryConfirmed(false);
		$order->save();

		$this->loadLayout();
		$block = $this->getLayout()->createBlock('Invipay_Ipcpaygate_Block_Redirect','ipcpaygate');
		$block->setRedirectUrl($redirectUrl);
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}

	public function getCurrentRedirectUrl()
	{
		return $this->currentRedirectUrl;
	}

	public function returnAction()
	{
		$orderId = $this->getRequest()->getParam('order');
		$this->loadLayout();
		$block = $this->getLayout()->createBlock('Invipay_Ipcpaygate_Block_Wait','ipcpaygate');
		$block->setOrderId($orderId);
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}

	public function checkAction()
	{
		$orderId = $this->getRequest()->getParam('order');
		$state = Mage::helper('ipcpaygate')->getOrderPaymentStatusById($orderId);
		$output = array('redirect' => false, 'redirect_url' => null, 'current_state' => $state);

		if ($state == PaymentRequestStatus::COMPLETED)
		{
			Mage::getSingleton('checkout/session')->unsQuoteId();
			$output['redirect'] = true;
			$output['redirect_url'] = Mage::getUrl('checkout/onepage/success', array('_secure'=> false));
		}
		else if ($state == PaymentRequestStatus::OUT_OF_LIMIT || $state == PaymentRequestStatus::TIMEDOUT || $state == PaymentRequestStatus::CANCELED)
		{
			$output['redirect'] = true;
			$output['redirect_url'] = Mage::getUrl('checkout/onepage/failure', array('_secure'=> false));
		}

		$this->getResponse()->setHeader('Content-type', 'application/json');
		$this->getResponse()->setBody(json_encode($output));

		return null;
	}
}