<?php

	$installer = $this;
	$installer->startSetup();
	$installer->run("
		ALTER TABLE `{$installer->getTable('sales/order')}` ADD COLUMN `invipay_payment_id` VARCHAR(255) NULL DEFAULT NULL;
		ALTER TABLE `{$installer->getTable('sales/order')}` ADD COLUMN `invipay_status` VARCHAR(255) NULL DEFAULT NULL;
		ALTER TABLE `{$installer->getTable('sales/order')}` ADD COLUMN `invipay_delivery_confirmed` TINYINT(1) NOT NULL DEFAULT 0;
		ALTER TABLE `{$installer->getTable('sales/order')}` ADD COLUMN `invipay_completed` TINYINT(1) NOT NULL DEFAULT 0;
	");
	$installer->endSetup();

?>