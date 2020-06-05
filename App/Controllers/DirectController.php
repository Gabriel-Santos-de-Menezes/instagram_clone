<?php
//Controlador para trabalhar com a autenticação
namespace App\Controllers;

//Os recursoso do miniframework
use MF\Controller\Action;//abstração do controlador 
use MF\Model\Container;//abstração do container

class DirectController extends Action{

    public function validaAutenticacao(){
        session_start();

        //veriricar se os atributos não estão setados e são diferentes de vazio
        if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['usuario']) || $_SESSION['usuario'] == ''){

            header('Locaction: /?login=erro');//redirecionado para a página de login
        }
    }

    //Direct do usuário
    public function direct(){
        //ver se a autenticação foi realizada
        $this->validaAutenticacao();//se for falso ira ser redirecionado para a página de login

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        $this->view->info_usuario = $usuario->getInfoUsuario();

        $this->render('/direct', 'layout2');
    }

    //Enviar  mensagem no direct
    public function enviarMensagem(){
        //ver se a autenticação foi realizada
        $this->validaAutenticacao();//se for falso ira ser redirecionado para a página de login

       $usuario = Container::getModel('Usuario');
       $usuario->__set('id', $_SESSION['id']);
        print_r($_POST);
       $mensagem = Container::getModel('Mensagem');
       
       $mensagem->__set('mensagem', $_POST['mensagem']);
       $mensagem->__set('from_usuario_id', $_SESSION['id']);
       $mensagem->__set('to_usuario_id', $_POST['to_usuario_id']);
       $mensagem->__set('mensagem', $_POST['mensagem']);
       if(isset($_POST['imagem'])){
           $mensagem->__set('imagem', $_POST['imagem']);
        }
       if(isset($_POST['emoji'])){
           $mensagem->__set('emoji', $_POST['emoji']);
        }

       $mensagem->enviarMensagem();
        
    }
}

?>