<?php

namespace App\Repository;

use App\Entity\Lifeform;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lifeform>
 *
 * @method Lifeform|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lifeform|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lifeform[]    findAll()
 * @method Lifeform[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LifeformRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lifeform::class);
    }

    //    /**
    //     * @return Lifeform[] Returns an array of Lifeform objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Lifeform
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
