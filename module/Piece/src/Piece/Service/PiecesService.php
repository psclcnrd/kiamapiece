<?php

namespace Piece\Service;

use \DateTime;
use Search\Models\Pieces;
use Search\Models\Addresses;
use Search\Models\Brand;
use Search\Models\ApplianceType;
use Search\Models\PieceType;
use Search\Models\SendingMode;
use Search\Models\Status;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class PiecesService extends AbstractService {

	/**
	 * load all the pieces in the database. May be never used
	 */
	public function findAll() {
		$qb=$this->getRep()->createQueryBuilder('p');
		$query=$qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * retrieve a piece by is unique id
	 * @param integer $id
	 * @return Search\Models\Pieces
	 */
	public function findById($id) {
		$qb=$this->getRep()->createQueryBuilder('p');
		$qb->select(array('p','u','b','a','t'))
			->leftJoin('p.User','u')
			->leftJoin('p.Brand','b')
			->leftJoin('p.ApplianceType','a')
			->leftJoin('p.PieceType','t')		
			->where('p.id=?1');
		$qb->setParameter(1,$id);
		$query=$qb->getQuery();
		return $query->getSingleResult();
	}
	
	/**
	 * retrieve a piece by is user id
	 * @param integer $userId
	 * @return Search\Models\Pieces
	 */
	public function findByUser($userId) {
		$qb=$this->getRep()->createQueryBuilder('p');
		$qb->select(array('p','u','b','a','t'))
			->leftJoin('p.User','u')
			->leftJoin('p.Brand','b')
			->leftJoin('p.ApplianceType','a')
			->leftJoin('p.PieceType','t')
			->where('p.User=?1')
			->orderBy('p.CreateDate');
		$qb->setParameter(1,$userId);
		$query=$qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * Recherche des pièces par critères
	 * @param unknown $crit1 Région
	 * @param unknown $crit2 Marque
	 * @param unknown $crit3 Type d'appareil
	 * @param unknown $crit4 Type de pièce
	 */
	public function findByCriteria($crit1,$crit2,$crit3,$crit4,$firstRecord=0) {
		$qb=$this->getRep()->createQueryBuilder('a');
		// On récupère les données de la fiche
		$qb->select(array('a','b','c','d','e','f'))
		   ->leftJoin('a.User','b')
		   ->leftJoin('a.Brand','c')
		   ->leftJoin('a.ApplianceType','d')
 		   ->leftJoin('a.PieceType','e')
		   ->leftJoin('a.Address','f')
		   ->setMaxResults($this->config['search_module']['line_per_page'])
		   ->setFirstResult($firstRecord);
		$qb->where('a.Status=1');
		if ($crit1!=0) $qb->andWhere("b.RegionId=$crit1");
		if ($crit2!=0) $qb->andWhere("a.Brand=$crit2");
		if ($crit3!=0) $qb->andWhere("a.ApplianceType=$crit3");
		if ($crit4!=0) $qb->andWhere("a.PieceType=$crit4");
		$query=$qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * Recherche des pièces par critères
	 * @param unknown $crit1 Région
	 * @param unknown $crit2 Marque
	 * @param unknown $crit3 Type d'appareil
	 * @param unknown $crit4 Type de pièce
	 */
	public function countWithCriteria($crit1,$crit2,$crit3,$crit4) {
		$qb=$this->getRep()->createQueryBuilder('a');
		$qb->select('count(a.id)')
		   ->leftJoin('a.User','b')
		   ->where('a.Status=1');
		if ($crit1!=0) $qb->andWhere("b.RegionId=$crit1");
		if ($crit2!=0) $qb->andWhere("a.Brand=$crit2");
		if ($crit3!=0) $qb->andWhere("a.ApplianceType=$crit3");
		if ($crit4!=0) $qb->andWhere("a.PieceType=$crit4");
		$query=$qb->getQuery();
		return $query->getSingleScalarResult();
	}
	
	/**
	 * Return the last pieces entries in the database
	 */
	public function findLast($firstRecord=0) {
		$qb=$this->getRep()->createQueryBuilder('p');
		$qb->select(array('p','b','a','t'))
			->leftJoin('p.User','u')
			->leftJoin('p.Brand','b')
			->leftJoin('p.ApplianceType','a')
			->leftJoin('p.PieceType','t')
		    ->where('p.Status=1')
			->orderBy('p.CreateDate','DESC')
			->setMaxResults($this->config['search_module']['line_per_page'])
		    ->setFirstResult($firstRecord);		
		//->setFirstResult(1)
		//->setMaxResults(10)
		$query=$qb->getQuery();
		return $query->getResult();		
	}
	
	/**
	 * Count the number of pieces availables
	 * @return integer
	 */
	public function countPieces() {
		$qb=$this->getEm()->createQuery('SELECT COUNT(p.id) FROM Search\Models\Pieces p WHERE p.Status=1');
		return $qb->getSingleScalarResult();
	}
	
	/**
	 * Search for all the field if we need to initialize the good class by if value
	 * @param Search\Models\Pieces $data
	 */
	public function prepare(&$data) {
		if (! $data->getUser() instanceof Search\Models\MainUser) $data->setUser($this->getEm()->find('Search\Models\MainUser',$data->getUser()));
		if (! $data->getAddress() instanceof Search\Models\Addresses) $data->setAddress($this->getEm()->find('Search\Models\Addresses',$data->getAddress()));
		if (! $data->getBrand() instanceof Search\Models\Brand) $data->setBrand($this->getEm()->find('Search\Models\Brand',$data->getBrand()));
		if (! $data->getApplianceType() instanceof Search\Models\ApplianceType) $data->setApplianceType($this->getEm()->find('Search\Models\ApplianceType',$data->getApplianceType()));
		if (! $data->getPieceType() instanceof Search\Models\PieceType) $data->setPieceType($this->getEm()->find('Search\Models\PieceType',$data->getPieceType()));
		if (! $data->getSendingMode() instanceof Search\Models\SendingMode) $data->setSendingMode($this->getEm()->find('Search\Models\SendingMode',$data->getSendingMode()));
		if (! $data->getStatus() instanceof Search\Models\Status) $data->setStatus($this->getEm()->find('Search\Models\Status',$data->getStatus()));
		if (! $data->getCreateDate() instanceof \Datetime) $data->setCreateDate(new Datetime('now'));
	}
	
	/**
	 * Save a record
	 * @param Search\Models\Pieces $data
	 */
	public function save(\Search\Models\Pieces $data) {
		$this->getEm()->persist($data);
		$this->getEm()->flush();
	}
	
	/**
	 * delete a piece
	 * @param integer $id
	 */
	public function delete($id) {
		$data=$this->findById($id);
		$this->getEm()->remove($data);
		$this->getEm()->flush();
	}
}

?>