<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\PropertiesRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    private $_propertiesRepository;
    private $_usersRepository;

    public function __construct(PropertiesRepository $propertiesRepository, UsersRepository $usersRepository)
    {
        $this->_propertiesRepository = $propertiesRepository;
        $this->_usersRepository = $usersRepository;
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
            'properties' => $properties
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
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin/users/add", name="adminusersadd")
     */
    public function usersadd(Request $request)
    {
        $user = new Users();
        $form = $this->createFormBuilder($user);
        // $users = $this->_usersRepository->findAll();
        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form
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
            'users' => $users
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
            'users' => $users
        ]);
    }
}
