<?php 

//Controlador para trabalhar com a autenticação
namespace App\Controllers;

//Os recursoso do miniframework
use MF\Controller\Action;//abstração do controlador 
use MF\Model\Container;//abstração do container

class AuthContoller extends Action{


    public function autenticar(){
        $usuario = Container::getModel('Usuario');
    }

}


?>