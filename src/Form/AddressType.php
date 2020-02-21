<?php

namespace App\Form;

use App\Entity\Addresses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address1', null, ['label' => 'Ligne d\'adresse 1 : '])
            ->add('address2', null, ['label' => 'Ligne d\'adresse 2 : '])
            ->add('address3', null, ['label' => 'Ligne d\'adresse 3 : '])
            ->add('address4', null, ['label' => 'Ligne d\'adresse 4 : '])
            ->add('postcode', null, ['label' => 'Code Postal : '])
            ->add('city', null, ['label' => 'Ville : '])
            ->add('state', null, ['label' => 'Etat / Région : ', 'disabled' => true])
            ->add('country', CountryType::class, [
                'label' => 'Pays : ',
                 'alpha3' => false,
                 'data' => 'FR'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Addresses::class,
        ]);
    }
}
