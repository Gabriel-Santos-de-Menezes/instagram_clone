<?php 

//Controlador para trabalhar com as páginas restritas
//configuadas conforme o usuário autenticado
namespace App\Controllers;

//Os recursoso do miniframework
use MF\Controller\Action;//abstração do controlador 
use MF\Model\Container;//abstração do container

class AppController extends Action{
    
    //renderiza a view timile
    public function timeline(){

        $this->validaAutenticacao();//se for falso ira ser redirecionado para a página de login

        //recuperar os posts
        $post = Container::getModel('Post');//retorna a conexão com o banco configurada
        
        $post->__set('id_usuario', $_SESSION['id']);

        

        $this->render('/timeline');
    }

    public function validaAutenticacao(){
        session_start();

        //veriricar se os atributos não estão setados e são diferentes de vazio
        if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['usuario']) || $_SESSION['usuario'] == ''){

            header('Locaction: /?login=erro');//redirecionado para a página de login
        }
    }

}
?>