<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Properties;
use App\Form\MailType;
use App\Form\PropertiesType;
use App\Form\UsersType;
use App\Repository\PropertiesRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserSpaceController extends AbstractController
{
    /**
     * @Route("/user/propose", name="userpropose")
     */
    public function propose(Request $request)
    {
        $properties = new Properties();
        $form = $this->createForm(PropertiesType::class, $properties);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$data` variable has also been updated
            $data = $form->getData();
            $data->setiduser($this->getUser());
            $data->setref(substr($data->getidpropertytype()->getlabel(), 0, 2));
            // ... perform some action, such as saving the task to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('userspace/propose.html.twig', [
            'controller_name' => 'UserSpaceController',
            'title' => 'Proposer un bien',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/profil", name="userprofil")
     */
    public function usersedit(Request $request)
    {
        $user = $this->getUser();
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

            return $this->redirectToRoute('userprofil');
        }

        return $this->render('userspace/profil.html.twig', [
            'controller_name' => 'UserSpaceController',
            'form' => $form->createView(),
            'title' => 'Informations Personnelles',
        ]);
    }

    /**
     * @Route("/user/mail", name="sendmail")
     */
    public function sendmail(Request $request,PropertiesRepository $propertiesRepository,UsersRepository $usersRepository)
    {
        $mail = new Messages;
        // $user = $usersRepository->findOneBy(['id'=>$this->getUser()]);
        $mail->setIduser($this->getUser());
        if (isset($_POST['idproperty'])) {
            $property = $propertiesRepository->findOneBy(['id' => $_POST['idproperty']]);
            $mail
                ->setObjectmessage("Ref : {$property->getref()} , Demande de renseignement.")
                ->setContent("");
        }
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$data` variable has also been updated
            $data = $form->getData();
            // var_dump($data);
            // exit;
            // ... perform some action, such as saving the task to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }
        // var_dump($form->createView());
        return $this->render('userspace/sendmail.html.twig', [
            'title' => 'Agence Immo Liévin',
            'controller_name' => 'HomeController',
            'form' => $form->createView(),
        ]);
    }
}
