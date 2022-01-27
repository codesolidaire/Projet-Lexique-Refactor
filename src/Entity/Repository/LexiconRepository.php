<?php

namespace App\Repository;

use App\Entity\Lexicon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lexicon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lexicon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lexicon[]    findAll()
 * @method Lexicon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LexiconRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lexicon::class);
    }

    // /**
    //  * @return Lexicon[] Returns an array of Lexicon objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Lexicon
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
