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
        print_r($_POST);
        $usuario->__set('usuario',$_POST['usuario']);
        $usuario->__set('senha', md5($_POST['senha']));

        //metodo responsável, por checar no banco de dados, se o usuário existe
        $usuario->autenticar();//dados do banco já setado nos atributos
        
        if($usuario->__get('id') != '' && $usuario->__get('nome') != '' && $usuario->__get('usuario') != ''){

            
       }
    }

}


?>