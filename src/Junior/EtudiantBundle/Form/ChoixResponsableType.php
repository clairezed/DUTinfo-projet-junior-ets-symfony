<?php

namespace Junior\EtudiantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Junior\EtudiantBundle\Entity\EtudiantRepository;

class ChoixResponsableType extends AbstractType {

    public function __construct($id) {
        $this->id = $id;
    }
    
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $id = $this->id;
        $builder
                ->add('participants', 'entity', array(
                    'class' => 'JuniorEtudiantBundle:Etudiant',
//                    'multiple' => false,
                    'property' => 'nomEtudiant',
                    'query_builder' => function(EtudiantRepository $er) use ($id){
                        return $er->findEtudiantsbyEtude($id);
                    }
                ))

                
        ;
    }

    public function getName() {
        return 'junior_etudiantbundle_choixresponsabletype';
    }

}