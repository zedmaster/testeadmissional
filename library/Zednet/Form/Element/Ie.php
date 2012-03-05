<?php

class Zednet_Form_Element_Ie extends Zend_Form_Element_Text
{
    public function init()
    {
        $this->addValidator(new Zednet_Validate_Ie())
             ->setLabel('Inscrição Estadual:')
             ->addFilter(new Zend_Filter_Alnum())
             ->addValidator(new Zend_Validate_StringLength(array('max' => 20)))
             ->setAttrib('size', '13');
    }

    public function setUf($value)
    {
        if(strlen($value) != 2)
        {
            return false;
        }


        $this->getValidator('Zednet_Validate_Ie')->setUf(strtoupper($value));
    }
}
