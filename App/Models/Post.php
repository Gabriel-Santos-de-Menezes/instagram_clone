<?php 
//Modelo para trabalhar com os posts no banco de dados
namespace App\Model;

use MF\Model\Model;

class Post extends Model{
    private $id;
    private $id_usuario;
    private $post;
    private $data;
    //pegar
    public function __get($atributo){
        return $this->$atributo;
    }
    //setar
    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    //salvar
    


}

?>