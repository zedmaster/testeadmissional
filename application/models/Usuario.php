<?php

class Application_Model_Usuario
{
    public $db;


    function __construct()
    {
        $this->tb = new Application_Model_DbTable_TbUsuario();
    }

    public function insert($post)
    {
        $post['data_inclusao'] = new Zend_Db_Expr('NOW()');

        $this->tb->insert($post);
    }

    public function pesquisaNomes($term, $json=true)
    {
        $select = $this->tb->select();
        $select->where("nome LIKE ?",utf8_decode($term).'%');
        $rows =  $this->tb->fetchAll($select);


        $result = array();
        if(count($rows)>0)
        {
            foreach($rows as $row)
            {
                if($json)
                {
                    $result[] = utf8_encode($row->nome);
                }else{
                    return $rows;
                }
            } 
        }
        return $result;
    }


    public function excluir($id)
    {
        if($id < 1)
        {
            return false;
        }
        $table = $this->tb;

        $where = $table->getAdapter()->quoteInto('pk_usuario = ?', $id);

        try{
            $table->delete($where);
            return true;
        }catch(Exception $e){
            return false;
        }

    }
}

