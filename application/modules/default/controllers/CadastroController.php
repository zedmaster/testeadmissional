<?php

class Default_CadastroController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
        $post = $this->getRequest()->getPost();
        $form = new Default_Form_Cliente();


        if ($this->getRequest()->isPost()) {
            if($post['Conta']['pessoa'] == "pf"){
                unset($post['PessoaJuridica']);
            }else if($post['Conta']['pessoa'] == "pj"){
                unset($post['PessoaFisica']);
            }

            if($form->isValidPartial($post)) {
                $values = $form->getValues();
                $model = new Default_Model_Cliente();

                if($model->insert($values))
                {
                    unset($_POST);
                    $this->_redirect('/cadastro/concluido');
                }else{
                    $msg = "Ocorreu um problema ao inserir os dados, favor tentar novamente.";
                }
            }
            $_SESSION['msg'] = $msg;
            $form->init();
            $form->isValid($post);
            $form->populate($post);
        }
        $this->view->form = $form;

    }

    public function cidadesAction()
    {
        $this->_helper->layout->disableLayout();
        $this->getHelper('viewRenderer')->setNoRender();

        
        $form = new Default_Form_Cliente();
        $cidade = new Zend_Form_Element_Select('id_cidade');
        $uf = $this->getRequest()->getParam('uf');
        $cidade->setMultiOptions($form->getCidade($uf));
        $cidade->removeDecorator("Label");
        $cidade->removeDecorator("HtmlTag");

        echo $cidade;
    }

    public function concluidoAction()
    {
        // action body
    }


}



