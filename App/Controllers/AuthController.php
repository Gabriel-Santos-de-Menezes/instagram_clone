<?php 

//Controlador para trabalhar com a autenticação
namespace App\Controllers;

//Os recursoso do miniframework
use MF\Controller\Action;//abstração do controlador 
use MF\Model\Container;//abstração do container

class AuthController extends Action{


    public function autenticar(){
        
        $usuario = Container::getModel('Usuario');

        //Pegar os valores dos inputes e colocar nos atributos
        //$usuario->__set('nome',$_POST['nome']); 
        //$usuario->__set('email',$_POST['email']);
        $usuario->__set('usuario',$_POST['usuario']);
        $usuario->__set('senha', md5($_POST['senha']));

        //metodo responsável, por checar no banco de dados, se o usuário existe
        $usuario->autenticar();//dados do banco já setado nos atributos
        
        if($usuario->__get('id') != '' && $usuario->__get('nome') != '' && $usuario->__get('usuario') != ''){
            
            session_start();

            //Setar a super global session com os indices id, nome e usuário
            $_SESSION['id'] = $usuario->__get('id');
            $_SESSION['nome'] = $usuario->__get('nome');
            $_SESSION['usuario'] = $usuario->__get('usuario');

            header('location: /timeline');
       }
       //Se tiver erro, será direcionado para a página index
       else{
            header('location: /?login=erro');
       }
    }

    public function sair(){
        session_start();
        session_destroy();
        header('Location: /');
    }

}


?>