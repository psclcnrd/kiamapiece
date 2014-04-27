<?php

/**
 * Module principale de recherche d'élément
 * @author CONRAD Pascal
 * @version 1.0 29/03/2014
 */
namespace Search;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

use Zend\EventManager\EventInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream as LogStream;

class Module implements AutoloaderProviderInterface,ConfigProviderInterface,BootstrapListenerInterface,ServiceProviderInterface {
	/**
	 * Définition du Loader
	 * @return multitype:multitype:multitype:string
	 */
	public function getAutoloaderConfig() {
		return array (
				'Zend\Loader\ClassMapAutoloader' => array(
						__DIR__ . '/autoload_classmap.php',
				),				
				'Zend\Loader\StandardAutoloader' => array (
						'namespaces' => array (
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__ 
						) 
				),
		);
	}
	
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function onBootstrap(EventInterface $e) {
		$e->getApplication()->getServiceManager()->get('translator');
	}
	
	public function getServiceConfig() {
		$config=$this->getConfig();
		return array(
			'factories' => array(
				'Zend\Log' => function ($sm) {
					$logger=new Logger();
					$writter=new LogStream('/home/pascal/public_html/zf2biz/kiamapiece/data/logs/kmp.log');
					$logger->addWriter($writter);
					return $logger;
				}
			),
		);
	}
}
