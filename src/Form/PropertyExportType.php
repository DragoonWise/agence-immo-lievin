<?php

namespace App\Form;

use App\Entity\PropertyExport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyExportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minDate',null,['label'=> 'Du :'])
            ->add('maxDate',null,['label'=> 'Au :'])
            ->add('submitExport',SubmitType::class,['label' => 'Exporter']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertyExport::class,
        ]);
    }
}
