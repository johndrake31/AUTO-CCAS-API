<?php

namespace App\Repository;

use App\Entity\CarAd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CarAd|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarAd|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarAd[]    findAll()
 * @method CarAd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarAdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarAd::class);
    }


    // public function findAllByColumnName(string $columnName): array
    // {
    //     $conn = $this->getEntityManager()->getConnection();

    //     $sql = '
    //         SELECT :columnName FROM car_ad p
    //         ';
    //     $stmt = $conn->prepare($sql);
    //     $stmt->execute(['columnName' => $columnName]);

    //     // returns an array of arrays (i.e. a raw data set)
    //     return $stmt->fetchAllAssociative();
    // }

    // /**
    //  * @return CarAd[] Returns an array of CarAd brands
    //  */
    // public function findByColumn(string $columnName)
    // {
    //     return $this->createQueryBuilder('c')
    //         ->select('c.columnName = :columnName')
    //         ->from('App\Entity\CarAd', 'p')
    //         ->setParameter('val', $columnName)
    //         ->setMaxResults(1000)
    //         ->getQuery()
    //         ->getResult();
    // }


    /*
    public function findOneBySomeField($value): ?CarAd
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
