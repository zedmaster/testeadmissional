<?php

class Application_Model_Usuario
{
    public $db;


    function __construct()
    {
        $this->tb = new Application_Model_DbTable_TbUsuario();
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

    public function find($id)
    {
        $objeto = null;
        if($id<1)
        {
            return $objeto;
        }

        $table = $this->tb;
        $objeto = $table->find($id);
        $objeto = $objeto->toArray();
        $objeto = $objeto[0];
        $objeto['nome'] = utf8_encode($objeto['nome']);
        return $objeto;
    }



    public function insert($post)
    {
        $post['data_inclusao'] = new Zend_Db_Expr('NOW()');

        $this->tb->insert($post);
    }


    public function update($id,$post)
    {
        if($id<1 || !is_array($post))
        {
            return false;
        }

        unset($post['email']);
        unset($post['cpf']);


        try{
            $table = $this->tb;
            $where = $table->getAdapter()->quoteInto('pk_usuario = ?', $id);
            $table->update($post, $where);
            return true;
        }catch(Exception $e){
            return false;
        }

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

