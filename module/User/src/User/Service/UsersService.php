<?php

namespace User\Service;

use \Datetime;
use Search\Models\MainUser;
use Search\Models\ControlNewUsers;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class UsersService extends AbstractService {

	/**
	 * load all the users in the database.
	 */
	public function findAll() {
		$qb=$this->getRep()->createQueryBuilder('p');
		$query=$qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * retrieve a user by is unique id
	 * @param integer $id
	 * @return Search\Models\MainUser
	 */
	public function findById($id) {
		$qb=$this->getRep()->createQueryBuilder('u');
		$qb->select('u')
			->where('u.id=?1');
		$qb->setParameter(1,$id);
		$query=$qb->getQuery();
		return $query->getSingleResult();
	}
	
	/**
	 * retrieve a user by is email
	 * @param string $id
	 * @return Search\Models\MainUser
	 */
	public function findByEmail($email) {
		$qb=$this->getRep()->createQueryBuilder('u');
		$qb->select('u')
		->where('u.Email=?1');
		$qb->setParameter(1,$email);
		$query=$qb->getQuery();
		return $query->getSingleResult();
	}
	
	/**
	 * Control if the password given is the same as de database
	 * @param integer $id
	 * @param string $pwd
	 * @throws Exception
	 * @return boolean
	 */
	public function controlPassword($id,$pwd) {
		$query=$this->getEm()->createQuery("select u.Password from Search\Models\MainUser u where u.id=$id");
		$dbpwd=$query->getSingleScalarResult();
		if ($dbpwd==null) throw new Exception('Error ! no user for this id');
		if ($dbpwd==md5($pwd)) error_log("pwd correct!");else error_log("pwd error $dbpwd!=".md5($pwd));
		return ($dbpwd==md5($pwd));
	}
	
	/**
	 * Save a record
	 * @param Search\Models\MainUser $data
	 */
	public function save(\Search\Models\MainUser $data) {
		$this->getEm()->persist($data);
		$this->getEm()->flush();
	}
	
	/**
	 * Update password
	 * @param integer $id
	 * @param char $pwd
	 */
	public function updatePassword($id,$pwd) {
		$query=$this->getEm()->createQuery("update Search\Models\MainUser u set u.Password=?1 where u.id=?2");
		$query->setParameters(array(1 => md5($pwd),2 => $id));
		$query->execute();
	}
	
	/**
	 * delete a user
	 * @param integer $id
	 */
	public function delete($id) {
		$data=$this->findById($id);
		$this->getEm()->remove($data);
		$this->getEm()->flush();
	}
	
	/**
	 * change the date of the last activity on the site
	 * @param integer $id
	 */
	public function setLastActivity($id) {
		$data=$this->findById($id);
		$data->setLastActivity(new Datetime('now'));
		$this->getEm()->persist($data);
		$this->getEm()->flush();
	}
	
	/**
	 * Valide un nouvel utilisateur
	 * @param string $ctrl Somme MD5 de controle
	 */
	public function validate($ctrl) {
		$control=$this->getEm()->find('Search\Models\ControlNewUsers',$ctrl);
		if ($control!=null) {
			$user=$this->findById($control->getUserId());
			$user->setValidated('Y');
			$this->getEm()->persist($user);
			$this->getEm()->flush();
			$this->getEm()->remove($control);
			$this->getEm()->flush();
			return $user->getId();			
		}
		return false;
	}
	
	/**
	 * Lance la validation pour un nouvel utilisateur
	 * @param integer $id identifiant d'un nouvel utilisateur
	 */
	public function ExecuteValidation($id) {
		$user=$this->findById($id);
		$str=$user->getId().'kmpv1-20141230'.$user->getEmail().$user->getName().$user->getSurname().Date('Ymd');
		$ctrl=md5($str);
		$control=new ControlNewUsers();
		$control->setId($ctrl);
		$control->setUserId($user->getId());
		$control->setDateRequest(time());
		$this->getEm()->persist($control);
		$this->getEm()->flush();
		//---
		$mail=new Message();
		$mail->setEncoding("UTF-8");
		$mail->addFrom('admin@kiamapiece.fr','Administrateur Kiamapiece');
		$mail->addTo($user->getEmail());
		$mail->setSubject("kiamapiece.fr : controle de l'adresse.");
		$htmlBody=<<<ENDBODY
Bonjour,<br>
Vous devez valider votre compte en cliquant sur ce lien :
<br>
<b><a href='http://www.kiamapiece.fr/user/validate/$ctrl'>Cliquer ici pour valider votre demande</a></b><br>
<br>
A bientôt
ENDBODY;
		$htmlPart=new MimePart($htmlBody);
		$htmlPart->type="text/html";
		$body=new MimeMessage();
		$body->setParts(array($htmlPart));
		$mail->setBody($body);
		//---
		$transport=new SmtpTransport();
		$options=new SmtpOptions(array(
			'name' => 'ovh.net',
			'host' => 'ssl0.ovh.net',
			'port' => 465,
			'connection_class' => 'login',
			'connection_config' => array(
				'username' => 'admin@kiamapiece.fr',
				'password' => 'Du4BlieWnal',
				'ssl' => 'ssl',
		)
		));
		$transport->setOptions($options);
		$transport->send($mail);
	}
	
	/**
	 * Lance la validation pour un nouvel utilisateur
	 * @param integer $id identifiant d'un nouvel utilisateur
	 */
	public function LostProcedure($email) {
		$user=$this->findByEmail($email);
		if ($user==null) throw new Exception('User not found !!!');
		$str=$user->getId().'kmpv1-20141230'.$user->getEmail().$user->getName().$user->getSurname().Date('Ymd');
		$ctrl=md5($str);
		$control=new ControlNewUsers();
		$control->setId($ctrl);
		$control->setUserId($user->getId());
		$control->setDateRequest(time());
		$this->getEm()->persist($control);
		$this->getEm()->flush();
		//---
		$mail=new Message();
		$mail->setEncoding("UTF-8");
		$mail->addFrom('admin@kiamapiece.fr','Administrateur Kiamapiece');
		$mail->addTo($user->getEmail());
		$mail->setSubject("kiamapiece.fr : Demande de changement de mot de passe.");
		$htmlBody=<<<ENDBODY
Bonjour,<br>
Vous devez valider votre demande de changement en cliquant sur ce lien :
<br>
<b><a href='http://www.kiamapiece.fr/user/validpwd/$ctrl'>Cliquer ici pour valider votre demande</a></b><br>
<br>
A bientôt
ENDBODY;
		$htmlPart=new MimePart($htmlBody);
		$htmlPart->type="text/html";
		$body=new MimeMessage();
		$body->setParts(array($htmlPart));
		$mail->setBody($body);
		//---
		$transport=new SmtpTransport();
		$options=new SmtpOptions(array(
				'name' => 'ovh.net',
				'host' => 'ssl0.ovh.net',
				'port' => 465,
				'connection_class' => 'login',
				'connection_config' => array(
						'username' => 'admin@kiamapiece.fr',
						'password' => 'Du4BlieWnal',
						'ssl' => 'ssl',
				)
		));
		$transport->setOptions($options);
		$transport->send($mail);
	}
	
	/**
	 * Search the old control for new users
	 */
	public function deleteOldControl() {
		$t=time()-7200;
		$query=$this->getEm()->createQuery('select c from Search\Models\ControlNewUsers c where c.DateRequest<=?1')->setParameter(1,$t);
		$listControl=$query->getResult();
		$cnt=count($listControl);
		if ($cnt) {
			foreach($listControl as $control) {
				$this->getEm()->remove($control);
			}
			$this->getEm()->flush();
		}
		return $cnt;
	}
	
	/**
	 * Valide une demande changement de mot de passe
	 * @param string $control md5 de l'id de changement
	 * @return boolean|integer
	 */
	public function validatePwdChange($control) {
		$query=$this->getEm()->createQuery('select c from Search\Models\ControlNewUsers c where c.id=?1')->setParameter(1,$control);
		$result=$query->getSingleResult();
		if ($result==null) return false;
		$id=$result->getUserId();
		$this->getEm()->remove($result);
		$this->getEm()->flush();
		return $id;
	}
}

?>