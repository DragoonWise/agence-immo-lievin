<?php

namespace App\Repository;

use App\Entity\Favorites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Favorites|null find($id, $lockMode = null, $lockVersion = null)
 * @method Favorites|null findOneBy(array $criteria, array $orderBy = null)
 * @method Favorites[]    findAll()
 * @method Favorites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoritesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favorites::class);
    }

    /**
     * @return Properties[] Returns an array of Properties objects
     *
     * @param integer $idproperty
     * @return Properties[]
     */
    public function findAllByUserId(int $iduser, $listidproperty = [])
    {
        $query = $this->createQueryBuilder('f')
            ->andWhere('f.iduser = :id')
            ->setParameter('id', $iduser);
        if (count($listidproperty) > 0) {
            $query = $query
            ->andWhere('f.idproperty in ('.implode(',',$listidproperty).')');
        }
        return $query
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Favorites[] Returns an array of Favorites objects
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
    public function findOneBySomeField($value): ?Favorites
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
