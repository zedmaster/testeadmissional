<?php

class UsuarioController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {

        $nome = $this->_getParam('nome');
        $cbnome = new ZendX_JQuery_Form_Element_AutoComplete('nome');
        $cbnome->setLabel('Pesquisar:')
             ->setJQueryParams(array(
                    'source'=>'/usuario/nome', 
                    'minLength'=>3
            ))
             ->setValue($nome)
             ->setAttrib('size', '35');
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

    public function editarAction()
    {
        $post = $this->getRequest()->getPost();
        $id = $this->_getParam('id');
        $model =  new Application_Model_Usuario();
        $form = new Application_Form_Usuario();
        $form->setUpdate($id);


        if ($this->getRequest()->isPost()) {
            if($form->isValid($post)) {
                $values = $form->getValues();

                if($model->update($id,$values)){
                    $this->view->msg = "Atualização do registro {$id} realizado com sucesso.";
                    unset($_POST);
                    $this->_forward('index','usuario');
               }else{
                    $this->view->msg = "Houve um problema ao atualizar o registro {$id}.";
               }
            }
        }

        if($id>0)
        {
            $registro = $model->find($id);
            if(!is_null($registro))
            {
                $form->populate($registro);
                $this->view->form = $form;
            }
        } 


    }


}





