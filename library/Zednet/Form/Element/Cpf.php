<?php

class Zednet_Form_Element_Cpf extends Zend_Form_Element_Text
{
    public function init()
    {
        $this->setLabel('CPF:')
            ->setRequired(true)
            ->addValidator('NotEmpty')
            ->addValidator(new Zednet_Validate_Cpf())
            ->addValidator(new Zend_Validate_Db_NoRecordExists( array('table' => 'tb_cliente', 'field' => 'cpf')))
            ->addFilter(new Zend_Filter_PregReplace(array('match' => '/\.|-/', 'replace' => '')) )
            ->setAttrib('alt', 'cpf')
            ->addValidator(new Zend_Validate_StringLength(array('max' => 16)))
            ->setAttrib('size', '9');

    }

}
