<?php

namespace App\Controller;

use App\Entity\Properties;
use App\Entity\Users;
use App\Form\MailType;
use App\Form\PropertiesType;
use App\Form\UsersType;
use App\Repository\CountriesRepository;
use App\Repository\MessagesRepository;
use App\Repository\PropertiesRepository;
use App\Repository\UsersRepository;
use DateTime;
use Presta\ImageBundle\Form\Type\ImageType;
use stdClass;
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
     * @Route("/admin/properties/{page}", name="adminproperties")
     */
    public function properties(int $page = 1)
    {
        $properties = $this->_propertiesRepository->PaginatedAll($page);
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
        // $form2 = $this->createForm(ImageType::class);
        $form->handleRequest($request);
        //        $form2->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$data` variable has also been updated
            $data = $form->getData();
            // ... perform some action, such as saving the task to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            return $this->redirectToRoute('adminproperties');
        }

        return $this->render('admin/properties.add.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form->createView(),
            // 'form2' => $form2->createView(),
        ]);
    }

    /**
     * @Route("/admin/properties/edit/{id}", name="adminpropertiesedit")
     */
    public function propertiesedit(Request $request, int $id)
    {
        $properties = $this->_propertiesRepository->findOneBy(['id' => $id]);
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

            return $this->redirectToRoute('adminproperties');
        }

        return $this->render('admin/properties.edit.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/properties/reactivate/{id<\d+>}", name="adminpropertiesreactivate")
     */
    public function propertiesreactivate(Request $request, int $id)
    {
        $this->_propertiesRepository->reactivate($id);
        return $this->redirectToRoute('adminproperties');
    }

    /**
     * @Route("/admin/properties/delete/{id<\d+>}", name="adminpropertiesdelete")
     */
    public function propertiesdelete(Request $request, int $id)
    {
        $this->_propertiesRepository->delete($id);
        return $this->redirectToRoute('adminproperties');
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
     * @Route("/admin/users/edit/{id<\d+>}", name="adminusersedit")
     */
    public function usersedit(Request $request, int $id)
    {
        $user = $this->_usersRepository->findOneBy(['id' => $id ?? 1]);
        $form = $this->createForm(UsersType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$data` variable has also been updated
            $data = $form->getData();
            if (!is_null($data->getPassword()) && $data->getPassword() != '')
                $data->setPassword(password_hash($data->getPassword(), PASSWORD_BCRYPT));
            // var_dump($data);
            // exit;
            // ... perform some action, such as saving the task to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            return $this->redirectToRoute('adminusers');
        }

        return $this->render('admin/users.edit.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/users/reactivate/{id<\d+>}", name="adminusersreactivate")
     */
    public function usersreactivate(Request $request, int $id)
    {
        $this->_usersRepository->reactivate($id);
        return $this->redirectToRoute('adminusers');
    }

    /**
     * @Route("/admin/users/delete/{id<\d+>}", name="adminusersdelete")
     */
    public function usersdelete(Request $request, int $id)
    {
        $this->_usersRepository->delete($id);
        return $this->redirectToRoute('adminusers');
    }

    /**
     * @Route("/admin/importexport", name="adminimportexport")
     */
    public function importexport()
    {
        return $this->render('admin/importexport.html.twig', [
            'controller_name' => 'AdminController',
            'analyse' => null
        ]);
    }

    public function importanalyse($filename)
    {
        return $this->render('admin/_importanalyse.html.twig', [
            'analyse' => null
        ]);
    }

    /**
     * @Route("/admin/mails", name="adminmails")
     */
    public function mails(MessagesRepository $messagesRepository)
    {
        $mails = $messagesRepository->findAll();
        return $this->render('admin/mails.html.twig', [
            'controller_name' => 'AdminController',
            'mails' => $mails,
        ]);
    }

    /**
     * @Route("/admin/mails/view/{id}", name="adminmailsview")
     */
    public function mailsview(Request $request, int $id, MessagesRepository $messagesRepository)
    {
        $mail = $messagesRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);
        $mail->setIsread(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($mail);
        $entityManager->flush();

        return $this->render('admin/mails.view.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form->createView(),
        ]);
    }
}