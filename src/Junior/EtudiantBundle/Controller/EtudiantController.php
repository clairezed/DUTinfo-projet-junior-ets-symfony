<?php

namespace Junior\EtudiantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Junior\EtudiantBundle\Entity\Etudiant;
use Junior\EtudiantBundle\Entity\Etude;
use Junior\EtudiantBundle\Entity\Participant;
use Junior\EtudiantBundle\Form\EtudiantType;

class EtudiantController extends Controller
{
//    public function indexAction($name)
//    {
//        return $this->render('JuniorEtudiantBundle:Default:index.html.twig', array('name' => $name));
//    }
    
    public function indexAction()
    {
        return $this->render('JuniorEtudiantBundle:Default:index.html.twig');
    }
    
     /**
     * Page d'accueil etudiant
     * -> Tableau de bord
     * penser a integrer l'id a partir d'ici
     */ 
    public function dashboardAction()
    {
        return $this->render('JuniorEtudiantBundle:Etudiant:dashboardEtudiant.html.twig');
    }
    
/**************************************************
* Actions de manipulation des infos etudiant
***************************************************/ 
    
     /**
     * Voir les infos personnelles d'un etudiant
     *
     */ 
    public function showEtudiantAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Etudiant entity.');
        }

        return $this->render('JuniorEtudiantBundle:Etudiant:showEtudiant.html.twig', array(
            'entity'      => $entity,        
            ));
    }
    
    /**
     * Displays a form to edit an existing Etudiant entity.
     *
     */
    public function editEtudiantAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Etudiant entity.');
        }

        $editForm = $this->createForm(new EtudiantType(), $entity);

        return $this->render('JuniorEtudiantBundle:Etudiant:editEtudiant.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
    
    /**
     * Edits an existing Etudiant entity.
     *
     */
    public function updateEtudiantAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Etudiant entity.');
        }

        $editForm = $this->createForm(new EtudiantType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('junior_etudiant_showEtudiant', array('id' => $id)));
        }

        return $this->render('JuniorEtudiantBundle:Etudiant:editEtudiant.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    
/**************************************************
* Actions de manipulation des FRAIS
***************************************************/     
public function listFraisAction()
{
    $em = $this->getDoctrine()->getEntityManager();
 
    $entities = $em->getRepository('JuniorEtudiantBundle:Frais')->findAll();
 
    return $this->render('JuniorEtudiantBundle:Etudiant:listFrais.html.twig', array(
        'entities' => $entities
    ));
}

public function newFraisAction()
{
    return $this->render('JuniorEtudiantBundle:Etudiant:newFrais.html.twig');
}

/**************************************************
* Actions de manipulation des ETUDES
***************************************************/  
public function listEtudesAction($id)
{
    $cpt = 0;
    $listeEtudes = array(NULL); //Initialisation des variables : évite une erreur si l'étudiant ne participe à aucune étude
    $listeStatuts = array(NULL);
    $em = $this->getDoctrine()->getManager();
    
    $etudiant = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);
    $listeParticipations = $etudiant->getParticipants(); //On récupère la liste des entrées de la table participation correspondant à cet étudiant
    
    foreach($listeParticipations as $participation) { //Pour chaque entrée dans la liste, on récupère l'étude associée et le statut de l'étudiant pour celle-ci
        $listeEtudes[$cpt] = $participation->getEtude(); 
        $listeStatuts[$cpt] = $participation->getStatutEtudiant();
        $cpt++;
    }
    
    return $this->render('JuniorEtudiantBundle:Etudiant:listEtudes.html.twig', array(
        'etudes' => $listeEtudes, 'statuts' => $listeStatuts, 'etudiant' => $etudiant
    ));
}    

public function showEtudeAction($idEtude, $idEtudiant) {
    $em = $this->getDoctrine()->getManager();
    $etude = $em->getRepository('JuniorEtudiantBundle:Etude')->find($idEtude);
    $participant = $em->getRepository('JuniorEtudiantBundle:Participant')->findOneBy(array('etudiant' => $idEtudiant, 'etude' => $idEtude));
    $statut = $participant->getStatutEtudiant();
    $indemnites = $em->getRepository('JuniorEtudiantBundle:Indemnites')->findOneBy(array('etudiant' => $idEtudiant, 'etude' => $idEtude));
    $nbJours = $indemnites->getNbJours();
    $acomptes = $indemnites->getAcomptes();
    
    return $this->render('JuniorEtudiantBundle:Etudiant:showEtude.html.twig', array(
        'etude' => $etude, 'statut' => $statut, 'nbJours' => $nbJours, 'acomptes' => $acomptes
    ));
    
}
    
    
/**************************************************
* Actions créés automatiquement par le CRUD etudiant
 * (our info et exemples
***************************************************/ 
    
//    
//    public function showAction($id)
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);
//
//        if (!$entity) {
//            throw $this->createNotFoundException('Unable to find Etudiant entity.');
//        }
//
//        $deleteForm = $this->createDeleteForm($id);
//
//        return $this->render('JuniorEtudiantBundle:Etudiant:show.html.twig', array(
//            'entity'      => $entity,
//            'delete_form' => $deleteForm->createView(),        ));
//    }
//
//    /**
//     * Displays a form to edit an existing Etudiant entity.
//     *
//     */
//    public function editAction($id)
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);
//
//        if (!$entity) {
//            throw $this->createNotFoundException('Unable to find Etudiant entity.');
//        }
//
//        $editForm = $this->createForm(new EtudiantType(), $entity);
//        $deleteForm = $this->createDeleteForm($id);
//
//        return $this->render('JuniorEtudiantBundle:Etudiant:edit.html.twig', array(
//            'entity'      => $entity,
//            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }
//
//    /**
//     * Edits an existing Etudiant entity.
//     *
//     */
//    public function updateAction(Request $request, $id)
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);
//
//        if (!$entity) {
//            throw $this->createNotFoundException('Unable to find Etudiant entity.');
//        }
//
//        $deleteForm = $this->createDeleteForm($id);
//        $editForm = $this->createForm(new EtudiantType(), $entity);
//        $editForm->bind($request);
//
//        if ($editForm->isValid()) {
//            $em->persist($entity);
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('etudiant_edit', array('id' => $id)));
//        }
//
//        return $this->render('JuniorEtudiantBundle:Etudiant:edit.html.twig', array(
//            'entity'      => $entity,
//            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }
//
//    /**
//     * Deletes a Etudiant entity.
//     *
//     */
//    public function deleteAction(Request $request, $id)
//    {
//        $form = $this->createDeleteForm($id);
//        $form->bind($request);
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);
//
//            if (!$entity) {
//                throw $this->createNotFoundException('Unable to find Etudiant entity.');
//            }
//
//            $em->remove($entity);
//            $em->flush();
//        }
//
//        return $this->redirect($this->generateUrl('etudiant'));
//    }
//
//    /**
//     * Creates a form to delete a Etudiant entity by id.
//     *
//     * @param mixed $id The entity id
//     *
//     * @return Symfony\Component\Form\Form The form
//     */
//    private function createDeleteForm($id)
//    {
//        return $this->createFormBuilder(array('id' => $id))
//            ->add('id', 'hidden')
//            ->getForm()
//        ;
//    }
}




