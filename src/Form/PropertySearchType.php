<?php

namespace App\Form;

use App\Entity\PropertySearch;
use App\Repository\PropertyTypesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    private $propertytypes;
    public function __construct(PropertyTypesRepository $propertyTypesRepository)
    {
        $propertytypesbase = $propertyTypesRepository->findAll();
        $propertytypes = [];
        foreach ($propertytypesbase as $val) {
            $propertytypes[$val->getLabel()] = $val->getId();
        }
        $this->propertytypes = $propertytypes;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isrental', ChoiceType::class, [
                'choices' => [
                    'Location' => 1,
                    'Vente' => 0
                ],
                'label' => 'Type de recherche :'
            ])
            ->add('minarea', null, [
                'required' => false,
                'label'=>'Surface Min :'
            ])
            ->add('maxarea', null, [
                'required' => false,
                'label'=>'Surface Max :'
            ])
            ->add('rooms', null, [
                'required' => false,
                'label'=>'Pièces :'
            ])
            ->add('bedrooms', null, [
                'required' => false,
                'label'=>'Chambres :'
            ])
            ->add('minprice', null, [
                'required' => false,
                'label'=>'Budget Min :'
            ])
            ->add('maxprice', null, [
                'required' => false,
                'label'=>'Budget Max :'
            ])
            ->add('propertytype', ChoiceType::class, [
                'required' => false,
                'multiple' => true,
                'choices' => $this->propertytypes,
                'label' => 'Type de Bien : ',
            ])
            ->add('submit', SubmitType::class, ['label' => 'Filtrer']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
        ]);
    }
}
