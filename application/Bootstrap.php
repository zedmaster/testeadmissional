<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

public function _initView() {
        $this->bootstrap("layout");
        $layout = $this->getResource("layout");
        $view = $layout->getView();
        $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        $view->jQuery()
            ->addStylesheet("/css/jquery.dataTables.css")
            ->addStylesheet("/css/jquery.dataTables_themeroller.css")
            ->setLocalPath('/js/jquery-1.7.1.min.js')
            ->setUiLocalPath("/js/jquery-ui-1.8.18.custom.min.js")
            ->addJavascriptFile('/js/jquery.dataTables.min.js')
            ->addJavascriptFile('/js/jquery.meio.mask.min.js')
            ->addJavascript("$(document).ready(function(){ 
                    try{
                        $('#table1').dataTable({
                                'bJQueryUI': true,
                                'bPaginate': false,     
                                'bFilter': false, 
                                'sDom': '<\"toolbar\">frtip', 
                                'bInfo': false,  
                        });
                        $('input:text').setMask();
                        $('input:submit').button();
                    }catch(err){}
                    $('#content').fadeIn(1000);
                });");


            $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
            $viewRenderer->setView($view);
            Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
            }


}

