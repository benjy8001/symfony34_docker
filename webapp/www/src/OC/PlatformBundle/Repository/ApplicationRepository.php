<?php

namespace OC\PlatformBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ApplicationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ApplicationRepository extends EntityRepository
{
	/**
	 * @param string   $ip
	 * @param integer  $seconds
	 * @return bool    True si au moins une candidature créée il y a moins de $seconds secondes a été trouvée. False sinon.
	 */
	public function isFlood($ip, $seconds)
	{
		return (bool) $this->createQueryBuilder('a')
			->select('COUNT(a)')
			->where('a.date >= :date')
			->setParameter('date', new \Datetime($seconds.' seconds ago'))
			//->andWhere('a.ip = :ip')->setParameter('ip', $ip)
			->getQuery()
			->getSingleScalarResult()
		;
	}

	public function getApplicationsWithAdvert($limit)
	{
		$qb = $this
			->createQueryBuilder('app')
			->leftJoin('app.advert', 'a')
			->addSelect('a')
			->setMaxResults($limit)
		;

		return $qb
			->getQuery()
			->getResult()
		;
	}
}
