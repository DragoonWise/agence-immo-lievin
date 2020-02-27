<?php

namespace App\Form;

use App\Entity\Properties;
use App\Entity\Propertytypes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', null, ['label' => 'Nom du Bien :'])
            ->add('description')
            ->add('isrental', ChoiceType::class, [
                'choices' => [
                    'Location' => 1,
                    'Vente' => 0
                ],
                'label' => 'Location ou Vente ?'
            ])
            ->add('price', null, ['label' => 'Prix :'])
            ->add('livingspace', null, ['label' => 'Superficie :'])
            ->add('rooms', null, ['label' => 'Nombre de pièces :'])
            ->add('bedrooms', null, ['label' => 'Nombre de chambres :'])
            ->add('city', TextType::class, ['mapped'=>false,'label' => 'Ville :'])
            ->add('idpropertytype', EntityType::class, ['label' => 'Type de Bien :', 'class' => Propertytypes::class, 'choice_label' => 'label'])
            ->add('image1',FileType::class,['label_attr'=>['class'=>'d-none'],'required'=>true])
            ->add('image2',FileType::class,['label_attr'=>['class'=>'d-none'],'required'=>false])
            ->add('image3',FileType::class,['label_attr'=>['class'=>'d-none'],'required'=>false])
            ->add('submit', SubmitType::class, ['label' => 'Ajouter le bien']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Properties::class,
        ]);
    }
}
