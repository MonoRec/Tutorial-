<?php
/**
 * Created by PhpStorm.
 * User: BaTryXaaa
 * Date: 7/7/2017
 * Time: 17:43
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class GenusRepository extends EntityRepository
{

    /**
     * @return Genus[]
     */
    public function findAllPublishedOrderedBySize() {
        return $this->createQueryBuilder('genus')
            ->andWhere('genus.isPublished = :isPublished')
            ->setParameter('isPublished', true)
            ->addOrderBy('genus.speciesCount', 'DESC')
            ->getQuery()
            ->execute();
    }

}