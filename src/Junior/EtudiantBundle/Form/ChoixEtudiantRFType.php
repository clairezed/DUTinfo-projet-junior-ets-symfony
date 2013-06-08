<?php

namespace Junior\EtudiantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Junior\EtudiantBundle\Entity\FraisRepository;

class ChoixEtudiantRFType extends AbstractType {

//    public function __construct($id) {
//        $this->id = $id;
//    }
    
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
//        $id = $this->id;
        $builder
                ->add('etudiants', 'entity', array(
                    'class' => 'JuniorEtudiantBundle:Frais',
                    'multiple' => false,
                    'property' => 'etudiant',
                    'query_builder' => function(FraisRepository $er){
                        return $er->findFraisNotInRF2();
                    }
                ))

                
        ;
    }

    public function getName() {
        return 'junior_etudiantbundle_choixetudiantrftype';
    }

}