<?php

class Zednet_Form_Element_Cnpj extends Zend_Form_Element_Text
{
    public function init()
    {
        $this->setLabel('CNPJ:')
             ->setRequired(true)
             ->setAttrib('alt', 'cnpj')
             ->addValidator(new Zednet_Validate_Cnpj())
             ->addValidator(new Zend_Validate_StringLength(array('max' => 32)))
             ->setAttrib('size', '13');

    }

}
