<?php

namespace GRCBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ContactRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContactRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->createQueryBuilder('q')
            ->select('e')
            ->from('GRCBundle:Contact', 'e', 'e.id')
            ->getQuery()->getResult();
    }
}
