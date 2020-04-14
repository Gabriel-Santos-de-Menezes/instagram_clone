<?php 

//Modelo para trabalhar com os posts no banco de dados
namespace App\Models;

use MF\Model\Model;

class Imagens_post extends Model{

    private $id;
    private $id_usuario;
    private $imagem;
    private $data;

    //pegar
    public function __get($atributo){
        return $this->$atributo;
    }
    //setar
    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    //Salvar
    public function salvar(){
        $query = "insert into imagens_posts(id_usuario, imagem)values(:id_usuario,:novo_nome)";
        $stmt = $this->db->prepare($query);
        //evitar sql injection
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':novo_nome', $this->__get('imagem'));
        $stmt->execute();

        return $this;//retornando a imagem
    }

}


?> 