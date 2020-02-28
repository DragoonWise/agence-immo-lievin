<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Pictures;
use App\Entity\Addresses;
use App\Entity\Properties;
use App\Form\MailType;
use App\Form\PropertiesType;
use App\Form\UsersType;
use App\Repository\PicturesRepository;
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
    public function propose(Request $request, PicturesRepository $picturesRepository)
    {
        $properties = new Properties();
        $form = $this->createForm(PropertiesType::class, $properties, ['allow_extra_fields' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$data` variable has also been updated
            $data = $form->getData();
            $data->setiduser($this->getUser());
            $data->setref(substr($data->getidpropertytype()->getlabel(), 0, 2));
            $address = new Addresses();
            $address->setCity($form->get('city')->getData());
            $data->setidaddress($address);
            // ... perform some action, such as saving the task to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();
            // ... manage Pictures of property
            // Proposer un bien donc pas d'images existantes
            $picture1 = $picturesRepository->createPictureByFile($data->getImage1(), $data);
            $picture2 = $picturesRepository->createPictureByFile($data->getImage2(), $data);
            $picture3 = $picturesRepository->createPictureByFile($data->getImage3(), $data);
            $entityManager->persist($picture1);
            if (!is_null($picture2))
                $entityManager->persist($picture2);
            if (!is_null($picture3))
                $entityManager->persist($picture3);
            $entityManager->flush();

            // $images = $picturesRepository->findAllByPropertyId($data->getId());
            // $imagesbynames = [];
            // $imagesfinal= [];
            // array_walk($images, function ($val, $key) {
            //     $imagesbynames[$val->originalname] = $val;
            // });
            // if (array_key_exists($data->getimage1(), $imagesbynames)) {
            //     $imagesfinal[] = $imagesbynames[$data->getimage1()];
            // }
            // else
            // {

            // }


            return $this->redirectToRoute('home');
        }
        // var_dump($_FILES);

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
    public function sendmail(Request $request, PropertiesRepository $propertiesRepository, UsersRepository $usersRepository)
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
