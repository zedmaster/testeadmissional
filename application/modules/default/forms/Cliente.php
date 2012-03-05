<?php

class Default_Form_Cliente extends Zend_Form
{

    public function init()
    {

        $this->setSubFormConta();
        $this->setSubFormPessosFisica();
        $this->setSubFormPessosJuridica();
        $this->setSubFormEndereco();


        $submit = new Zend_Form_Element_Submit('Enviar');
        $submit->setValue('Enviar');


        /* Adiciona os elementos do formulario master*/
        $this->addElements(array(
            $submit
        ));

        
        $this->setSubFormDecorators(array(
            'FormElements',
            'Fieldset'
        ));


    }


    /**************************
    * SubForm Conta
    *
    */
    public function setSubFormConta()
    {
        /* SubForm Conta*/
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
             ->addValidator(new Zend_Validate_StringLength(array('max' => 64)))
              ->setAttrib('size', '25');

        $fone = new Zend_Form_Element_Text('fone');
        $fone->setLabel('Fone:')
             ->setRequired(true)
             ->setAttrib('alt', 'phone')
             ->addValidator(new Zend_Validate_StringLength(array('max' => 16)))
             ->setAttrib('size', '9');

        $celular = new Zend_Form_Element_Text('celular');
        $celular->setLabel('Celular:')
             ->setRequired(true)
             ->setAttrib('alt', 'phone')
             ->addValidator(new Zend_Validate_StringLength(array('max' => 16)))
             ->setAttrib('size', '9');


        $senha = new Zend_Form_Element_Password('senha');
        $senha->setLabel('Senha:')
              ->setRequired(true)
              ->addValidator(new Zend_Validate_StringLength(array('min' => 5,'max' => 32)))
              ->setAttrib('size', '10');

        $confirma_senha = new Zend_Form_Element_Password('confirmasenha');
        $confirma_senha->setLabel('Confirma Senha:')
              ->setRequired(true)
              ->addValidator(new Zend_Validate_StringLength(array('min' => 5,'max' => 32)))
              ->addValidator(new Zend_Validate_Identical($_POST['Conta']['senha']))
              ->setAttrib('size', '10');


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
        $nascimento->setAttrib('size', '7')
             ->setRequired(true)
             ->addValidator(new Zend_Validate_StringLength(array('max' => 10)))
             ->addValidator(new Zend_Validate_Date(array('format' => 'dd/mm/yyyy')))
             ->setAttrib('alt', 'date');


        $pessoa = new Zend_Form_Element_Radio('pessoa');
        $pessoa->setLabel('Pessoa:')
                      ->addMultiOptions(array(
                            'pf' => 'Física',
                            'pj' => 'Jurídica'
                      ))
              ->addValidator(new Zend_Validate_StringLength(array('max' => 2)))
              ->setRequired(true);


        /* SubForm Conta */
        $formconta = new Zend_Form_SubForm();
        $formconta->setLegend('Conta Usuário')
                  ->addElements(array(
            $nome,
            $email,
            $fone,
            $celular,
            $nascimento,
            $senha,
            $confirma_senha,
            $pessoa
        ));

        /* Adiciona subforms */
        $this->addSubForms(array(
                        'Conta' => $formconta
        ));



    }


    /*************************
    * SubForm Pessoa Física
    *
    */
    public function setSubFormPessosFisica()
    {
        /*Sub Form Pessoa Física*/
        $cpf = new Zednet_Form_Element_Cpf('cpf');

        /* SubForm Pessoa Física */
        $form_pessoa_fisica = new Zend_Form_SubForm();
        $form_pessoa_fisica->setLegend('Pessoa Física')
                   ->addElements(array(
            $cpf));

        /* Adiciona subforms */
        $this->addSubForms(array(
                        'PessoaFisica' => $form_pessoa_fisica
        ));

    }

    /*************************
    * SubForm Pessoa Jurídica
    *
    */
    public function setSubFormPessosJuridica()
    {
        $razao_social = new Zend_Form_Element_Text('razao_social');
        $razao_social->setLabel('Razão Social:')
            ->setRequired(true)
             ->setAttrib('size', '40');

        $nome_fantasia = new Zend_Form_Element_Text('nome_fantasia');
        $nome_fantasia->setLabel('Nome Fantasia:')
            ->setRequired(true)
             ->addValidator(new Zend_Validate_StringLength(array('max' => 256)))
             ->setAttrib('size', '40');


        $cnpj = new Zednet_Form_Element_Cnpj('cnpj');

        $ie = new Zednet_Form_Element_Ie('ie');
        $ie->setUf($_POST['Endereco']['uf']);

        $form_pessoa_juridica = new Zend_Form_SubForm();
        $form_pessoa_juridica->setLegend('Pessoa Jurídica')
                   ->addElements(array(
            $razao_social,
            $nome_fantasia,
            $cnpj,
            $ie,
        ));

        /* Adiciona subforms */
        $this->addSubForms(array(
                        'PessoaJuridica' => $form_pessoa_juridica
        ));

    }

    /*************************
    * SubForm Endereco
    *
    */
    public function setSubFormEndereco()
    {
        /* SubForm Endereço*/       
        $cep = new Zend_Form_Element_Text('cep');
        $cep->setLabel('CEP:')
             ->setRequired(true)
             ->setAttrib('alt', 'cep')
             ->setAttrib('size', '6');

        $endereco = new Zend_Form_Element_Text('endereco');
        $endereco->setLabel('Endereço:')
            ->setRequired(true)
             ->setAttrib('size', '40');

        $numero = new Zend_Form_Element_Text('numero');
        $numero->setLabel('Número:')
            ->setRequired(true)
             ->setAttrib('size', '10');

        $complemento = new Zend_Form_Element_Text('complemento');
        $complemento->setLabel('Complemento:')
             ->setAttrib('size', '40');

        $bairro = new Zend_Form_Element_Text('bairro');
        $bairro->setLabel('Bairro:')
            ->setRequired(true)
             ->setAttrib('size', '20');



        $uf = new Zend_Form_Element_Select('uf');
        $uf->setLabel('Estado:')
            ->setRequired(true)
            ->addValidator('NotEmpty');
        $uf->setMultiOptions($this->getUf());

        $cidade = new Zend_Form_Element_Select('id_cidade');
        $cidade->setLabel('Cidade:')
            ->setRequired(true)
            ->setRegisterInArrayValidator(false)
            ->addValidator('NotEmpty');
        
        $ufselected = 'AC';
        if($_POST['Endereco']["uf"] != ""){
            $ufselected = $_POST['Endereco']["uf"];
        }
        $cidade->setMultiOptions($this->getCidade($ufselected));

        /*SubForm Endereço*/
        $formendereco = new Zend_Form_SubForm();
        $formendereco->setLegend('Endereço')
                     ->addElements(array(
            $cep,
            $endereco,
            $numero,
            $complemento,
            $bairro,
            $uf,
            $cidade
       ));


        /* Adiciona subforms */
        $this->addSubForms(array(
                        'Endereco' => $formendereco
        ));




    }

    /*********
    *  Retorna listagem dos estados
    *
    */
    public function getUf()
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $tb = new Default_Model_DbTable_TbEstados();

        $result = $tb->fetchAll();

        $lista = array();
        foreach($result as $linha)

        {
            $lista[$linha->sigla] = $linha->nome; 
        }

        return $lista;
    }

    /*******
    *  Retorna listagem das ciades de um determinado estado
    *
    */
    public function getCidade($uf)
    {
        if($uf == '')
        {
            return array();
        }

        $db = Zend_Db_Table::getDefaultAdapter();
        $tb = new Default_Model_DbTable_TbCidades();

        $select = $tb->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
            ->setIntegrityCheck(false)
            ->join('tb_estados','tb_estados.cod_estados = tb_cidades.estados_cod_estados', array("cidade_nome" => "tb_cidades.nome"))
            ->where('tb_estados.sigla = ?',$uf);
        $result = $tb->fetchAll($select);

        //Zend_Debug::dump($result);
        $lista = array();
        foreach($result as $linha)

        {
            $lista[$linha->cod_cidades] = $linha->cidade_nome; 
        }


        return $lista;
    }

}

