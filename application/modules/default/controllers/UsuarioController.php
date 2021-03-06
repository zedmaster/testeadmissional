<?php

class Default_UsuarioController extends Zend_Controller_Action
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

        $model = new Default_Model_Usuario();
        $data = $model->pesquisaNomes($nome,false);
        $this->view->list = $data;
    }

    public function nomeAction()
    {
        $term = $this->_getParam('term');
        $model = new Default_Model_Usuario(); 
        $data = $model->pesquisaNomes($term);
        $this->_helper->json($data);
    }

    public function novoAction()
    {
        $post = $this->getRequest()->getPost();
        $form = new Default_Form_Usuario();


        if ($this->getRequest()->isPost()) {
            if($form->isValid($post)) {
                $values = $form->getValues();
                $model = new Default_Model_Usuario();

                $model->insert($values);

                $msg = "Cadastro realizado com sucesso.";
                unset($_POST);
                $_SESSION['msg'] = $msg;
                $this->_redirect('/usuario');
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
        $model =  new Default_Model_Usuario();

        if($model->excluir($id))
        {
            $msg = "Exclusão do registro {$id} realizado com sucesso.";   
        }else{
            $msg = "Não foi possível excluir o registro {$id}.";
        }
        $_SESSION['msg'] = $msg;
        $this->_redirect('/usuario');
    }

    public function editarAction()
    {
        $post = $this->getRequest()->getPost();
        $id = $this->_getParam('id');
        $model =  new Default_Model_Usuario();
        $form = new Default_Form_Usuario();
        $form->setUpdate($id);


        if ($this->getRequest()->isPost()) {
            if($form->isValid($post)) {
                $values = $form->getValues();

                if($model->update($id,$values)){
                    $msg = "Atualização do registro {$id} realizado com sucesso.";
                    unset($_POST);
                    $_SESSION['msg'] = $msg;
                    $this->_redirect('/usuario');
                    
               }else{
                    $_SESSION['msg'] = "Houve um problema ao atualizar o registro {$id}.";
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





