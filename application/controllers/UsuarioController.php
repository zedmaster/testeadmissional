<?php

class UsuarioController extends Zend_Controller_Action
{

    public function init()
    {
         $this->view->addHelperPath(
                    'ZendX/JQuery/View/Helper',
                    'ZendX_JQuery_View_Helper');
    }

    public function indexAction()
    {

        $nome = $this->_getParam('nome');
        $cbnome = new ZendX_JQuery_Form_Element_AutoComplete('nome');
        $cbnome->setLabel('')
             ->setJQueryParams(array(
                    'source'=>'/usuario/nome', 
                    'minLength'=>3
            ))
            ->setValue($nome);
        $this->view->nome = $cbnome;

        $model = new Application_Model_Usuario();
        $data = $model->pesquisaNomes($nome,false);
        $this->view->list = $data;
    }

    public function nomeAction()
    {
        $term = $this->_getParam('term');
        $model = new Application_Model_Usuario(); 
        $data = $model->pesquisaNomes($term);
        $this->_helper->json($data);
    }

    public function novoAction()
    {
        $post = $this->getRequest()->getPost();
        $form = new Application_Form_Usuario();


        if ($this->getRequest()->isPost()) {
            if($form->isValid($post)) {
                $values = $form->getValues();
                $model = new Application_Model_Usuario();

                $model->insert($values);

                $this->view->msg = "Cadastro realizado com sucesso.";
                unset($_POST);
                $this->_forward('index','usuario');
            }
            $form->init();
            $form->isValid($post);
            $form->populate($post);
        }
        $this->view->form = $form;
    }

    
    public function excluirAction()
    {
        $id = $this->_getParam('id');
        $model =  new Application_Model_Usuario();

        if($model->excluir($id))
        {
            $this->view->msg = "Exclusão do registro {$id} realizado com sucesso.";   
        }else{
            $this->view->msg = "Não foi possível excluir o registro {$id}.";
        }
        $this->_forward('index','usuario');
    }
}



