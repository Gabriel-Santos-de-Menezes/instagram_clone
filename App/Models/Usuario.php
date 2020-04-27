<?php 

namespace App\Models;//O nome é proporcional da localização do script

use MF\Model\Model;

class Usuario extends Model{
    private $id;
    private $nome;
    private $email;
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

        $query = "insert into tb_usuarios(nome, usuario, email, senha)values(:nome, :usuario, :email, :senha)";

        $stmt = $this->db->prepare($query);
        //pegar o atributoe atribuir como indice dinâmico da query
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':usuario', $this->__get('usuario'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();

        return $this;
        
    }

    //validar se um cadastro pode ser feito
    public function validarCadastro(){//verifica se todos os campos estão validos

        $valido = true;
        if(strlen($this->__get('email')) < 5){//Retorna o tamanho da string
            $valido = false;
        }
        if(strlen($this->__get('nome')) < 3){//Retorna o tamanho da string
            $valido = false;
        }
        if(strlen($this->__get('usuario')) < 3){//Retorna o tamanho da string
            $valido = false;
        }
        if(strlen($this->__get('senha')) < 6){//Retorna o tamanho da string
            $valido = false;
        }

        return $valido;

    }

    //recuperar um usuário por usuario e email
    public function getUsuario(){
        
        $query = "select nome, usuario, email from tb_usuarios where usuario = :usuario or email = :email";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':usuario', $this->__get('usuario'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);//retorna um array associativo
    }

    //metodo responsável, por checar no banco de dados, se o usuário existe
    public function autenticar(){
        //query para recuperar o id do usuario e o usuario
        $query = "select id, nome, usuario from tb_usuarios where usuario = :usuario and senha = :senha or email = :usuario ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':usuario', $this->__get('usuario'));   
        $stmt->bindValue(':senha', $this->__get('senha'));   
        $stmt->execute();

        //pegar o registro retornado
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        //verificar se o usuario e senha foram encaminhados corretamente
        if($usuario['id'] != '' && $usuario['usuario'] != '' && $usuario['nome'] != ''){
            $this->__set('id', $usuario['id']);
            $this->__set('nome', $usuario['nome']);
            $this->__set('usuario', $usuario['usuario']);
        }

        return $this;//Retorna o objeto
    }

    //recuperar todos os usuários com base no termo pesquisado
    public function getAll(){
        $query = "
            select 
                id, usuario, nome
            from 
                tb_usuarios
            where
                usuario like :usuario and id != :id_usuario limit 5
        ";

        $stmt = $this->db->prepare($query);

        //atribui o valor retornado do banco com o atributo nome,
        //podendo ter qualquer coisa antes e depois do nome pesquisado
        $stmt->bindValue(':usuario', '%'.$this->__get('usuario').'%');
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);//retornar a pesquisa em forma de array
    }

    //recuperar as informações do usuário
    public function getInfoUsuario(){
        $query = "select id, nome, usuario from tb_usuarios where id = :id_usuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);//recuperar um único array associativo
    }
    
    //ver se o usuário está seguindo
    public function esta_seguindo($id_usuario_seguindo){
        $query = "select count(*) as result from seguidores where id_usuario = :id_usuario and id_usuario_seguindo = :id_usuario_seguindo";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    //recuoerar informações do usuário não logado
    public function getInfoUsuarioNaoLogado($id_usuario_seguindo){
        $query = "select id, nome, usuario from tb_usuarios where id = :id_usuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $id_usuario_seguindo);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);//recuperar um único array associativo
    }

    //seguir usuário
    public function seguirUsuario($id_usuario_seguindo){
        $query = "insert into seguidores(id_usuario, id_usuario_seguindo)value(:id_usuario, :id_usuario_seguindo)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
        $stmt->execute();

        return true;//verdadeiro para a inserção
    }

    //deixar de seguir usuário
    public function deixarSeguir($id_usuario_seguindo){
        $query = "delete from seguidores where id_usuario = :id_usuario and  id_usuario_seguindo = :id_usuario_seguindo";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
        $stmt->execute();

        return true;//verdadeiro para a inserção
    }


    //Total de seguidores
    public function getTotalSeguidoresNaoLogado($id_usuario_seguindo){
        $query = "select count(*) as total_seguidores from seguidores where id_usuario_seguindo = :id_usuario_seguindo ";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);//recuperar um único array associativo        
    }

    //Tottal que está seguindo
    public function getTotalSeguindoNaoLogado($id_usuario_seguindo){
        $query = "select count(*) as total_seguindo from seguidores where id_usuario = :id_usuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $id_usuario_seguindo);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);//recuperar um único array associativo        
    }

}
?>