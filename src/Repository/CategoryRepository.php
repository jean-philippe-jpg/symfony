<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    //    /**
    //     * @return Category[] Returns an array of Category objects
    //     */
       //public function findByExampleField($value): 
        //array{
          /* return $this->createQueryBuilder('c')
                ->select('s', 'c')
                ->addSelect('s')
                ->setParameter('val', $value)
                ->orderBy('c.id', 'ASC')
                ->leftJoin('c.services', 's')
                ->addSelect('s')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
           ;
        }*/

        public function findOneBySomeField($id): ?Category
      {
           return $this->createQueryBuilder('c')
               ->andWhere('c.id = :id')
               ->setParameter('id', $id)
               ->leftJoin('c.service_id', 's')
                ->addSelect('s')
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }
}
