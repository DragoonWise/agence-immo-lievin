<?php

namespace App\Controller;

use App\Entity\PropertySearch;
use App\Repository\FavoritesRepository;
use App\Repository\PicturesRepository;
use App\Repository\PropertiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PropertiesRepository $propertiesRepository, PicturesRepository $picturesRepository, FavoritesRepository $favoritesRepository)
    {
        $search = new PropertySearch();
        $search
            ->setIstop(true)
            ->setIsvisible(true)
            ->setIsdeleted(false);
        $properties = $propertiesRepository->PaginatedAll($search);
        // Populate Picture
        $propertiesid = array_map(function ($property) {
            return $property->getId();
        }, $properties->getItems());
        $pictures = $picturesRepository->findFirstImageByPropertyIds($propertiesid);
        $picturespropertyid = [];
        foreach ($pictures as $picture) {
            $picturespropertyid[$picture->getidproperty()->getid()] = $picture;
        }
        // var_dump($picturespropertyid);
        // foreach ($picturespropertyid as $key => $val) {
        foreach ($properties->getItems() as &$property) {
            if (array_key_exists($property->getid(), $picturespropertyid)) {
                $property->setimage1($picturespropertyid[$property->getid()]);
            }
        }
        // }
        if ($this->getUser() != null) {
            $favorites = $favoritesRepository->findAllByUserId($this->getUser()->getid(), $propertiesid);
            foreach ($favorites as $favorite) {
                foreach ($properties->getItems() as &$property) {
                    if ($favorite->getidproperty()->getid() == $property->getid()) {
                        $property->setisfavorite(true);
                    }
                }
            }
        }
        return $this->render('home/index.html.twig', [
            'title' => 'Agence Immo Liévin',
            'controller_name' => 'HomeController',
            'properties' => $properties,
            'picturescarousel' => $pictures,
        ]);
    }

    /**
     * @Route("/property/view/{id}", name="propertyview")
     */
    public function propertyview(PropertiesRepository $propertiesRepository, PicturesRepository $picturesRepository, int $id)
    {
        $property = $propertiesRepository->findOneBy(['id' => $id]);
        $pictures = $picturesRepository->findAllByPropertyId($property->getid());
        foreach ($pictures as $key => $val) {
            switch ($key) {
                case 0:
                    $property->setimage1($val);
                    break;
                case 1:
                    $property->setimage2($val);
                    break;
                case 2:
                    $property->setimage3($val);
                    break;
            }
        }
        return $this->render('home/property.view.html.twig', [
            'title' => 'Agence Immo Liévin',
            'controller_name' => 'HomeController',
            'property' => $property,
        ]);
    }
}
