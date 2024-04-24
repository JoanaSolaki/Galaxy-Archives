<?php

namespace App\Repository;

use App\Entity\ReportPlanet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReportPlanet>
 *
 * @method ReportPlanet|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportPlanet|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportPlanet[]    findAll()
 * @method ReportPlanet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportPlanetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportPlanet::class);
    }

    //    /**
    //     * @return ReportPlanet[] Returns an array of ReportPlanet objects
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

    //    public function findOneBySomeField($value): ?ReportPlanet
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
