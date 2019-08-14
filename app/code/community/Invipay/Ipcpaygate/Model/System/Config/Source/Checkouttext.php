<?php

class Invipay_Ipcpaygate_Model_System_Config_Source_Checkouttext
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'standard', 'label' => 'Standardowy'),
            array('value' => 'short', 'label' => 'Krótki'),
            array('value' => 'medium', 'label' => 'Średni'),
            array('value' => 'long', 'label' => 'Długi'),
        );
    }

    public function toArray()
    {
        return array(
            'standard' => 'Standardowy',
            'short' => 'Krótki',
            'medium' => 'Średni',
            'long' => 'Długi',
        );
    }
}

?>