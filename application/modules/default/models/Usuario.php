<?php

class Default_Model_Usuario
{
    public $db;


    function __construct()
    {
        $this->tb = new Default_Model_DbTable_TbUsuario();
        $this->tb_cliente = new Default_Model_DbTable_TbCliente();
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
                    $result[] = $row->nome;
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
        $objeto['nome'] = $objeto['nome'];
        $data = new Zend_Date($objeto['data_nascimento']);
        $objeto['data_nascimento'] = $data->toString('d/MM/y');

        return $objeto;
    }



    public function insert($post)
    {
        $post['data_cadastro'] = new Zend_Db_Expr('NOW()');

        $this->tb->insert($post);
    }


    public function update($id,$post)
    {
        if($id<1 || !is_array($post))
        {
            return false;
        }

        unset($post['email']);
        $data = new Zend_Date($post['data_nascimento']);
        $post['data_nascimento'] = $data->toString(Zend_Date::W3C);


        try{
            $table = $this->tb;
            $where = $table->getAdapter()->quoteInto('id_usuario = ?', $id);
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

        $where = $table->getAdapter()->quoteInto('id_usuario = ?', $id);

        try{
            $table->delete($where);
            $this->tb_cliente->delete($where);
            return true;
        }catch(Exception $e){
            return false;
        }

    }
}

