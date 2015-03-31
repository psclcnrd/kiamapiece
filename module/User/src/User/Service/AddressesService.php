<?php

namespace User\Service;

use Search\Models\Addresses;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class AddressesService extends AbstractService {

	private function cryptIt(\Search\Models\Addresses &$data)
	{
		$data->setStreet();
	}
	/**
	 * load all the addresses in the database.
	 */
	public function findAll() {
		$qb=$this->getRep()->createQueryBuilder('p');
		$query=$qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * retrieve a address by is unique id
	 * @param integer $id
	 * @return Search\Models\Pieces
	 */
	public function findById($id) {
		$qb=$this->getRep()->createQueryBuilder('a');
		$qb->select('a')
			->where('a.id=?1');
		$qb->setParameter(1,$id);
		$query=$qb->getQuery();
		return $query->getSingleResult();
	}
	
	/**
	 * retrieve a address by is user
	 * @param integer $id
	 * @return Search\Models\Pieces
	 */
	public function findByUser($userId) {
		$qb=$this->getRep()->createQueryBuilder('a');
		$qb->select('a')
 		   ->where('a.User=?1')
		   ->orderBy(a.id);
		$qb->setParameter(1,$id);
		$query=$qb->getQuery();
		return $query->getResult();
	}
	
	/**
	 * Save a record
	 * @param Search\Models\Addresses $data
	 */
	public function save(\Search\Models\Addresses $data) {
		if (! $data->UserId instanceof Search\Models\MainUser) $data->UserId=$this->getEm()->find('Search\Models\MainUser',$data->UserId);
		$this->getEm()->persist($data);
		$this->getEm()->flush();
	}
	
	/**
	 * delete a adresse
	 * @param integer $id
	 */
	public function delete($id) {
		$data=$this->findById($id);
		$this->getEm()->remove($data);
		$this->getEm()->flush();
	}
}

?>