<?php

namespace App\Repository;

use App\Entity\Properties;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Properties|null find($id, $lockMode = null, $lockVersion = null)
 * @method Properties|null findOneBy(array $criteria, array $orderBy = null)
 * @method Properties[]    findAll()
 * @method Properties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertiesRepository extends ServiceEntityRepository
{
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Properties::class);
        $this->paginator = $paginator;
    }

    public function PaginatedAll(PropertySearch $propertySearch, int $page = 1): PaginationInterface
    {
        $query = $this->createQueryBuilder('p');
        if (!is_null($propertySearch->getIstop())) {
            if ($propertySearch->getIstop()) {
                $query = $query->andWhere('p.istop = 1');
            } else {
                $query = $query->andWhere('p.istop = 0');
            }
        }
        $pagination = $this->paginator->paginate(
            $query,
            $page
        );
        return $pagination;
    }

    public function reactivate(int $id)
    {
        $property = $this->findOneBy(['id' => $id]);
        $property->setDeleted(0);
        $property->setDeletedAt(null);
        $this->_em->persist($property);
        $this->_em->flush();
    }

    public function delete(int $id)
    {
        $property = $this->findOneBy(['id' => $id]);
        $property->setDeleted(1);
        $property->setDeletedAt(date_create());
        $this->_em->persist($property);
        $this->_em->flush();
    }

    // /**
    //  * @return Properties[] Returns an array of Properties objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Properties
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
