<?php

namespace User\Service\Factory;

/**
 * Creation of ServiceFactory for the declaration in the array of module.config.php
 * @author CONRAD Pascal
 * @version 1.0 19/12/2014
 */

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use User\Service\AddressesService;

class AddressesServiceFactory implements FactoryInterface {
	
	/**
	 * (non-PHPdoc)
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 */
	public function createService(ServiceLocatorInterface $serviceLocator) {
		$entityManager=$serviceLocator->get('Doctrine\ORM\EntityManager');
		$repository=$entityManager->getRepository('Search\Models\Addresses');
		return new AddressesService($entityManager,$repository);
	}
}

?>