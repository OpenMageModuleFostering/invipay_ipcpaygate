<?php

require_once(dirname(__FILE__) ."/../../Common/Apiclient/PaygateApiClient.class.php");

class Invipay_Ipcpaygate_Helper_Data extends Mage_Core_Helper_Abstract
{
	const API_GATEWAY_URL = 'https://api.invipay.com/api/rest';
	const API_GATEWAY_URL_DEMO = 'http://demo.invipay.com/services/api/rest';

	public function getLastSessionOrder()
	{
		$order = new Mage_Sales_Model_Order();
		$orderId = Mage::getSingleton('checkout/session')->getLastOrderId();
		return $order->load($orderId);
	}

	public function changeOrderStateById($orderId, $state, $comment = '')
	{
		$order = Mage::getModel('sales/order')->load($orderId);
		$this->changeOrderState($order, $state, $comment);
	}

	public function changeOrderStateByInvipayPaymentId($paymentId, $state, $comment = '', $inviPayStatus = PaymentRequestStatus::STARTED)
	{
		$order = $this->getOrderByInvipayPaymentId($paymentId);
		$order->setInvipayStatus($inviPayStatus);
		$order->setInvipayDeliveryConfirmed(false);
		$order->setInvipayCompleted(false);
		$this->changeOrderState($order, $state, $comment);
	}

	public function changeOrderState($order, $state, $comment = '')
	{
		$order->setState($state, true, $comment);
		$order->save();
	}

	public function isDemoMode()
	{
		return intval(Mage::getStoreConfig('payment/ipcpaygate/invipay_demo_mode')) ? true : false;
	}

	public function getApiClient()
	{
		$url = $this->isDemoMode() ? self::API_GATEWAY_URL_DEMO : self::API_GATEWAY_URL;
		$apiKey = Mage::getStoreConfig('payment/ipcpaygate/api_key');
		$signatureKey = Mage::getStoreConfig('payment/ipcpaygate/signature_key');

		$client = new PaygateApiClient($url, trim($apiKey), trim($signatureKey));
		return $client;
	}

	public function getOrderBySecureId($secureId)
	{
		return Mage::getModel('sales/order')
				->getCollection()
				->addFieldToFilter('protect_code', $secureId)
				->getFirstItem();
	}

	public function getOrderByInvipayPaymentId($paymentId)
	{
		return Mage::getModel('sales/order')
				->getCollection()
				->addFieldToFilter('invipay_payment_id', $paymentId)
				->getFirstItem();
	}

	public function getNipFromQuote($quote)
	{
		$addressNip = null;
		$quoteNip = $quote->getData()['customer_taxvat'];
		$billingAddress = $quote->getBillingAddress();

		if ($billingAddress !== null) {
			$addressNip = $billingAddress->getData()['vat_id'];
		}

		$output = !empty($addressNip) ? $addressNip : $quoteNip;
		return preg_replace('/[^0-9]*/', '', $output);
	}

	public function getNipFromOrder($order)
	{
		$addressNip = null;
		$orderNip = $order->getData()['customer_taxvat'];
		$billingAddress = $order->getBillingAddress();

		if ($billingAddress !== null) {
			$addressNip = trim($billingAddress->getData()['vat_id']);
		}

		$output = !empty($addressNip) ? $addressNip : $orderNip;;

		$output = preg_replace('/[^0-9]*/', '', $output);
		return $output;
	}

	public function getOrderPaymentStatusById($orderId)
	{
		$order = Mage::getModel('sales/order')->load($orderId);
		return $order !== null ? $order->getData()['invipay_status'] : null;
	}

	public function confirmDeliveryAndSendInvoice($order)
	{
		$invoices = array();
		$invoiceNumbers = array();

		if ($order->hasInvoices())
		{
			foreach ($order->getInvoiceCollection() as $invoiceItem)
			{
				$invoices[] = $invoiceItem;
				$invoiceNumbers[] = $invoiceItem->getIncrementId();
			}
		}
		
		$pdf = Mage::getModel('sales/order_pdf_invoice')->getPdf($invoices);
		$pdfData = $pdf->render();

		$documentNumber = join(', ', $invoiceNumbers);
		$issueDate = strtotime($order->getCreatedAt());
		$dueDateDays = intval(Mage::getStoreConfig('payment/ipcpaygate/invipay_base_duedate'));
		$dueDate = $issueDate + ($dueDateDays * 60 * 60 * 24);

		$client = $this->getApiClient();

		$request = new PaymentManagementData();
		$request->setPaymentId($order->getInvipayPaymentId());
		$request->setDoConfirmDelivery(true);

		{
			$conversionData = new OrderToInvoiceData();
			$conversionData->setInvoiceDocumentNumber($documentNumber);
			$conversionData->setIssueDate(date('Y-m-d', $issueDate));
			$conversionData->setDueDate(date('Y-m-d', $dueDate));

			$request->setConversionData($conversionData);
		}

		{
			$document = new FileData();
			$document->setName('Zamowienie_nr_' . $order->getEntityId() . '.pdf');
			$document->setMimeType('application/pdf');
			$document->setContentFromBin($pdfData);
			$request->setDocument($document);
		}

		$result = $client->managePayment($request);
		$order->setInvipayDeliveryConfirmed(true);
		$order->setInvipayCompleted(true);
		$order->save();
	}
}

?>