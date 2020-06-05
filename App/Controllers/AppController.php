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
        $posts = $post->getAll();//retorna um array de todos os posts
        //$comentarios = $post->totalComentarios();
        $comentarios = $post->totalComentarios();
       
        $this->view->comentarios = $comentarios;//Manda o array de posts para a timeline

        $this->view->posts = $posts;//Manda o array de posts para a timeline

        
        

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        $this->view->info_usuario = $usuario->getInfoUsuario();

        $this->render('/timeline', 'layout2');
    }

    //renderiza página do usuário que está logado
    public function perfil(){
        //ver se a autenticação foi realizada
        $this->validaAutenticacao();//se for falso ira ser redirecionado para a página de login

        $post = Container::getModel('Post');//retorna a conexão com o banco configurada
        $post->__set('id_usuario', $_SESSION['id']);

        $posts = $post->getPostUsuario();
        $this->view->info_total_posts = $post->getTotalPostUsuario();

        $this->view->posts = $posts;//Manda o array de posts para o perfil
        
        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        //Envia os dados do usuário para a página perfil
        $this->view->info_total_seguidores = $usuario->getTotalSeguidoresLogado();
        $this->view->info_total_seguindo = $usuario->getTotalSeguindoLogado();
        
        $this->view->info_usuario = $usuario->getInfoUsuario();

        $this->render('/perfil', 'layout2');
    }
    
    //renderiza pagina do usuario que não está logado
    public function user(){
        
        $this->validaAutenticacao();//se for falso ira ser redirecionado para a página de login
        
        $usuario = Container::getModel('Usuario');
        //setando o id da url para o atributo id
        $usuario->__set('id', $_SESSION['id']);

        //if ternário para ver se o parametro get id_usuario está setado
        $id_usuario_seguindo = isset($_GET['id']) ? $_GET['id'] : '';

        //Envia os dados do usuário para a página user
        $this->view->esta_seguindo = $usuario->esta_seguindo($id_usuario_seguindo);
        $this->view->info_usuarioNaoLogado = $usuario->getInfoUsuarioNaoLogado($id_usuario_seguindo);
        $this->view->info_usuario = $usuario->getInfoUsuario();
        $this->view->info_total_seguidores = $usuario->getTotalSeguidoresNaoLogado($id_usuario_seguindo);
        $this->view->info_total_seguindo = $usuario->getTotalSeguindoNaoLogado($id_usuario_seguindo);
        //retorna a conexão com o banco configurada
        $post = Container::getModel('Post');
        $post->__set('id_usuario', $_GET['id']);
        
        $this->view->posts = $post->getPostUsuario();
        $this->view->info_total_posts = $post->getTotalPostUsuario();
        
        
        $this->render('/user', 'layout2');
    }

    //Lógica para alterar perfil do usuário
    public function edit(){
        $this->validaAutenticacao();//se for falso ira ser redirecionado para a página de login
        
        $usuario = Container::getModel('Usuario');

        $usuario->__set('id', $_SESSION['id']);
        $this->view->info_usuario = $usuario->getInfoUsuario();


    
        $this->render('/edit', 'layout2');
    }
    
    
    //lógica para adicionar os posts no banco
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
            
    public function editar_perfil(){
        $this->validaAutenticacao();//se for falso ira ser redirecionado para a página de login
        $usuario = Container::getModel('Usuario');//Instancia do modelo Usuario
             
        
        if(isset($_POST)){

            
            //Se o arquivo existir, poderá ser salvo no bd  
            
            //Pegar a extensão
            $extensao = strtolower(substr($_FILES['foto_perfil']['name'], -4));
            $novo_nome = md5(time()). $extensao;
            $diretorio = "img_perfil/";
            
            //Efetua o upload
            move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $diretorio.$novo_nome);
            $usuario->__set('foto_perfil',$novo_nome);
            
            $usuario->__set('id', $_SESSION['id']);
            $usuario->__set('nome', $_POST['nome']);
            $usuario->__set('usuario', $_POST['usuario']);
            $usuario->__set('biografia', $_POST['biografia']);
            $usuario->__set('email', $_POST['email']);

                 
            //metodo que salva os dados setados, no banco
            $usuario->editar();
            header('Location: /perfil');
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

        //Verifica se existe a variável usuario
        if(isset($_GET['usuario']) && $_GET['usuario'] != ''){
            //retorna um obj com a conexão com banco de dados
            $usuario = Container::getModel('Usuario');
            $usuario->__set('usuario', $_GET['usuario']);
            $usuario->__set('id', $_SESSION['id']);
            if(empty($usuario)){
                
            }else{
                //retorna um array com os usuarios pesquisados
                $usuarios = $usuario->getAll(); 
                if(!empty($usuarios)){
                    $this->view->usuarios = $usuarios;
                    foreach ($this->view->usuarios as $key => $usuario) {
                        echo '<div class="pt-2">';
                            echo '<a href="/user?id=' .$usuario['id'] . '" class="d-flex  ml-3">';
                                echo '<div class="d-inline-block ">';
                                    echo '<img src="img_perfil/' . $usuario['foto_perfil'] .'" class="foto_perfil_pesquisa_usuario rounded-circle border" alt="foto_perfil">';
                                echo '</div>';

                                echo '<div class="d-inline-block ml-2">';
                                    echo '<p>' . $usuario['usuario']. '</p>';
                                    echo '<p class="text-secondary p-0">' . $usuario['nome'] . '</p>';
                                echo '</div>';
                            echo '</a>';
                            echo '<hr class="mb-0">';
                        echo '</div>';
                    }
                } else {
                    // Se a consulta não retornar nenhum valor, exibi mensagem para o usuário
                    echo "Nenhum usuário encontrado!";
                }
            }
        }
    }

    //Lógic para seguir ou deixar de seguir o usuário
    public function acao(){

        //ver se a autenticação foi realizada
        $this->validaAutenticacao();//se for falso ira ser redirecionado para a página de login

        //if ternário, caso o valor não seja vazio, a variavel acao recebe o parametro passado polo get, caso esteja vazia, recebe vazio
        $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
        $id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';

        $usuario = Container::getModel('Usuario');//Instancia do modelo Usuario
        $usuario->__set('id', $_SESSION['id']);//setando id so usuário ao atributo id

        if($acao == 'seguir'){
            $usuario->seguirUsuario($id_usuario_seguindo);
        }
        else if($acao == 'deixar_de_seguir'){
            $usuario->deixarSeguir($id_usuario_seguindo);
        }

        header('Location: /user?id=' .$id_usuario_seguindo . '');
    }

    public function mostrar_curtidas_galeria_perfil(){
        
    }

    public function curtidas(){
         //ver se a autenticação foi realizada
         $this->validaAutenticacao();//se for falso ira ser redirecionado para a página de login
        //verificar se os parametros foram passados pelo método do ajax curtir
         if(isset($_GET['acao']) && $_GET['acao'] != '' &&isset($_GET['id_post']) && $_GET['id_post'] != ''){
             
            $post = Container::getModel('Post');//retorna a conexão com o banco configurada
             $post->__set('id_usuario', $_SESSION['id']);
             $id_post = $_GET['id_post'];

             if($_GET['acao'] == "curtir"){
                    $post->curtirPost($id_post);

                    $posts = $post->getAll();//retorna um array de todos os posts
                    $this->view->posts = $posts;//Manda o array de posts para a timeline
                }
                else if($_GET['acao'] == "descurtir"){
                    $post->descurtirPost($id_post); 
                    
                    $posts = $post->getAll();//retorna um array de todos os posts
                    $this->view->posts = $posts;//Manda o array de posts para a timeline
             }
 
         }
         return true;
    }

    public function comentar(){

         //ver se a autenticação foi realizada
         $this->validaAutenticacao();//se for falso ira ser redirecionado para a página de login

         if(isset($_GET['id_post']) && $_GET['id_post'] != '' &&isset($_GET['comentario']) && $_GET['comentario'] != ''){

            //Intância do model 
            $post = Container::getModel('Post');


            $post->__set('id_usuario', $_SESSION['id']);

            $post->salvarComentario($_GET['id_post'], $_GET['comentario']);

            //header('Location: /timeline');
         }
        return true;

    }

    

}
?>