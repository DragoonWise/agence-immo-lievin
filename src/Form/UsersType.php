<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',null,['label'=>'Email : '])
            ->add('lastname',null,['label'=>'Nom : '])
            ->add('firstname',null,['label'=>'Prénom : '])
            ->add('idaddress',AddressType::class)
            ->add('submit', SubmitType::class,['label'=>'Ajouter l\'utilisateur'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
