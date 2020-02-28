<?php

namespace App\Repository;

use App\Entity\Pictures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;

/**
 * @method Pictures|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pictures|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pictures[]    findAll()
 * @method Pictures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PicturesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pictures::class);
    }

    /**
     * @return Pictures[] Returns an array of Pictures objects
     *
     * @param integer $idproperty
     * @return Pictures[]
     */
    public function findAllByPropertyId(int $idproperty)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.idproperty = :id')
            ->setParameter('id', $idproperty)
            ->getQuery()
            ->getResult();
    }

    public function findFirstImageByPropertyIds($propertyids)
    {
        $query = $this->createQueryBuilder('p')
            ->groupBy('p.idproperty')
            ->having('p.idproperty in (' . implode(',', $propertyids) . ')')
            ->getQuery();
        return $query
            ->getResult();
    }

    private function fileext($filename)
    {
        $types = [
            'image/png' => 'png',
            'image/jpeg' => 'jpe',
            'image/jpeg' => 'jpeg',
            'image/jpeg' => 'jpg',
            'image/gif' => 'gif',
            'image/bmp' => 'bmp',
            'image/vnd.microsoft.icon' => 'ico',
            'image/tiff' => 'tif',
            'image/svg+xml' => 'svg'
        ];
        return "." . $types[mime_content_type($filename)];
    }

    public function createPictureByFile($file, $idproperty)
    {
        try {
            if (!is_null($file)) {
                $picture = new Pictures();
                $filename = $idproperty->getId() . '_' . \Ramsey\Uuid\Uuid::uuid4()->toString() . $this->fileext($file->getpathName());
                if (move_uploaded_file($file->getpathName(), "build/images/$filename")) {
                    // download image puis stock le nouveau nom dans $filename
                    $picture = new Pictures();
                    $picture->setImageName($filename);
                    $picture->setidproperty($idproperty);
                    return $picture;
                }
            }
        } catch (\Throwable $th) {
            return null;
        }
        return null;
    }

    // /**
    //  * @return Pictures[] Returns an array of Pictures objects
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
    public function findOneBySomeField($value): ?Pictures
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
