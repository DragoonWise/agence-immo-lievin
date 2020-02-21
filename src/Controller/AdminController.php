<?php

namespace App\Controller;

use App\Entity\Properties;
use App\Entity\Users;
use App\Form\PropertiesType;
use App\Form\UsersType;
use App\Repository\CountriesRepository;
use App\Repository\PropertiesRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class AdminController extends AbstractController
{

    private $_propertiesRepository;
    private $_usersRepository;
    private $_countriesRepository;

    public function __construct(PropertiesRepository $propertiesRepository, UsersRepository $usersRepository, CountriesRepository $countriesRepository)
    {
        $this->_propertiesRepository = $propertiesRepository;
        $this->_usersRepository = $usersRepository;
        $this->_countriesRepository = $countriesRepository;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/properties", name="adminproperties")
     */
    public function properties()
    {
        $properties = $this->_propertiesRepository->findAll();
        return $this->render('admin/properties.html.twig', [
            'controller_name' => 'AdminController',
            'properties' => $properties,
        ]);
    }

    /**
     * @Route("/admin/properties/add", name="adminpropertiesadd")
     */
    public function propertiesadd(Request $request)
    {
        $properties = new Properties();
        $form = $this->createForm(PropertiesType::class, $properties);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$data` variable has also been updated
            $data = $form->getData();

            // ... perform some action, such as saving the task to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            return $this->redirectToRoute('adminusers');
        }

        return $this->render('admin/properties.add.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/users", name="adminusers")
     */
    public function users()
    {
        $users = $this->_usersRepository->findAll();
        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/users/add", name="adminusersadd")
     */
    public function usersadd(Request $request)
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$data` variable has also been updated
            $data = $form->getData();

            // ... perform some action, such as saving the task to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            return $this->redirectToRoute('adminusers');
        }

        return $this->render('admin/users.add.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/importexport", name="adminimportexport")
     */
    public function importexport()
    {
        $users = $this->_usersRepository->findAll();
        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/mails", name="adminmails")
     */
    public function mails()
    {
        $users = $this->_usersRepository->findAll();
        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
        ]);
    }
}
