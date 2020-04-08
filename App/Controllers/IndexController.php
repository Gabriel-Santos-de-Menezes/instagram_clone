<?php

//Controlador para trabalhar com páginas externas da aplicação, como a home e o formulario
namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {

		$this->render('index');
	}


	public function cadastrar(){

		$this->view->usuario = array(
			'nome' => '',
			'email' => '',
			'usuario' => '',
			'senha' => ''
		);

		//atributo criado dinamicamente apartir do extends de Action,
		$this->view->erroCadastro = false;
		$this->view->erroCadastroUsuario = false;
		
		
		$this->render('cadastrar');
	}
	
	
	public function registrar(){
		
		//Instância de usuário com a conexão com o banco a partir de container
		$usuario = Container::getModel('Usuario');
		
		$this->view->erroCadastro = false;
		$this->view->erroCadastroUsuario = false;

		
		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('usuario', $_POST['usuario']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', md5($_POST['senha']));//colocando criptografia md5 na senha, convertendo em um rash de 32 caracteres

		
		//sucesso
		if($usuario->validarCadastro() && count($usuario->getUsuario()) == 0){

			$usuario->salvar();//gravar dados no banco
		
			$this->render('cadastrar');
		}

		//erro
		if(count($usuario->getUsuario()) > 0){
			$this->view->usuario = array(
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'usuario' => $_POST['usuario']
			);

			$this->view->erroCadastroUsuario = true;//atributo criado dinamicamente apartir do extends de Action, 
			
			$this->render('cadastrar');
		}

		//erro
		if(!$usuario->validarCadastro()){
			$this->view->usuario = array(
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'usuario' => $_POST['usuario']
			);

			$this->view->erroCadastro = true;//atributo criado dinamicamente apartir do extends de Action, 
			$this->render('cadastrar');
		}

	}

	

}


?>