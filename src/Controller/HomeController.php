<?php

namespace App\Controller;

use App\Entity\PropertySearch;
use App\Repository\PropertiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PropertiesRepository $propertiesRepository)
    {
        $search = new PropertySearch();
        $search
            ->setIstop(true)
            ->setIsvisible(true)
            ->setIsdeleted(false);
        $properties = $propertiesRepository->PaginatedAll($search);

        return $this->render('home/index.html.twig', [
            'title' => 'Agence Immo Liévin',
            'controller_name' => 'HomeController',
            'properties' => $properties,
        ]);
    }

    /**
     * @Route("/property/view/{id}", name="propertyview")
     */
    public function propertyview(PropertiesRepository $propertiesRepository, int $id)
    {
        $property = $propertiesRepository->findOneBy(['id' => $id]);

        return $this->render('home/property.view.html.twig', [
            'title' => 'Agence Immo Liévin',
            'controller_name' => 'HomeController',
            'property' => $property,
        ]);
    }
}
