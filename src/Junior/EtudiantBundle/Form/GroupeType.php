<?php

namespace Junior\EtudiantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GroupeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('participants', 'entity', array('class' => 'JuniorEtudiantBundle:Etudiant', 'property' => 'nomEtudiant', 'multiple' => true))
        ;
    }

    public function getName()
    {
        return 'junior_etudiantbundle_groupetype';
    }
}
