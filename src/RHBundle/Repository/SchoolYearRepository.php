<?php

namespace RHBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SchoolYearRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SchoolYearRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->createQueryBuilder('q')
            ->select('e')
            ->from('RHBundle:SchoolYear', 'e', 'e.id')
            ->getQuery()->getResult();
    }
}
