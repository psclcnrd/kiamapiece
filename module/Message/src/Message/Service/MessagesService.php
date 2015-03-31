<?php

namespace Message\Service;

use \Datetime;
use Search\Models\Messages;
use Message\Service\AbstractService;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class MessagesService extends AbstractService {

	/**
	 * load all the message in the database.
	 * @param $id Identifiant de l'utilisateur
	 */
	public function findAll($id) {
		$qb=$this->getRep()->createQueryBuilder('m');
		$qb->select(array('m','u1','u2','p'))
		->leftJoin('m.UserFrom','u1')
		->leftJoin('m.UserTo','u2')
		->leftJoin('m.Piece','p')
		->where('m.UserFrom=?1 or m.UserTo=?1')
		->orderBy('m.CreateDate','DESC');
		$qb->setParameter(1,$id);
		$query=$qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * retrieve a user by is unique id
	 * @param integer $id
	 * @return Search\Models\Pieces
	 */
	public function findById($id) {
		$qb=$this->getRep()->createQueryBuilder('m');
		$qb->select(array('m','u1','u2','p'))
		   ->leftJoin('m.UserFrom','u1')
		   ->leftJoin('m.UserTo','u2')
		   ->leftJoin('m.Piece','p')
		   ->where('m.id=?1');
		$qb->setParameter(1,$id);
		$query=$qb->getQuery();
		return $query->getSingleResult();
	}
	
	/**
	 * List par demandeur
	 * @param unknown $id
	 */
	public function findByUserFrom($id) {
		$qb=$this->getRep()->createQueryBuilder('m');
		$qb->select(array('m','u1','u2','p'))
		   ->leftJoin('m.UserFrom','u1')
		   ->leftJoin('m.UserTo','u2')
		   ->leftJoin('m.Piece','p')
		   ->where('m.UserFrom=?1');
		$qb->setParameter(1,$id);
		$query=$qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * List par demandeur
	 * @param unknown $id
	 */
	public function findByUserTo($id) {
		$qb=$this->getRep()->createQueryBuilder('m');
		$qb->select(array('m','u1','u2','p'))
		   ->leftJoin('m.UserFrom','u1')
		   ->leftJoin('m.UserTo','u2')
		   ->leftJoin('m.Piece','p')
		   ->where('m.UserTo=?1');
		$qb->setParameter(1,$id);
		$query=$qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * List par demandeur
	 * @param unknown $id
	 */
	public function findByPiece($id) {
		$qb=$this->getRep()->createQueryBuilder('m');
		$qb->select(array('m','u1','u2','p'))
		   ->leftJoin('m.UserFrom','u1')
		   ->leftJoin('m.UserTo','u2')
		   ->leftJoin('m.Piece','p')
		   ->where('m.Piece=?1');
		$qb->setParameter(1,$id);
		$query=$qb->getQuery();
		return $query->getResult();
	}
	/**
	 * Save a record.
	 * Note: if created date not initialized, this will do it.
	 * @param Search\Models\Message $data
	 */
	public function save(\Search\Models\Messages &$data) {
		if (!$data->getCreateDate() instanceof Datetime) $data->setCreateDate(new Datetime('now'));
		$this->getEm()->persist($data);
		$this->getEm()->flush();
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
	 * Lance la validation pour un nouvel utilisateur
	 * @param integer $id identifiant d'un nouvel utilisateur
	 */
	public function NotifyNewMail($id) {
		$message=$this->findById($id);
		$MessageMsg=$message->getMessage();
		$Pseudo=$message->getUserFrom()->getPseudo();
		$MessageFrom=$message->getUserFrom()->getEmail();
		$MessageTo=$message->getUserTo()->getEmail();
		$mail=new Message();
		$mail->setEncoding("UTF-8");
		$mail->addFrom('admin@kiamapiece.fr','Administrateur Kiamapiece');
		$mail->addTo($MessageTo);
		$mail->setSubject("kiamapiece.fr : un mail vous est adressé.");
		$htmlBody=<<<ENDBODY
Bonjour,<br>
Un nouveau mail vous a été adressé par <b>$Pseudo</b> :<br>
<br>
<div style='background-color : #cad6e6;border : thin solid #5479af'>
$MessageMsg
</div>
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

}

?>