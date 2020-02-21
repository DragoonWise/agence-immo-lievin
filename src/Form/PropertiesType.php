<?php

namespace App\Form;

use App\Entity\Properties;
use App\Entity\Propertytypes;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('description')
            ->add('isrental')
            ->add('price')
            ->add('energyclass')
            ->add('livingspace')
            ->add('rooms')
            ->add('bedrooms')
            ->add('isvisible')
            ->add('istop')
            ->add('ref')
            ->add('idaddress',AddressType::class)
            ->add('idpropertytype',EntityType::class,['class' => Propertytypes::class,'choice_label' => 'label'])
            ->add('iduser',EntityType::class,[
                'class' => Users::class,
            'choice_label' => function ($user) {
                return $user->getEmail(). " - ".$user->getLastName()." ".$user->getFirstName();
            }])
            ->add('submit', SubmitType::class,['label'=>'Ajouter le bien'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Properties::class,
        ]);
    }
}
