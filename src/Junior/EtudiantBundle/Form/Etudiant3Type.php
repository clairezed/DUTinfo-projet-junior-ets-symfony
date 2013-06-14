<?php

namespace Junior\EtudiantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Junior\EtudiantBundle\Entity\EtudeRepository;

//form for Etudiant -> editInfo
class Etudiant3Type extends AbstractType {

    public function __construct($id) {
        $this->id = $id;
    }
    
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $id = $this->id;
        $builder
//                ->add('numEtudiant', 'text')
//                ->add('nomEtudiant', 'text')
//                ->add('numSecu', 'number')
                ->add('adresseEtudiant', 'text')
                ->add('telEtudiant', 'text')
                ->add('email', 'email')
//                ->add('dateNaissance', 'date')
//                ->add('etudes', 'entity', array(
//                    'class' => 'JuniorEtudiantBundle:Etude',
////                    'multiple' => false,
////                    'property' => 'nomEtude',
//                    'query_builder' => function(EtudeRepository $er) use ($id){
//                        return $er->findEtudesbyStudentAndStatut($id, 'En cours');
//                    }
//                ))

                
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Junior\EtudiantBundle\Entity\Etudiant'
        ));
    }

    public function getName() {
        return 'junior_etudiantbundle_etudiant3type';
    }

}