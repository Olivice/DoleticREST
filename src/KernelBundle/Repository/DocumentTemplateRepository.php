<?php

namespace KernelBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * DocumentTemplateRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DocumentTemplateRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->createQueryBuilder('q')
            ->select('e')
            ->from('KernelBundle:DocumentTemplate', 'e', 'e.id')
            ->getQuery()->getResult();
    }
}
