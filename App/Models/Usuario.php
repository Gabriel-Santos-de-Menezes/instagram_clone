<?php 

namespace App\Models;

class Usuario extends Model{
    private $id;
    private $nome;
    private $usuario;
    private $senha;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    //Salvar

    public function salvar(){
        
    }
}



?>