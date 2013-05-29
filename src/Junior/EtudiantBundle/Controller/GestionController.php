<?php

namespace Junior\EtudiantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Junior\EtudiantBundle\Entity\Etudiant;
use Junior\EtudiantBundle\Entity\Etude;
use Junior\EtudiantBundle\Entity\Convention;
use Junior\EtudiantBundle\Form\ChoixEntrepriseType;
use Junior\EtudiantBundle\Form\EntrepriseType;
use Junior\EtudiantBundle\Form\EtudeType;
use Junior\EtudiantBundle\Form\ConventionType;
use Junior\EtudiantBundle\Entity\Participant;
//use Junior\EtudiantBundle\Form\EtudiantType;
use JMS\SecurityExtraBundle\Annotation\Secure;

class GestionController extends Controller {


    /**
     * Page d'accueil Gestion
     * -> Tableau de bord
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     * 
     */
    public function dashboardAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:dashboardGestion.html.twig');
    }
    
    /*     * ************************************************
     * Actions de manipulation des infos ETUDIANT
     * ************************************************* */
    
    public function listEtudiantsAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $list_etudiant = $em->getRepository('JuniorEtudiantBundle:Etudiant')->findAll();
        
        return $this->render('JuniorEtudiantBundle:Gestion:listEtudiants.html.twig', array (
            'list_etudiant' => $list_etudiant,
        ));
    }
    
    public function showEtudiantAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:showEtudiant.html.twig');
    }
    
    public function newEtudiantAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:showEtudiant.html.twig');
    }
    
    public function editEtudiantAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:editEtudiant.html.twig');
    }
    
    public function deleteEtudiantAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:deleteEtudiant.html.twig');
    }
    
    /*     * ************************************************
     * Actions de manipulation des infos ACOMPTE
     * ************************************************* */
    
    public function listAcomptesAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:listAcomptes.html.twig');
    }
    
    public function validAcompteAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:validAcompte.html.twig');
    }
    
    public function showAcompteAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:showAcompte.html.twig');
    }
    
    /*     * ************************************************
     * Actions de manipulation des infos FRAIS
     * ************************************************* */
    
    public function listFraisAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:listFrais.html.twig');
    }
    
    public function sortFraisAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:sortFrais.html.twig');
    }
    
    public function validFraisAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:validFrais.html.twig');
    }
    
    public function newRFAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:newRF.html.twig');
    }
    
    public function showRFAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:showRF.html.twig');
    }
    
    /*     * ************************************************
     * Actions de manipulation des infos ETUDE
     * ************************************************* */
    
    public function listEtudesAction() {
        
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $cpt = 0;
            $em = $this->getDoctrine()->getManager();
            $listEtudes = $em->getRepository('JuniorEtudiantBundle:Etude')->findAll();
            $listEntreprises = ARRAY(NULL);
            
            foreach($listEtudes as $etude) {
                $listEntreprises[$cpt] = $etude->getConvention()->getEntreprise();
                $cpt++;
            }
        }
        return $this->render('JuniorEtudiantBundle:Gestion:listEtudes.html.twig', array('etudes' => $listEtudes, 'entreprises' => $listEntreprises));
    }
    
    public function showEtudeAction($idEtude) {
        
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $cpt = 0;
            $em = $this->getDoctrine()->getManager();
            $etude = $em->getRepository('JuniorEtudiantBundle:Etude')->findOneById($idEtude);
            $entreprise = $etude->getConvention()->getEntreprise();
            $listParticipants = $etude->getParticipants();
//            $nbJours = $etude->getIndemnites()->getNbJours();
            
            foreach($listParticipants as $participant) {
                $statuts[$cpt] = $participant->getStatutEtudiant();
                $etudiants[$cpt] = $participant->getEtudiant();
                $cpt++;
            }
        }
        
        return $this->render('JuniorEtudiantBundle:Gestion:showEtude.html.twig', array('etude' => $etude, 'entreprise' => $entreprise, 'etudiants' => $etudiants, 'statuts' => $statuts));
    }
    
    public function newEtudeAction($idConvention) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $convention = $em->getRepository('JuniorEtudiantBundle:Convention')->findOneById($idConvention);
            $etude = new Etude();
            $etude->setConvention($convention);
            
            $form = $this->createForm(new EtudeType(), $etude);
            $request = $this->getRequest();
            
            if(($request->getMethod() == 'POST')) {
                $form->bind($request);
                if($form->isValid()) {
                    $em->persist($etude);
                    $em->flush();
                    $idEtude = $etude->getId();
                    return $this->redirect($this->generateUrl('junior_gestion_newGroupe', array('idEtude' => $idEtude)));
                }
            }
        }   
        return $this->render('JuniorEtudiantBundle:Gestion:newEtude.html.twig', array('form' => $form->createView()));
    }
    
    public function newGroupeAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:newGroupe.html.twig');
    }
    
    public function editEtudeAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:editEtude.html.twig');
    }
    
    public function closeEtudeAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:closeEtude.html.twig');
    }
    
    /*     * ************************************************
     * Actions de manipulation des infos ENTREPRISE
     * ************************************************* */
    
    public function choixEntrepriseAction() {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $form = $this->createForm(new ChoixEntrepriseType());
            $request = $this->getRequest();
            
            if(($request->getMethod() == 'POST')) {
                $postData = $request->request->get('junior_etudiantbundle_choixentreprisetype');
                $idEntreprise = $postData['entreprise'];
                //$entreprise = $em->getRepository('JuniorEtudiantBundle:Entreprise')->findOneById($idEntreprise);
                return $this->redirect($this->generateUrl('junior_gestion_newConvention', array('idEntreprise' => $idEntreprise)));
            }
        }
        return $this->render('JuniorEtudiantBundle:Gestion:choixEntreprise.html.twig', array('form' => $form->createView()));
    }
    
    public function newEntrepriseAction() {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $form = $this->createForm(new EntrepriseType());
        }
        return $this->render('JuniorEtudiantBundle:Gestion:newEntreprise.html.twig', array('form' => $form->createView()));
    }
    
    /*     * ************************************************
     * Actions de manipulation des infos ENTREPRISE
     * ************************************************* */
    
    public function newConventionAction($idEntreprise) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $entreprise = $em->getRepository('JuniorEtudiantBundle:Entreprise')->findOneById($idEntreprise);
            $convention = new Convention();
            $convention->setEntreprise($entreprise);
            
            $form = $this->createForm(new ConventionType(), $convention);
            $request = $this->getRequest();
            
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                if($form->isValid()) {
                    $em->persist($convention);
                    $em->flush();
                    $idConvention = $convention->getId();
                    return $this->redirect($this->generateUrl('junior_gestion_newEtude', array('idConvention' => $idConvention)));
                }
            }
        }
        return $this->render('JuniorEtudiantBundle:Gestion:newConvention.html.twig', array('form' => $form->createView()));
    }
//
//    /**************************************************
//     * Actions de manipulation des infos etudiant
//     * ************************************************* */
//
//    /**
//     * Voir les infos personnelles d'un etudiant
//     *
//     */
//    public function showEtudiantAction($id) {
//
//        $user = $this->getUser();
//
//        if (null === $user) {
//            return $this->render('JuniorEtudiantBundle::layout.html.twig');
//        } else {
//            $id = $user->getId();
//            $em = $this->getDoctrine()->getManager();
//            $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);
//
//            if (!$entity) {
//                throw $this->createNotFoundException('Unable to find Etudiant entity.');
//            }
//
//            return $this->render('JuniorEtudiantBundle:Etudiant:showEtudiant.html.twig', array(
//                        'entity' => $entity,
//            ));
//        }
//    }
//
//    /**
//     * Displays a form to edit an existing Etudiant entity.
//     *
//     */
//    public function editEtudiantAction($id) {
//        $em = $this->getDoctrine()->getManager();
//
//        $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);
//
//        if (!$entity) {
//            throw $this->createNotFoundException('Unable to find Etudiant entity.');
//        }
//
//        $editForm = $this->createForm(new EtudiantType(), $entity);
//
//        return $this->render('JuniorEtudiantBundle:Etudiant:editEtudiant.html.twig', array(
//                    'entity' => $entity,
//                    'edit_form' => $editForm->createView(),
//        ));
//    }
//
//    /**
//     * Edits an existing Etudiant entity.
//     *
//     */
//    public function updateEtudiantAction(Request $request, $id) {
//        $em = $this->getDoctrine()->getManager();
//
//        $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);
//
//        if (!$entity) {
//            throw $this->createNotFoundException('Unable to find Etudiant entity.');
//        }
//
//        $editForm = $this->createForm(new EtudiantType(), $entity);
//        $editForm->bind($request);
//
//        if ($editForm->isValid()) {
//            $em->persist($entity);
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('junior_etudiant_showEtudiant', array('id' => $id)));
//        }
//
//        return $this->render('JuniorEtudiantBundle:Etudiant:editEtudiant.html.twig', array(
//                    'entity' => $entity,
//                    'edit_form' => $editForm->createView(),
//        ));
//    }
//
//    /*     * ************************************************
//     * Actions de manipulation des FRAIS
//     * ************************************************* */
//
//    public function listFraisAction() {
//        $user = $this->getUser();
//
//        if (null === $user) {
//            return $this->render('JuniorEtudiantBundle::layout.html.twig');
//        } else {
//            $id = $user->getId();
//            $em = $this->getDoctrine()->getEntityManager();
//
//            $entities = $em->getRepository('JuniorEtudiantBundle:Frais')->findAll();
//
//            return $this->render('JuniorEtudiantBundle:Etudiant:listFrais.html.twig', array(
//                        'entities' => $entities
//            ));
//        }
//    }
//
//    public function newFraisAction() {
//        $user = $this->getUser();
//
//        if (null === $user) {
//            return $this->render('JuniorEtudiantBundle::layout.html.twig');
//        } else {
//            $id = $user->getId();
//
//            return $this->render('JuniorEtudiantBundle:Etudiant:newFrais.html.twig', array(
//                'id' => $id
//            ));
//        }
//    }
//
//    /*     * ************************************************
//     * Actions de manipulation des ETUDES
//     * ************************************************* */
//
//    public function listEtudesAction($id) {
//
//        $user = $this->getUser();
//
//        if (null === $user) {
//            return $this->render('JuniorEtudiantBundle::layout.html.twig');
//        } else {
//            $id = $user->getId();
//            $cpt = 0;
//            $listeEtudes = array(NULL); //Initialisation des variables : évite une erreur si l'étudiant ne participe à aucune étude
//            $listeStatuts = array(NULL);
//            $em = $this->getDoctrine()->getManager();
//
//            $etudiant = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);
//            $listeParticipations = $etudiant->getParticipants(); //On récupère la liste des entrées de la table participation correspondant à cet étudiant
//
//            foreach ($listeParticipations as $participation) { //Pour chaque entrée dans la liste, on récupère l'étude associée et le statut de l'étudiant pour celle-ci
//                $listeEtudes[$cpt] = $participation->getEtude();
//                $listeStatuts[$cpt] = $participation->getStatutEtudiant();
//                $cpt++;
//            }
//
//            return $this->render('JuniorEtudiantBundle:Etudiant:listEtudes.html.twig', array(
//                        'etudes' => $listeEtudes, 'statuts' => $listeStatuts, 'etudiant' => $etudiant
//            ));
//        }
//    }
//
//    public function showEtudeAction($idEtude, $idEtudiant) {
//
//        $user = $this->getUser();
//
//        if (null === $user) {
//            return $this->render('JuniorEtudiantBundle::layout.html.twig');
//        } else {
//            $id = $user->getId();
//
//            $em = $this->getDoctrine()->getManager();
//            $etude = $em->getRepository('JuniorEtudiantBundle:Etude')->find($idEtude);
//            $participant = $em->getRepository('JuniorEtudiantBundle:Participant')->findOneBy(array('etudiant' => $idEtudiant, 'etude' => $idEtude));
//            $statut = $participant->getStatutEtudiant();
//            $indemnites = $em->getRepository('JuniorEtudiantBundle:Indemnites')->findOneBy(array('etudiant' => $idEtudiant, 'etude' => $idEtude));
//            $nbJours = $indemnites->getNbJours();
//            $acomptes = $indemnites->getAcomptes();
//
//            return $this->render('JuniorEtudiantBundle:Etudiant:showEtude.html.twig', array(
//                        'etude' => $etude, 'statut' => $statut, 'nbJours' => $nbJours, 'acomptes' => $acomptes
//            ));
//        }
//    }
//
//    /*     * ************************************************
//     * Actions créés automatiquement par le CRUD etudiant
//     * (our info et exemples
//     * ************************************************* */
//
////    
////    public function showAction($id)
////    {
////        $em = $this->getDoctrine()->getManager();
////
////        $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);
////
////        if (!$entity) {
////            throw $this->createNotFoundException('Unable to find Etudiant entity.');
////        }
////
////        $deleteForm = $this->createDeleteForm($id);
////
////        return $this->render('JuniorEtudiantBundle:Etudiant:show.html.twig', array(
////            'entity'      => $entity,
////            'delete_form' => $deleteForm->createView(),        ));
////    }
////
////    /**
////     * Displays a form to edit an existing Etudiant entity.
////     *
////     */
////    public function editAction($id)
////    {
////        $em = $this->getDoctrine()->getManager();
////
////        $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);
////
////        if (!$entity) {
////            throw $this->createNotFoundException('Unable to find Etudiant entity.');
////        }
////
////        $editForm = $this->createForm(new EtudiantType(), $entity);
////        $deleteForm = $this->createDeleteForm($id);
////
////        return $this->render('JuniorEtudiantBundle:Etudiant:edit.html.twig', array(
////            'entity'      => $entity,
////            'edit_form'   => $editForm->createView(),
////            'delete_form' => $deleteForm->createView(),
////        ));
////    }
////
////    /**
////     * Edits an existing Etudiant entity.
////     *
////     */
////    public function updateAction(Request $request, $id)
////    {
////        $em = $this->getDoctrine()->getManager();
////
////        $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);
////
////        if (!$entity) {
////            throw $this->createNotFoundException('Unable to find Etudiant entity.');
////        }
////
////        $deleteForm = $this->createDeleteForm($id);
////        $editForm = $this->createForm(new EtudiantType(), $entity);
////        $editForm->bind($request);
////
////        if ($editForm->isValid()) {
////            $em->persist($entity);
////            $em->flush();
////
////            return $this->redirect($this->generateUrl('etudiant_edit', array('id' => $id)));
////        }
////
////        return $this->render('JuniorEtudiantBundle:Etudiant:edit.html.twig', array(
////            'entity'      => $entity,
////            'edit_form'   => $editForm->createView(),
////            'delete_form' => $deleteForm->createView(),
////        ));
////    }
////
////    /**
////     * Deletes a Etudiant entity.
////     *
////     */
////    public function deleteAction(Request $request, $id)
////    {
////        $form = $this->createDeleteForm($id);
////        $form->bind($request);
////
////        if ($form->isValid()) {
////            $em = $this->getDoctrine()->getManager();
////            $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);
////
////            if (!$entity) {
////                throw $this->createNotFoundException('Unable to find Etudiant entity.');
////            }
////
////            $em->remove($entity);
////            $em->flush();
////        }
////
////        return $this->redirect($this->generateUrl('etudiant'));
////    }
////
////    /**
////     * Creates a form to delete a Etudiant entity by id.
////     *
////     * @param mixed $id The entity id
////     *
////     * @return Symfony\Component\Form\Form The form
////     */
////    private function createDeleteForm($id)
////    {
////        return $this->createFormBuilder(array('id' => $id))
////            ->add('id', 'hidden')
////            ->getForm()
////        ;
////    }
}

