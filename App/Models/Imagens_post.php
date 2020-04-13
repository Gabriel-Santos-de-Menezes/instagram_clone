<?php 

//Modelo para trabalhar com os posts no banco de dados
namespace App\Models;

use MF\Model\Model;

class ImagensPost extends Model{

    private $id;
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
        $query = "inset into imagens_post(id_post, imagem)values(:id_post,imagem)";
        $stmt = $this->db->prepare($query);
        //evitar sql injection
        $stmt->bindValue(':id_post', $this->__get('id_post'));
        $stmt->bindValue(':imagem', $this->__get('imagem'));
        $stmt->execute();

        return $this;//retornando a imagem
    }

}


?> 