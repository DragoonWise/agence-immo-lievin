<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Addresses;
use App\Entity\Favorites;
use App\Entity\Properties;
use App\Form\MailType;
use App\Form\PropertiesType;
use App\Form\UsersType;
use App\Repository\FavoritesRepository;
use App\Repository\PicturesRepository;
use App\Repository\PropertiesRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/user/favorites", name="userfavorites")
     */
    public function favorites(Request $request, FavoritesRepository $favoritesRepository, PicturesRepository $picturesRepository)
    {

        // $search = new PropertySearch();
        // $search
        //     ->setIstop(true)
        //     ->setIsvisible(true)
        //     ->setIsdeleted(false);
        // $properties = $propertiesRepository->PaginatedAll($search);
        $favorites = $favoritesRepository->findAllByUserId($this->getUser()->getid());
        foreach ($favorites as $favorite) {
            $favorite->getidproperty()->setisfavorite(true);
        }
        // Populate Picture
        $propertiesid = array_map(function ($favorite) {
            return $favorite->getidproperty()->getId();
        }, $favorites);
        $pictures = $picturesRepository->findFirstImageByPropertyIds($propertiesid);
        $picturespropertyid = [];
        foreach ($pictures as $picture) {
            $picturespropertyid[$picture->getidproperty()->getid()] = $picture;
        }
        foreach ($favorites as &$favorite) {
            if (array_key_exists($favorite->getidproperty()->getid(), $picturespropertyid)) {
                $favorite->getidproperty()->setimage1($picturespropertyid[$favorite->getidproperty()->getid()]);
            }
        }
        return $this->render('userspace/favorites.html.twig', [
            'controller_name' => 'UserSpaceController',
            'title' => 'Mes Favoris',
            'favorites' => $favorites,
        ]);
    }

    /**
     * @Route("/user/toggleFavorite/{idproperty}", name="userfavoritestoggle")
     */
    public function favoritestoggle(Request $request, FavoritesRepository $favoritesRepository, int $idproperty, PropertiesRepository $propertiesRepository)
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $favorite = $favoritesRepository->findOneBy(["idproperty" => $idproperty, "iduser" => $this->getUser()->getid()]);
            if (is_null($favorite)) {
                $favorite = new Favorites();
                $favorite->setIduser($this->getUser());
                $favorite->setIdproperty($propertiesRepository->findOneBy(['id' => $idproperty]));
                $entityManager->persist($favorite);
            } else {
                $entityManager->remove($favorite);
            }
            $entityManager->flush();
            return new Response("OK $idproperty");
        } catch (\Throwable $th) {
            return new Response("KO $idproperty");
        }
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
