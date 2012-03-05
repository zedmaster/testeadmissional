<?php

class Default_Model_Cliente
{
    public $db;
    public $tb_cliente;
    public $tb_usuario;

    function __construct()
    {
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $this->tb_usuario = new Default_Model_DbTable_TbUsuario();
        $this->tb_cliente = new Default_Model_DbTable_TbCliente();

    }

    public function insert($post)
    {
        $db = $this->db;
        $data_usuario = $post['Conta'];
        unset($data_usuario['pessoa']);
        unset($data_usuario['confirmasenha']);
        $data_usuario['senha'] = md5($data_usuario['senha']);
        $data_usuario['data_cadastro'] =  new Zend_Db_Expr('CURDATE()');
        $data =  new Zend_Date($data_usuario['data_nascimento']);
        $data_usuario['data_nascimento'] = $data->toString('y-MM-d');

        $data_cliente = array_merge($post['PessoaFisica'],$post['PessoaJuridica'], $post['Endereco']);
        $data_cliente['data_cadastro'] = new Zend_Db_Expr('CURDATE()');



        $db->beginTransaction();
        try{
            $id_usuario = $this->tb_usuario->insert($data_usuario);
            $data_cliente['id_usuario'] = $id_usuario;

            $this->tb_cliente->insert($data_cliente);

            //Zend_Debug::dump(array($data_usuario,$data_cliente));
            //throw new Exception("Erro teste");

            $db->commit();
        }catch(Exception $e){
            $db->rollBack();
            Zend_Debug::dump($e->getMessage());
            return false;
        }

        return true;

    }

}

