<?php

namespace App\Repository;

use App\Entity\FileContents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FileContents|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileContents|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileContents[]    findAll()
 * @method FileContents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileContentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileContents::class);
    }

    // /**
    //  * @return FileContents[] Returns an array of FileContents objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FileContents
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
