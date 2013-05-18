<?php

namespace Junior\EtudiantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numEtudiant', 'text')
            ->add('nomEtudiant', 'text')
            ->add('adresseEtudiant', 'text')
            ->add('numSecu')
            ->add('dateNaissance')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Junior\EtudiantBundle\Entity\Etudiant'
        ));
    }

    public function getName()
    {
        return 'junior_etudiantbundle_etudianttype';
    }
}
