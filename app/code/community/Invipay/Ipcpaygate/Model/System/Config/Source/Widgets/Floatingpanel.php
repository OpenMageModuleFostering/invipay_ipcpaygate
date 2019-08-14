<?php

class Invipay_Ipcpaygate_Model_System_Config_Source_Widgets_Floatingpanel
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'none', 'label' => 'Wyłączony'),
            array('value' => 'right', 'label' => 'Z prawej strony'),
            array('value' => 'left', 'label' => 'Z lewej strony'),
        );
    }

    public function toArray()
    {
        return array(
            'none' => 'Wyłączony',
            'right' => 'Z prawej strony',
            'left' => 'Z lewej strony',
        );
    }
}

?>