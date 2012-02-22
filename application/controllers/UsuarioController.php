<?php

class UsuarioController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
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
                return $this->_forward('index','usuario');
            }
            $form->init();
            $form->isValid($post);
            $form->populate($post);
        }
        $this->view->form = $form;
    }


}



