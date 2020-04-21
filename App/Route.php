<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);


		$routes['cadastrar'] = array(
			'route' => '/cadastrar',
			'controller' => 'indexController',
			'action' => 'cadastrar'
		);

		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrar'
		);
		
		$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);
		
		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);

		$routes['timeline'] = array(
			'route' => '/timeline',
			'controller' => 'AppController',
			'action' => 'timeline'
		);
		
		$routes['post'] = array(
			'route' => '/post',
			'controller' => 'AppController',
			'action' => 'post'
		);
		
		$routes['pesquisarUsuario'] = array(
			'route' => '/pesquisarUsuario',
			'controller' => 'AppController',
			'action' => 'pesquisarUsuario'
		);
		
		//rota para o perfil do usuário
		$routes['perfil'] = array(
			'route' => '/perfil',
			'controller' => 'AppController',
			'action' => 'perfil'
		);

		$this->setRoutes($routes);
	}

}

?>