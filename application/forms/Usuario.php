<?php

class Application_Form_Usuario extends Zend_Form
{

    public function init()
    {
        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome:')
             ->setRequired(true)
             ->addValidator('NotEmpty');

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail:')
              ->setRequired(true)
              ->addValidator('NotEmpty')
              ->addValidator(new Zend_Validate_Db_NoRecordExists( array('table' => 'tb_usuario', 'field' => 'email')))
              ->addValidator('EmailAddress');

        $cpf = new Zend_Form_Element_Text('cpf');
        $cpf->setLabel('CPF:')
             ->setRequired(true)
             ->addValidator('NotEmpty')
             ->addValidator(new Zednet_Validate_Cpf())
             ->addValidator(new Zend_Validate_Db_NoRecordExists( array('table' => 'tb_usuario', 'field' => 'cpf')))
             ->addFilter(new Zend_Filter_PregReplace(array('match' => '/\.|-/', 'replace' => '')) );


        $nascimento = new Zend_Form_Element_Text('data_nascimento');
        $nascimento->setLabel('Data Nascimento:')
             ->setRequired(true)
             ->addValidator('NotEmpty')
             ->addValidator(new Zend_Validate_Date(array('format' => 'dd/MM/YYYY')) );


        $cargo = new Zend_Form_Element_Select('fk_cargo');
        $cargo->setLabel('Cargo:')
            ->setRequired(true)
            ->addValidator('NotEmpty');
        $cargo->setMultiOptions($this->getCargo());




        $submit = new Zend_Form_Element_Submit('enviar');
        $submit->setValue('Enviar')
               ->setDecorators(array(
                   array('ViewHelper',
                   array('helper' => 'formSubmit'))
               ));


        $this->addElements(array(
            $nome,
            $email,
            $cpf,
            $nascimento,
            $cargo,
            $submit
        ));

    }

    public function getCargo() 
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $tb = new Application_Model_DbTable_TbCargo();

        $result = $tb->fetchAll();

        $lista = array();
        foreach($result as $linha)
        {
            $lista[$linha->pk_cargo] = utf8_encode($linha->cargo); 
        }


        return $lista;
    }

    public function setUpdate($id)
    {
        $this->setAttrib('action',"?id={$id}");


        $this->email->disabled = 'disabled';
        $this->email->removeValidator('Zend_Validate_NotEmpty')
                    ->setRequired(false);
        


        $this->cpf->disabled = 'disabled';
        $this->cpf->removeValidator('Zednet_Validate_Cpf')
                  ->removeValidator('Zend_Validate_NotEmpty')
                  ->setRequired(false);

        //Zend_Debug::dump($this->email->getValidators());
    }

}

