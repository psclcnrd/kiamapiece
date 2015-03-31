<?php

namespace Request\Service;

use Search\Models\Request;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class RequestsService extends AbstractService {

	/**
	 * load all the users in the database. It's use is discouraged
	 */
	public function findAll() {
		$qb=$this->getRep()->createQueryBuilder('p');
		$query=$qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * retrieve a request by is unique id
	 * @param integer $id
	 * @return Search\Models\Request
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
	 * retrieve one or more request by the depositary user
	 * @param integer $userId
	 * @return array of Search\Models\Request
	 */
	public function findByDepositaryUser($userId) {
		$qb=$this->getRep()->createQueryBuilder('u');
		$qb->select('u')
		   ->where('u.DepositaryUserId=?1');
		$qb->setParameter(1,$userId);
		$query=$qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * retrieve one or more request by the applicant user Id
	 * @param integer $userId
	 * @return array of Search\Models\Request
	 */
	public function findByUserApplicant($userId) {
		$qb=$this->getEm()->createQueryBuilder();
		$qb->from('Search\Models\Request','u')
		   ->select(array('u','p','b','a','t'))
		   ->leftJoin('u.Piece','p')
		   ->leftJoin('p.Brand','b')
		   ->leftJoin('p.ApplianceType','a')
		   ->leftJoin('p.PieceType','t')
		   ->where('u.UserApplicantId=?1');
		$qb->setParameter(1,$userId);
		$query=$qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * Save a record
	 * @param Search\Models\Request $data
	 */
	public function save(\Search\Models\Request $data) {
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
	 * Notifie l'interret d'une pièce à son propiétaire
	 * @param Search\Model\Request $request
	 * @param Search\Model\User $from
	 * @param Search\Model\User $to
	 * @param string $msg Message à envoyer
	 */
	public function notifyDepositary($request,$from,$to,$msg) {
		$pseudo=$from->getPseudo();
		$brand=$request->getPiece()->getBrand()->Description;
		$apt=$request->getPiece()->getApplianceType()->Description;
		$pt=$request->getPiece()->getPieceType()->Description;
		$MessageTo=$to->getEmail();
		$mail=new Message();
		$mail->setEncoding("UTF-8");
		$mail->addFrom('admin@kiamapiece.fr','Administrateur Kiamapiece');
		$mail->addTo($MessageTo);
		$mail->setSubject("kiamapiece.fr : Information sur une pièce.");
		$htmlBody=<<<ENDBODY
Bonjour,<br>
<br>
<b>$pseudo</b>$msg<br>
<br>
<b>Marque :</b>$brand<br>
<b>Type d'appareil :</b>$apt<br>
<b>Type de pièce :</b>$pt<br>
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