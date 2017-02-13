<?php

namespace UABundle\Repository;

/**
 * ProjectFileRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectFileRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->createQueryBuilder('q')
            ->select('e')
            ->from('UABundle:ProjectFile', 'e', 'e.id')
            ->getQuery()->getResult();
    }
}
