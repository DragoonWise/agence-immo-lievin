<?php

namespace App\Form;

use App\Entity\Messages;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('iduser', EntityType::class, [
                'class' => Users::class,
                'label' => 'Emetteur :',
                'choice_label' => function ($user) {
                    return $user->getEmail() . " - " . $user->getLastName() . " " . $user->getFirstName();
                },
                'disabled' => true,
            ])
            ->add('objectmessage', null, [
                'label' => 'Objet :',
                'label_attr' => ['class' => 'text-left']
            ])
            ->add('content', null, ['label' => 'Contenu du Message :']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}
