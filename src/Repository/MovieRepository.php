<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Entity\Rating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    // /**
    //  * @return Movie[] Returns an array of Movie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function findTop($date)
    {
	    //$this->createQueryBuilder('m');
	    $query = $this->getEntityManager()->createQuery('
		SELECT m,r
		FROM App\Entity\Movie m
		LEFT JOIN m.rating r
		WHERE r.date = :date');

	    return $query->getResult();
	    /*
        return $this->createQueryBuilder('m')
	        ->select( 'r')
	        ->from(Rating::class, 'r')
	        ->leftJoin('r.r', 'm')
            ->andWhere('r.date = :val')
            ->setParameter('val', $date)
            ->orderBy('r.estimatedScore', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
	    */
    }


    /*
    public function findOneBySomeField($value): ?Movie
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
