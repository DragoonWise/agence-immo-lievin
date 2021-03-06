<?php

namespace App\Controller;

use App\Entity\PropertySearch;
use App\Entity\Users;
use App\Form\PropertySearchType;
use App\Form\UsersType;
use App\Repository\FavoritesRepository;
use App\Repository\PicturesRepository;
use App\Repository\PropertiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/{page<\d+>}", name="home")
     */
    public function index(PropertiesRepository $propertiesRepository, int $page = 1)
    {
        $search = new PropertySearch();
        $search
            ->setIstop(true)
            ->setIsvisible(true)
            ->setIsdeleted(false);
        $iduser = null;
        if (!is_null($this->getUser()))
            $iduser = $this->getUser()->getid();
        $properties = $propertiesRepository->PaginatedAll($search, $iduser, $page);
        // Populate Picture
        $pictures = array_map(function ($property) {
            return $property->getImage1();
        }, $properties->getItems());
        return $this->render('home/index.html.twig', [
            'title' => 'Agence Immo Liévin',
            'controller_name' => 'HomeController',
            'properties' => $properties,
            'picturescarousel' => $pictures,
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request)
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original '$data' variable has also been updated
            $data = $form->getData();
            // ... perform some action, such as saving the task to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();
        }
        return $this->render('home/register.html.twig', [
            'title' => 'Agence Immo Liévin',
            'controller_name' => 'HomeController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/property/view/{id}", name="propertyview")
     */
    public function propertyview(PropertiesRepository $propertiesRepository, PicturesRepository $picturesRepository, FavoritesRepository $favoritesRepository, int $id)
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
        if ($this->getUser()) {
            if ($favoritesRepository->findOneBy(['iduser' => $this->getUser()->getId(), 'idproperty' => $property->getId()]))
                $property->setisfavorite(true);
        }
        return $this->render('home/property.view.html.twig', [
            'title' => 'Agence Immo Liévin',
            'controller_name' => 'HomeController',
            'property' => $property,
        ]);
    }

    /**
     * @Route("/properties/{type}", name="properties")
     */
    public function properties(Request $request, PropertiesRepository $propertiesRepository, string $type = 'Location')
    {
        $search = new PropertySearch();
        $search
            ->setIsvisible(true)
            ->setIsdeleted(false)
            ->setIsrental($type == 'Location');

        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$data` variable has also been updated
            $data = $form->getData();
        }
        $iduser = null;
        if (!is_null($this->getUser()))
            $iduser = $this->getUser()->getid();
        $properties = $propertiesRepository->PaginatedAll($search, $iduser);
        return $this->render('home/properties.html.twig', [
            'title' => 'Agence Immo Liévin',
            'controller_name' => 'HomeController',
            'properties' => $properties,
            'form' => $form->createView(),
        ]);
    }
}
