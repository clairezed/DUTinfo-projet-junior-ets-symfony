<?php

namespace Junior\EtudiantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Junior\EtudiantBundle\Entity\EtudeRepository;

class NewFraisType extends FraisType
{
        public function __construct($idEtudiant) {
        $this->etudiant = $idEtudiant;
    }
    
    
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
       $idEtudiant = $this->etudiant;    
        
        $builder
                ->add('etude', 'entity', array(
                    'class' => 'JuniorEtudiantBundle:Etude',
                    'multiple' => false,
//                    'property' => 'nomEtude',
                    'query_builder' => function(EtudeRepository $er) use ($idEtudiant){
                        return $er->findEtudesbyStudentAndStatut($idEtudiant, 'En cours');
                    }
                ));
       
    }

//    public function setDefaultOptions(OptionsResolverInterface $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => 'Junior\EtudiantBundle\Entity\Frais'
//        ));
//    }

    public function getName()
    {
        return 'junior_etudiantbundle_newfraistype';
    }
}
