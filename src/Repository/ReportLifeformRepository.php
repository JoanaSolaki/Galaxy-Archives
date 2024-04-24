<?php

namespace App\Repository;

use App\Entity\ReportLifeform;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReportLifeform>
 *
 * @method ReportLifeform|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportLifeform|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportLifeform[]    findAll()
 * @method ReportLifeform[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportLifeformRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportLifeform::class);
    }

    //    /**
    //     * @return ReportLifeform[] Returns an array of ReportLifeform objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ReportLifeform
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
