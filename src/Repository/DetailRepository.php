<?php

namespace App\Repository;

use App\Entity\Detail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Detail>
 */
class DetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Detail::class);
    }

//    /**
//     * @return Detail[] Returns an array of Detail objects
//     */
    public function findByExampleField($id): array
       {
           return $this->createQueryBuilder('d')
                ->select( 'd', 'c')
                ->leftJoin('d.categorie', 'c')
                ->where('c.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getResult()
           ;
        }


        public function findOneById($id): ?Detail
        {
            return $this->createQueryBuilder('d')
                ->andWhere('d.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }


       

//    public function findOneBySomeField($value): ?Detail
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
