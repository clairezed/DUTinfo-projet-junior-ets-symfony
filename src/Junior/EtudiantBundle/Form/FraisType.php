<?php

namespace Junior\EtudiantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FraisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeFrais', 'text')
            ->add('montantFrais', 'integer')
            ->add('dateAchat', 'date')
            ->add('etude')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Junior\EtudiantBundle\Entity\Frais'
        ));
    }

    public function getName()
    {
        return 'junior_etudiantbundle_fraistype';
    }
}
