<?php
//Controlador para trabalhar com a autenticação
namespace App\Controllers;

//Os recursoso do miniframework
use MF\Controller\Action; //abstração do controlador 
use MF\Model\Container; //abstração do container

class DirectController extends Action
{

    public function validaAutenticacao()
    {
        session_start();

        //veriricar se os atributos não estão setados e são diferentes de vazio
        if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['usuario']) || $_SESSION['usuario'] == '') {

            header('Locaction: /?login=erro'); //redirecionado para a página de login
        }
    }

    //Direct do usuário
    public function direct()
    {
        //ver se a autenticação foi realizada
        $this->validaAutenticacao(); //se for falso ira ser redirecionado para a página de login

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        $this->view->info_usuario = $usuario->getInfoUsuario();

        $this->render('/direct', 'layout2');
    }

    //Enviar  mensagem no direct
    public function enviarMensagem()
    {
        //ver se a autenticação foi realizada
        $this->validaAutenticacao(); //se for falso ira ser redirecionado para a página de login

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);
        print_r($_POST);
        $mensagem = Container::getModel('Mensagem');
        print_r($_GET);

        $mensagem->__set('mensagem', $_POST['mensagem']);
        $mensagem->__set('from_usuario_id', $_SESSION['id']);
        $mensagem->__set('to_usuario_id', $_GET['to_usuario']);
        $mensagem->__set('mensagem', $_POST['mensagem']);
        if (isset($_POST['imagem'])) {
            $mensagem->__set('imagem', $_POST['imagem']);
        }
        if (isset($_POST['emoji'])) {
            $mensagem->__set('emoji', $_POST['emoji']);
        }

        $mensagem->salvar();
    }

    public function pesquisarUsuario()
    {

        //ver se a autenticação foi realizada
        $this->validaAutenticacao(); //se for falso ira ser redirecionado para a página de login

        //Verifica se existe a variável usuario
        if (isset($_GET['usuario']) && $_GET['usuario'] != '') {
            //retorna um obj com a conexão com banco de dados
            $usuario = Container::getModel('Usuario');
            $usuario->__set('usuario', $_GET['usuario']);
            $usuario->__set('id', $_SESSION['id']);
            if (empty($usuario)) {
            } else {
                //retorna um array com os usuarios pesquisados
                $usuarios = $usuario->getAll();
                if (!empty($usuarios)) {
                    $this->view->usuarios = $usuarios;
                    foreach ($this->view->usuarios as $key => $usuario) {
                        echo '<div class="pt-1 resultado_pesquisa_direct">';
                        echo '<a href="/falar_com_usuario?id=' . $usuario['id'] . '"   class="d-flex  ml-3">';
                        echo '<div class="d-inline-block ">';
                        echo '<img src="img_perfil/' . $usuario['foto_perfil'] . '" class="foto_perfil_pesquisa_usuario rounded-circle border" alt="foto_perfil">';
                        echo '</div>';

                        echo '<div class="d-inline-block ml-2">';
                        echo '<p>' . $usuario['usuario'] . '</p>';
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
    public function falar_com_usuario()
    {

        $this->validaAutenticacao();

        if ($_GET) {
            if (isset($_GET['id'])) {


                $usuario = Container::getModel('Usuario');
                $usuario->__set('id', $_GET['id']);
                $this->view->info_usuario = $usuario->getInfoUsuario();
                //print_r($this->view->info_usuario);
                //print_r($usuario);
                //print_r($this->view->info_usuario);
                $mensagem = Container::getModel('Mensagem');
                $mensagem->__set('to_usuario_id', $_GET['id']);

                $mensagem->__set('from_usuario_id', $_SESSION['id']);
                
                $this->view->mensagens = $mensagem->Consultar();


                $this->render('/direct', 'layout2');
            }
        }
    }

    public function recuperarMensagens()
    {

        $this->validaAutenticacao();
    }
}
