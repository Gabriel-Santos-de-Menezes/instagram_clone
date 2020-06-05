<?php

//Modelo para trabalhar com os posts no banco de dados
namespace App\Models;

use MF\Model\Model;

class Mensagem extends Model{
    private $id_mensagem;
    private $mensagem;
    private $from_usuario_id;
    private $to_usuario_id;
    private $imagem;
    private $emoji;

    //pegar
    public function __get($atributo){
        return $this->$atributo;
    }
    //setar
    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    //salvar
    public function Salvar(){
        $query = "insert into mensagem (data, mensagem, from_usuario_id, to_usuario_id, imagem, emoji) 
                    values(:data, :mensagem, :from_usuario_id, :to_usuario_id, :imagem, :emoji)";
    
        $stmt = $this->bd->prepare($query);
        $stmt->bindValue(':mensagem', $this->__get('mensagem'));
        $stmt->bindValue(':from_usuario_id', $_SESSION('id'));
        $stmt->bindValue(':to_usuario_id', $this->__get('to_usuario_id'));
        $stmt->bindValue(':imagem', $this->__get('imagem'));
        $stmt->bindValue(':emoji', $this->__get('emoji'));
        
        $stmt->execute();
        return true;
    }
    
}



?>