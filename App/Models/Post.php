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
        //recupera as informações do post, bem como se o usuário logado está curtindo e também a quantidades de curtidas do post
        $query = "
            select
                p.id, 
                p.id_usuario, 
                u.usuario, 
                u.foto_perfil, 
                p.imagem, 
                p.post, 
                TIMESTAMPDIFF(Second,p.data_post, now()) as data_post,
                (
                    select
                        count(*)
                    from
                        curtidas as c
                    where
                        c.id_post = p.id and c.id_usuario = :id_usuario
                ) as curtida,
                (
                    select
                        count(*)
                    from
                        curtidas as cu
                    where
                        cu.id_post = p.id
                ) as curtidas,
                (
                	SELECT GROUP_CONCAT(com.comentario)
                    from
                        comentarios as com
                    where 
                        com.id_post = p.id
                ) as comentario

            from 
                posts as p
                left join tb_usuarios as u on (p.id_usuario = u.id)
                ORDER by p.id DESC
        
            
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

    //Inserir a curtida do post no banco
    public function curtirPost($id_post){
        $query = "insert into curtidas(id_usuario, id_post)values(:id_usuario, :id_post)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':id_post', $id_post);
        $stmt->execute();

        return true;//verdadeiro para a inserção
    }
    
    //Deletar curtida do usuário
    public function descurtirPost($id_post){
        $query = "delete from curtidas where id_usuario = :id_usuario and id_post = :id_post";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':id_post', $id_post);
        $stmt->execute();

        return true;//verdadeiro para a inserção
    }

    //Add Comentario no post
    public function salvarComentario($id_post, $comentario){
        $query = "insert into comentarios (id_usuario, id_post, comentario)values(:id_usuario, :id_post, :comentario)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':id_post', $id_post);
        $stmt->bindValue(':comentario', $comentario);
        $stmt->execute();

        return true;
    }   

    //recuperar comentarios dos posts
    public function totalComentarios($id_post){
        $query = "
            select
                co.comentario
                p.id_usuario

            from
                comentarios as co
                left join posts as p on (p.id = :id_post)
            ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $id_post);
        $stmt->execute();

        //retornar um array associativo
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);//todos comentarios
    }


}


?>