<?php

class Zednet_Validate_Cnpj extends Zend_Validate_Abstract
{
    const CNPJ = 'cpf';

    protected $_messageTemplates = array(
            self::CNPJ => "Este CNPJ é inválido"
            );

    public function isValid($value)
    {
        $this->_setValue($value);


        if (!$this->validaCNPJ($value)) {
            $this->_error(null);
            return false;
        }

        return true;
    }

    //-----------------------------------------------------
    //Funcao: validaCNPJ($cnpj)
    //Sinopse: Verifica se o valor passado é um CNPJ válido
    // Retorno: Booleano
    // Autor: Gabriel Fróes - www.codigofonte.com.br
    //-----------------------------------------------------
    public function validaCNPJ($cnpj) { 
        if (strlen($cnpj) <> 18) return 0; 
        $soma1 = ($cnpj[0] * 5) + 

            ($cnpj[1] * 4) + 
            ($cnpj[3] * 3) + 
            ($cnpj[4] * 2) + 
            ($cnpj[5] * 9) + 
            ($cnpj[7] * 8) + 
            ($cnpj[8] * 7) + 
            ($cnpj[9] * 6) + 
            ($cnpj[11] * 5) + 
            ($cnpj[12] * 4) + 
            ($cnpj[13] * 3) + 
            ($cnpj[14] * 2); 
        $resto = $soma1 % 11; 
        $digito1 = $resto < 2 ? 0 : 11 - $resto; 
        $soma2 = ($cnpj[0] * 6) + 

            ($cnpj[1] * 5) + 
            ($cnpj[3] * 4) + 
            ($cnpj[4] * 3) + 
            ($cnpj[5] * 2) + 
            ($cnpj[7] * 9) + 
            ($cnpj[8] * 8) + 
            ($cnpj[9] * 7) + 
            ($cnpj[11] * 6) + 
            ($cnpj[12] * 5) + 
            ($cnpj[13] * 4) + 
            ($cnpj[14] * 3) + 
            ($cnpj[16] * 2); 
        $resto = $soma2 % 11; 
        $digito2 = $resto < 2 ? 0 : 11 - $resto; 
        return (($cnpj[16] == $digito1) && ($cnpj[17] == $digito2)); 
    } 

}
