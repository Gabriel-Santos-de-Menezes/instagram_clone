<?php 
//Modelo para trabalhar com os posts no banco de dados
namespace App\Models;

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
    public function salvar(){
        $query = "insert into posts(id_usuario, post)values(:id_usuario, :post)";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':post', $this->__get('post'));
        $stmt->execute();

        return $this;//Retorna o post
    }


    //pegar todos os posts do usuario
    public function getAll(){

        $query = "
            select
                id, id_usuario, nome, post, DATE_FORMAT(%d/%m/%Y %H:%i) as data_post
            from 
                posts as p
                left join tb_usuarios as u on (t.id_usuario = u.id)
            where
                id_usuario = :id_usuario
            order by data desc
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);//retorna um array dos posts
    }
}


?>