<?php

/**
 * Module principale de recherche d'élément
 * @author CONRAD Pascal
 * @version 1.0 29/03/2014
 */
namespace Search;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterfaces;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterfaces;

use Zend\EventManager\EventInterface;
use Zend\Mvc\ModuleRouteListener;

class Module implements AutoloaderProviderInterface,ConfigProviderInterface,BootstrapListenerInterface {
	/**
	 * Définition du Loader
	 * @return multitype:multitype:multitype:string
	 */
	public function getAutoloaderConfig() {
		return array (
				'Zend\Loader\StandardAutoLoader' => array (
						'namespace' => array (
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__ 
						) 
				) 
		);
	}
	
	public function getConfig() {
		return include __DIR__ . 'config/module.config.php';
	}
	
	public function onBootstrap(EventInterface $e) {
		
	}
}
