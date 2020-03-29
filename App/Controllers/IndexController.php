<?php

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
			'usuario' => '',
			'senha' => ''
		);

		//atributo criado dinamicamente apartir do extends de Action,
		$this->view->erroCadastro = false;

		$this->render('cadastrar');
	}


	public function registrar(){



		$this->render('registrar');
	}

}


?>