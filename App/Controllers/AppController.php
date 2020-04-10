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

        

        $this->render('/timeline');
    }

}
?>