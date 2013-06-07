<?php

namespace Junior\EtudiantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewRemboursementFraisType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('dateRemboursement', 'date')
                ->add('frais', 'collection', array(
                    'type' => new FraisType())
                        )
//                ->add('frais', 'entity', array(
//                    'class' => 'JuniorEtudiantBundle:Frais',
////                    'multiple' => false,
////                    'property' => 'nomEtude',
//                    'query_builder' => function(FraisRepository $er) use ($idEtudiant){
//                        return $er->createRF($idEtudiant, 'En cours');
//                    }
//                ));
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Junior\EtudiantBundle\Entity\RemboursementFrais'
        ));
    }

    public function getName() {
        return 'junior_etudiantbundle_newremboursementfraistype';
    }

}
