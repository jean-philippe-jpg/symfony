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
                #->addSelect('s')
                #->setParameter('val', $value)
               # ->orderBy('c.id', 'ASC')
                ->leftJoin('d.categorie', 'c')
                ->where('c.id = :id')
                ->setParameter('id', $id)
                #->addSelect('s')
                #->setMaxResults(10)
                ->getQuery()
                ->getResult()
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
