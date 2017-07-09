<?php
/**
 * Created by PhpStorm.
 * User: BaTryXaaa
 * Date: 7/7/2017
 * Time: 17:43
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SubFamilyRepository extends EntityRepository
{
    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('sub_family')
            ->orderBy('sub_family.name', 'ASC');
    }
}