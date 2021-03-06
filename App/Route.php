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
		//rota para pesquisar por um usuário 
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
		
		//rota para editar o perfil do usuário
		$routes['editar_perfil'] = array(
			'route' => '/editar_perfil',
			'controller' => 'AppController',
			'action' => 'editar_perfil'
		);
		
		//rota para o perfil de outro usuário
		$routes['user'] = array(
			'route' => '/user',
			'controller' => 'AppController',
			'action' => 'user'
		);
		
		//rota para seguir ou deixar de seguir o usuário
		$routes['acao'] = array(
			'route' => '/acao',
			'controller' => 'AppController',
			'action' => 'acao'
		);
		
		//rota para curtir ou descurtir o post do usuário
		$routes['curtidas'] = array(
			'route' => '/curtidas',
			'controller' => 'AppController',
			'action' => 'curtidas'
		);

		//rota para add o comentar no post do usuário
		$routes['comentar'] = array(
			'route' => '/comentar',
			'controller' => 'AppController',
			'action' => 'comentar'
		);

		//rota para seguir ou deixar de seguir o usuário
		$routes['mostrar_curtidas_galeria_perfil'] = array(
			'route' => '/mostrar_curtidas_galeria_perfil',
			'controller' => 'AppController',
			'action' => 'mostrar_curtidas_galeria_perfil'
		);

		//rota para editar o perfil do usuário
		$routes['edit'] = array(
			'route' => '/edit',
			'controller' => 'AppController',
			'action' => 'edit'
		);

		
		//rota para editar o perfil do usuário
		$routes['editar_perfil'] = array(
			'route' => '/editar_perfil',
			'controller' => 'AppController',
			'action' => 'editar_perfil'
		);
		
		//rota para o direct do usuário
		$routes['direct'] = array(
			'route' => '/direct',
			'controller' => 'DirectController',
			'action' => 'direct'
		);

		//rota para o direct do usuário
		$routes['enviarMensagem'] = array(
			'route' => '/enviarMensagem',
			'controller' => 'DirectController',
			'action' => 'enviarMensagem'
		);

		//rota para pesquisar por um usuário no direct
		$routes['pesquisarUsuarioDirect'] = array(
			'route' => '/pesquisarUsuarioDirect',
			'controller' => 'DirectController',
			'action' => 'pesquisarUsuarioDirect'
		);
		
		//rota para falar com um usuário no direct
		$routes['falar_com_usuario'] = array(
			'route' => '/falar_com_usuario',
			'controller' => 'DirectController',
			'action' => 'falar_com_usuario'
		);

		
		$this->setRoutes($routes);
	}

}

?>