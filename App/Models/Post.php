<?php 
//Modelo para trabalhar com os posts no banco de dados
namespace App\Models;

use MF\Model\Model;

class Post extends Model{
    private $id;
    private $id_usuario;
    private $post;
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

    //salvar
    public function salvar(){
        $query = "insert into posts(id_usuario, post, imagem)values(:id_usuario, :post, :imagem)";
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':post', $this->__get('post'));
        $stmt->bindValue(':imagem', $this->__get('imagem'));
        $stmt->execute();

        return $this;//Retorna o post
    }


    //pegar todos os posts do usuario
    public function getAll(){

        $query = "
            select
                p.id, p.id_usuario, u.usuario, p.imagem, p.post, TIMESTAMPDIFF(Second,p.data_post, now()) as data_post
            from 
                posts as p
                left join tb_usuarios as u on (p.id_usuario = u.id)
           
            order by p.data_post desc
        ";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);//retorna um array dos posts
    }
    public function getPostUsuario(){
        $query = "select id, post, imagem from posts where id_usuario = :id_usuario";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);//retorna um array dos posts
    }

    //total de posts por usuario
    public function getTotalPostUsuario(){
        $query = "select count(*)  as total_posts from posts where id_usuario = :id_usuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);//total de posts
    }
}


?>