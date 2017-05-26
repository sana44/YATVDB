<?php

namespace SerieBundle\Entity;

use Doctrine\ORM\EntityRepository;



/**
 * SerieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SerieRepository extends EntityRepository
{
    /**
     * Find Series through the header Search bar
     */
    public function search($param)
    {
        $query = $this->createQueryBuilder('s')
               ->where('s.name LIKE :param')
               ->orWhere('s.resume LIKE :param')
               ->setParameter('param',"%$param%")
               ->getQuery();

        return $query->getResult();
    }
}
