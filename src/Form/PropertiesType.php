<?php

namespace App\Form;

use App\Entity\Properties;
use App\Entity\Propertytypes;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('energyclass', ChoiceType::class, ['label' => 'Classe d\'énergie :', 'choices' => ['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G']])
            ->add('livingspace', null, ['label' => 'Superficie :'])
            ->add('rooms', null, ['label' => 'Nombre de pièces :'])
            ->add('bedrooms', null, ['label' => 'Nombre de chambres :'])
            ->add('isvisible',null,['label'=> 'Est Visible ?'])
            ->add('istop',null,['label'=> 'Est inclus dans les Top Offres ?'])
            ->add('ref',null,['label'=> 'Référence :'])
            ->add('idaddress', AddressType::class)
            ->add('idpropertytype', EntityType::class, ['label' => 'Type de Bien :', 'class' => Propertytypes::class, 'choice_label' => 'label'])
            ->add('iduser', EntityType::class, [
                'class' => Users::class,
                'label' => 'Propriétaire :',
                'choice_label' => function ($user) {
                    return $user->getEmail() . " - " . $user->getLastName() . " " . $user->getFirstName();
                }
            ])
            ->add('submit', SubmitType::class, ['label' => 'Ajouter le bien']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Properties::class,
        ]);
    }
}
