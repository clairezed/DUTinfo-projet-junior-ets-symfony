<?php

namespace Junior\EtudiantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EtudeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomEtude', 'entity', array(
                'class' => 'JuniorEtudiantBundle:Etude',
                'property' => 'nomEtude'
            ))
//            ->add('prixJournee')
//            ->add('statutEtude')
//            ->add('facture')
//            ->add('convention')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Junior\EtudiantBundle\Entity\Etude'
        ));
    }

    public function getName()
    {
        return 'junior_etudiantbundle_etudetype';
    }
}
