<?php

namespace App\Repository;

use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mission[]    findAll()
 * @method Mission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

    // /**
    //  * @return Mission[] Returns an array of Mission objects
    //  */

    //search query to find the match content search input
    public function findBySearch(string $search)
    {
        return $this->getEntityManager()->createQuery(
            'SELECT m FROM  App\Entity\Mission m
             WHERE m.title LIKE LOWER(:search)
             OR m.title LIKE LOWER(:search_begin)
             OR m.title LIKE LOWER(:search_end)
             ORDER BY m.title ASC'
        )->setParameters([
                'search'=>'%'.$search.'%',
                'search_begin'=>'%'.$search,
                'search_end'=>$search.'%'
            ])
            ->setMaxResults(5)
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Mission
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
