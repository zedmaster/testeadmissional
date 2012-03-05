<?php

class Default_Form_Usuario extends Zend_Form
{

    public function init()
    {
        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome:')
             ->setRequired(true)
             ->addValidator('NotEmpty')
             ->addValidator(new Zend_Validate_StringLength(array('max' => 255)))
             ->setAttrib('size', '40');

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail:')
              ->setRequired(true)
              ->addValidator('NotEmpty')
              ->addValidator(new Zend_Validate_Db_NoRecordExists( array('table' => 'tb_usuario', 'field' => 'email')))
              ->addValidator('EmailAddress')
              ->setAttrib('size', '25');


        $nascimento =  new ZendX_JQuery_Form_Element_DatePicker("data_nascimento", array(
                                                                                      'label' => 'Data Nascimento:',
                                                                                      'jQueryParams' => array(
                                                                                                    'changeYear' => 'true',
                                                                                                    'changeMonth' => 'true',
                                                                                                    'yearRange' => '1900:2000',
                                                                                                    'defaultDate' => '-20Y',
                                                                                                    'dateFormat' => 'dd/mm/yy'
                                                                                                )
                                                                                   ));
        $nascimento->setAttrib('size', '7');


        $cargo = new Zend_Form_Element_Select('fk_cargo');
        $cargo->setLabel('Cargo:')
            ->setRequired(true)
            ->addValidator('NotEmpty');
        $cargo->setMultiOptions($this->getCargo());




        $submit = new Zend_Form_Element_Submit('Enviar');
        $submit->setValue('Enviar');


        $this->addElements(array(
            $nome,
            $email,
            $nascimento,
            $cargo,
            $submit
        ));

    }

    public function getCargo() 
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $tb = new Default_Model_DbTable_TbCargo();

        $result = $tb->fetchAll();

        $lista = array();
        foreach($result as $linha)
        {
            $lista[$linha->pk_cargo] = $linha->cargo; 
        }


        return $lista;
    }

    public function setUpdate($id)
    {
        $this->setAttrib('action',"?id={$id}");


        $this->email->disabled = 'disabled';
        $this->email->removeValidator('Zend_Validate_NotEmpty')
                    ->setRequired(false);
        

        //Zend_Debug::dump($this->email->getValidators());
    }

}

