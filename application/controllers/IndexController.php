<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
         $this->view->addHelperPath(
                    'ZendX/JQuery/View/Helper',
                    'ZendX_JQuery_View_Helper');
    }

    public function indexAction()
    {
        // action body
    }


}

