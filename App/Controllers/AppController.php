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
        //$postImg = Container::getModel('Imagens_post');//retorna a conexão com o banco configurada
        
        $post->__set('id_usuario', $_SESSION['id']);
        //$postImg->__set('id_usuario', $_SESSION['id']);

        $posts = $post->getAll();//retorna um array de todos os posts

        $this->view->posts = $posts;//Manda o array de posts para a timeline

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);





        $this->render('/timeline');
    }

    public function post(){
        $this->validaAutenticacao();//se for falso ira ser redirecionado para a página de login
        $post = Container::getModel('Post');//retorna a conexão com o banco configurada
        
        if(isset($_FILES['img_post'])){
            //Se o arquivo existir, poderá ser salvo no bd
            $post->__set('post', $_POST['post']);
            $post->__set('id_usuario', $_SESSION['id']);
    
            
            //Pegar a extensão
            $extensao = strtolower(substr($_FILES['img_post']['name'], -4));
            $novo_nome = md5(time()). $extensao;
            
            $diretorio = "uploads/";
            
            //Efetua o upload
            move_uploaded_file($_FILES['img_post']['tmp_name'], $diretorio.$novo_nome);
            $post->__set('imagem',$novo_nome);
            
            $post->salvar();//metodo que salva os dados setados, no banco

            header('Location: /timeline');
        }


    }

    public function validaAutenticacao(){
        session_start();

        //veriricar se os atributos não estão setados e são diferentes de vazio
        if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['usuario']) || $_SESSION['usuario'] == ''){

            header('Locaction: /?login=erro');//redirecionado para a página de login
        }
    }


    public function pesquisarUsuario(){

        //ver se a autenticação foi realizada
        $this->validaAutenticacao();//se for falso ira ser redirecionado para a página de login

        //if ternário
        $pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

        $usuarios = array();

        if($pesquisarPor != ""){

            //retorna um obj com a conexão com banco de dados
            $usuario = Container::getModel('Usuario');
            $usuario->__set('usuario', $pesquisarPor);
            $usuario->__set('id', $_SESSION['id']);
            //retorna um array com os usuarios pesquisados
            $usuarios = $usuario->getAll(); 
        }

        $usuario = Container::getMOdel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        $this->view->usuarios = $usuarios;

        $this->render('timiline');
    }

}
?>