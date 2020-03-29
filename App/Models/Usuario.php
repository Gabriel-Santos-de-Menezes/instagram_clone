<?php 

namespace App\Models;//O nome é proporcional da localização do script

use MF\Model\Model;

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

        $query = "insert into usuarios(nome, usuario, senha)values(:nome, :usuario, :senha)";

        $stmt = $this->db->prepare($quey);
        //pegar o atributoe atribuir como indice dinâmico da query
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':usuario', $this->__get('usuario'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();

        return $this;
        
    }

    //validar se um cadastro pode ser feito
    public function validarCadastro(){//verifica se todos os campos estão validos

        $valido = true;
        if(strlen($this->__get('telefone')) > 9){//Retorna o tamanho da string
            $valido = false;
        }
        if(strlen($this->__get('nome')) > 3){//Retorna o tamanho da string
            $valido = false;
        }
        if(strlen($this->__get('usuario')) > 3){//Retorna o tamanho da string
            $valido = false;
        }
        if(strlen($this->__get('senha')) > 6){//Retorna o tamanho da string
            $valido = false;
        }

        return $valido;

    }

    //recuperar um usuário por usuario e email
    public function getUsuario(){
        
        $qury = "select nome, usuario, email from usuarios where usuario = :usuario or email = :email";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':usuario', $this->__get('usuario'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);//retorna um array associativo
    }
}



?>