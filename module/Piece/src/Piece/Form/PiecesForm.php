<?php 

namespace Piece\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\I18n\Translator\Translator;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

class PiecesForm extends Form {

  public function __construct(ServiceLocatorInterface $sl) {
    parent::__construct('Pieces');
    // On récupère les services nécessaires
    $em=$sl->get('doctrine.entitymanager.orm_default');
    $translator=$sl->get('translator');
    // Recherche de l'utilisateur connecté
    $auth=new AuthenticationService();
    $auth->setStorage(new SessionStorage("kmpv1"));
    $userId=$auth->getIdentity();
    
    $this->setAttribute('method','post');
    $this->add(array(
    	'name' => 'id',
    	'type' => 'hidden'
    ));
    $this->add(array(
    		'name' => 'Address',
    		'type' => 'Search\Form\Element\MySelect',
    		'required' => true,
    		'options' => array(
    				'entity' => 'Search\Models\Addresses',
    				'em' => $em,
    				'label' => $translator->translate('Edit_Address','search'),
    				'valueField' => 'id',
    				'textField' => 'AddressName',
    				'orderBy' => 'AddressName',
    				'filter' => array('field' => 'UserId', 'value' => $userId)
    		)
    ));
    $this->add(array(
		     'name' => 'Brand',
		     'type' => 'Search\Form\Element\MySelect',
		     'required' => true,
		     'options' => array(
					'entity' => 'Search\Models\Brand',
		     		'em' => $em,
					'label' => $translator->translate('Edit_Constructor','search'),
					'valueField' => 'id',
					'textField' => 'Description',
					'orderBy' => 'Description'
		     )
	));
    $this->add(array(
    		'name' => 'ApplianceType',
    		'type' => 'Search\Form\Element\MySelect',
    		'required' => true,
    		'options' => array(
    				'entity' => 'Search\Models\ApplianceType',
    				'em' => $em,
    				'label' => $translator->translate('Edit_Appliance_Type','search'),
    				'valueField' => 'id',
    				'textField' => 'Description',
    				'orderBy' => 'Description'
    		)
    ));
    $this->add(array(
    		'name' => 'PieceType',
    		'type' => 'Search\Form\Element\MySelect',
    		'required' => true,
    		'options' => array(
    				'entity' => 'Search\Models\PieceType',
    				'em' => $em,
    				'label' => $translator->translate('Edit_PieceType','search'),
    				'valueField' => 'id',
    				'textField' => 'Description',
    				'orderBy' => 'Description'
    		)
    ));
    $this->add(array(
    		'name' => 'SendingMode',
    		'em' => $em,
    		'type' => 'Search\Form\Element\MySelect',
    		'required' => true,
    		'options' => array(
    				'entity' => 'Search\Models\SendingMode',
    				'em' => $em,
    				'label' => $translator->translate('Edit_Sending_Mode','search'),
    				'valueField' => 'id',
    				'textField' => 'Description',
    				'orderBy' => 'Description'
    		)
    ));
    $this->add(array(
    	'name' => 'Comments',
    	'type' => 'Zend\Form\Element\Textarea',
    	'required' => false,
    	'options' => array(
    				'label' => $translator->translate('Edit_Comments','search'),
    	),
    	'attributes' => array('cols' => 80,'rows' => 6)    		
    ));
    $this->add(array(
    		'name' => 'submit',
    		'attributes' => array(
		    			'type' => 'submit',
		    			'label' => $translator->translate('Edit_Submit','search'),
		    			'value' => 'valider'
    				)
    		
    ));
  }
}
