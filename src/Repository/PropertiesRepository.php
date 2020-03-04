<?php

namespace App\Repository;

use App\Entity\Properties;
use App\Entity\PropertyExport;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;
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
    private $picturesRepository;
    private $favoritesRepository;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator, PicturesRepository $picturesRepository, FavoritesRepository $favoritesRepository)
    {
        parent::__construct($registry, Properties::class);
        $this->paginator = $paginator;
        $this->picturesRepository = $picturesRepository;
        $this->favoritesRepository = $favoritesRepository;
    }

    public function PaginatedAll(PropertySearch $propertySearch, ?int $iduser = null, int $page = 1, bool $withpictures = true, bool $withdeleted = false): PaginationInterface
    {
        $query = $this->createQueryBuilder('p');
        if (!is_null($propertySearch->getIstop())) {
            if ($propertySearch->getIstop()) {
                $query = $query->andWhere('p.istop = 1');
            } else {
                $query = $query->andWhere('p.istop = 0');
            }
        }
        if (!is_null($propertySearch->getIsrental()))
            switch ($propertySearch->getIsrental()) {
                case true:
                    $query = $query->andWhere('p.isrental = 1');
                    break;
                case false:
                    $query = $query->andWhere('p.isrental = 0');
                    break;
            }
        if (!is_null($propertySearch->getMinArea()))
            $query = $query
                ->andWhere('p.livingspace >= :minarea')
                ->setParameter('minarea', $propertySearch->getMinArea());
        if (!is_null($propertySearch->getMaxArea()))
            $query = $query
                ->andWhere('p.livingspace <= :maxarea')
                ->setParameter('maxarea', $propertySearch->getMaxArea());
        if (!is_null($propertySearch->getRooms()))
            $query = $query
                ->andWhere('p.rooms >= :rooms')
                ->setParameter('rooms', $propertySearch->getRooms());
        if (!is_null($propertySearch->getBedrooms()))
            $query = $query
                ->andWhere('p.bedrooms >= :bedrooms')
                ->setParameter('bedrooms', $propertySearch->getBedrooms());
        if (!is_null($propertySearch->getMinprice()))
            $query = $query
                ->andWhere('p.price >= :minprice')
                ->setParameter('minprice', $propertySearch->getMinprice());
        if (!is_null($propertySearch->getMaxprice()))
            $query = $query
                ->andWhere('p.price <= :maxprice')
                ->setParameter('maxprice', $propertySearch->getMaxprice());
        if ($propertySearch->getPropertyType()) {
            $query = $query
                ->andWhere('p.idpropertytype in (' . implode(',', $propertySearch->getPropertyType()) . ')');
        }
        if (!$withdeleted)
            $query = $query->andWhere('p.deleted = 0');
        $query = $query->Join('App\\Entity\\Users', 'u');
        $query = $query->andwhere('p.iduser = u.id and u.deleted = 0');
        $pagination = $this->paginator->paginate(
            $query,
            $page
        );
        // Populate Pictures
        if ($withpictures && count($pagination->getItems()) > 0) {
            $propertiesid = array_map(function ($property) {
                return $property->getId();
            }, $pagination->getItems());
            $pictures = $this->picturesRepository->findFirstImageByPropertyIds($propertiesid);
            $picturespropertyid = [];

            foreach ($pictures as $picture) {
                $picturespropertyid[$picture->getidproperty()->getid()] = $picture;
            }

            foreach ($pagination->getItems() as &$property) {
                if (array_key_exists($property->getid(), $picturespropertyid)) {
                    $property->setimage1($picturespropertyid[$property->getid()]);
                }
            }
            // Populate Favorite
            if (!is_null($iduser)) {
                $favorites = $this->favoritesRepository->findAllByUserId($iduser, $propertiesid);
                foreach ($favorites as $favorite) {
                    foreach ($pagination->getItems() as &$property) {
                        if ($favorite->getidproperty()->getid() == $property->getid()) {
                            $property->setisfavorite(true);
                        }
                    }
                }
            }
        }
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

    // public function Export(PropertyExport $propertyExport)
    // {
    //     return $this->createQueryBuilder('p')

    //         ->andWhere('p.Created_at >= :minDate')
    //         ->setParameter('minDate', $propertyExport->getMinDate())
    //         ->andWhere('p.Created_at <= :maxDate')
    //         ->setParameter('maxDate', $propertyExport->getMaxDate())
    //         ->getQuery()

    //         ->getResult();
    // }

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
