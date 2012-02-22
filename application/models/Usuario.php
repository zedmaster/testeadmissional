<?php

class Application_Model_Usuario
{
    public $db;


    function __construct()
    {
        $this->db = new Application_Model_DbTable_TbUsuario();
    }

    public function insert($post)
    {
        $post['data_inclusao'] = new Zend_Db_Expr('NOW()');

        $this->db->insert($post);
    }
}

