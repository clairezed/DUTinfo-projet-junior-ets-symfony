<?php

namespace Junior\EtudiantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChoixEntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entreprise', 'entity', array(
                        'class' => 'JuniorEtudiantBundle:Entreprise', 
                        'property' => 'nomEntreprise', 
                        'multiple' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Junior\EtudiantBundle\Entity\Entreprise'
        ));
    }

    public function getName()
    {
        return 'junior_etudiantbundle_choixentreprisetype';
    }
}
