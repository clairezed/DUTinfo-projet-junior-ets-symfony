<?php

namespace Junior\EtudiantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Junior\EtudiantBundle\Entity\Etudiant;
use Junior\EtudiantBundle\Entity\Etude;
use Junior\EtudiantBundle\Entity\Acompte;
use Junior\EtudiantBundle\Entity\Participant;
use Junior\EtudiantBundle\Entity\Frais;
use Junior\EtudiantBundle\Form\EtudiantType;
use Junior\EtudiantBundle\Form\AcompteType;
use Junior\EtudiantBundle\Form\FraisType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;

class EtudiantController extends Controller {

//    public function indexAction($name)
//    {
//        return $this->render('JuniorEtudiantBundle:Default:index.html.twig', array('name' => $name));
//    }

    public function indexAction() {
        return $this->render('JuniorEtudiantBundle:Default:index.html.twig');
    }

    /**
     * Page d'accueil etudiant
     * -> Tableau de bord
     * penser a integrer l'id a partir d'ici
     * @Secure(roles="IS_AUTHENTICATED_REMEMBERED")
     * 
     */
    public function dashboardAction() {

        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $id = $user->getId();
            $em = $this->getDoctrine()->getEntityManager();

            $list_frais = $em->getRepository('JuniorEtudiantBundle:Frais')->findFraisbyIdEtudiant($id);
            $etudiant = $em->getRepository('JuniorEtudiantBundle:Etudiant')->findOneById($id);
            $etudes = $etudiant->getEtudes();
            $statuts = $etudiant->getStatuts();

            return $this->render('JuniorEtudiantBundle:Etudiant:dashboardEtudiant.html.twig', array(
                        'list_frais' => $list_frais, 'etudes' => $etudes, 'statuts' => $statuts
            ));
        }
    }

    /*     * ************************************************
     * Actions de manipulation des infos etudiant
     * ************************************************* */

    /**
     * Voir les infos personnelles d'un etudiant
     *
     */
    public function showEtudiantAction() {

        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $id = $user->getId();
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Etudiant entity.');
            }

            return $this->render('JuniorEtudiantBundle:Etudiant:showEtudiant.html.twig', array(
                        'entity' => $entity,
            ));
        }
    }

    /**
     * Displays a form to edit an existing Etudiant entity.
     *
     */
    public function editEtudiantAction() {

        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $id = $user->getId();
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Etudiant entity.');
            }

            $editForm = $this->createForm(new EtudiantType(), $entity);

            return $this->render('JuniorEtudiantBundle:Etudiant:editEtudiant.html.twig', array(
                        'entity' => $entity,
                        'edit_form' => $editForm->createView(),
            ));
        }
    }

    /**
     * Edits an existing Etudiant entity.
     *
     */
    public function updateEtudiantAction(Request $request) {

        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $id = $user->getId();

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
                        'entity' => $entity,
                        'edit_form' => $editForm->createView(),
            ));
        }
    }

    /*     * ************************************************
     * Actions de manipulation des FRAIS
     * ************************************************* */

    public function listFraisAction() {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $id = $user->getId();
            $em = $this->getDoctrine()->getEntityManager();

            $list_frais = $em->getRepository('JuniorEtudiantBundle:Frais')->findFraisbyIdEtudiant($id);
            $list_rf = $em->getRepository('JuniorEtudiantBundle:RemboursementFrais')->findRFbyIdEtudiant($id);
//            $nbfrais = $list_rf->getFrais()->count();

            return $this->render('JuniorEtudiantBundle:Etudiant:listFrais.html.twig', array(
                        'list_frais' => $list_frais,
                        'list_rf' => $list_rf
//                        'nbfrais' => $nbfrais
            ));
        }
    }

    public function newFraisAction() {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $frais = new Frais;
            $form = $this->createForm(new FraisType, $frais);
            $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($frais);
                    $em->flush();

                    return $this->redirect($this->generateUrl('junior_etudiant_dashboard'));
                }
            }
            return $this->render('JuniorEtudiantBundle:Etudiant:newFrais.html.twig', array(
                        'form' => $form->createView(),
            ));
        }
    }

    public function showRembFraisAction($idRF) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getEntityManager();

            $rf = $em->getRepository('JuniorEtudiantBundle:RemboursementFrais')->find($idRF);

            return $this->render('JuniorEtudiantBundle:Etudiant:showRembFrais.html.twig', array(
                        'rf' => $rf
            ));
        }
    }

    /*     * ************************************************
     * Actions de manipulation des ETUDES
     * ************************************************* */

    public function listEtudesAction() {

        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $id = $user->getId();
            $cpt = 0;
            $listeEtudes = array(NULL); //Initialisation des variables : évite une erreur si l'étudiant ne participe à aucune étude
            $listeStatuts = array(NULL);
            $em = $this->getDoctrine()->getManager();

            $etudiant = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($id);
            $listeParticipations = $etudiant->getParticipants(); //On récupère la liste des entrées de la table participation correspondant à cet étudiant

            foreach ($listeParticipations as $participation) { //Pour chaque entrée dans la liste, on récupère l'étude associée et le statut de l'étudiant pour celle-ci
                $listeEtudes[$cpt] = $participation->getEtude();
                $listeStatuts[$cpt] = $participation->getStatutEtudiant();
                $cpt++;
            }

            return $this->render('JuniorEtudiantBundle:Etudiant:listEtudes.html.twig', array(
                        'etudes' => $listeEtudes, 'statuts' => $listeStatuts, 'etudiant' => $etudiant
            ));
        }
    }

    public function showEtudeAction($idEtude) {

        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $idEtudiant = $user->getId();

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
    }
    
    /*     * ************************************************
     * Actions de manipulation des ACOMPTES
     * ************************************************* */
    
    public function newAcompteAction($idEtude) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $acompte = new Acompte();
        
        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $idEtudiant = $user->getId();
            $etude = $em->getRepository('JuniorEtudiantBundle:Etude')->findOneById($idEtude);
            $indemnite = $em->getRepository('JuniorEtudiantBundle:Indemnites')->findOneBy(array('etudiant' => $idEtudiant, 'etude' => $idEtude));
            $acompte->setIndemnite($indemnite);
            
             $form = $this->createForm(new AcompteType(), $acompte);
             
             $request = $this->getRequest();
             
            if ($request->getMethod() == 'POST') {
                $postData = $request->request->get('junior_etudiantbundle_acomptetype');
                $montant = $postData['montantAcompte'];
                $form->bind($request);
                if ($form->isValid() && $indemnite->getNombreAcomptes() < 3 && (($montant + $indemnite->getTotalAcomptes()) <= ($indemnite->getNbJours() * $indemnite->getEtude()->getPrixJournee() * 0.8))) {
                    var_dump($indemnite->getNombreAcomptes());
                    $acompte->setIndemnite($indemnite);
                    $acompte->setDateAcompte(new \Datetime());
                    $acompte->setStatutAcompte('En attente');
                    $em->persist($acompte);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('info', 'Votre demande d\'acompte a été transmise');
                }
                else if ($indemnite->getNombreAcomptes() >= 3) {
                    $this->get('session')->getFlashBag()->add('erreur', 'Erreur : vous avez déja demandé trois acomptes pour cette étude');
                }
                else if (($montant + $indemnite->getTotalAcomptes()) > ($indemnite->getNbJours() * $indemnite->getEtude()->getPrixJournee() * 0.8)) {
                    $this->get('session')->getFlashBag()->add('erreur', 'Erreur : vous avez dépassé le montant autorisé pour cette étude');
                }
                else {
                    $this->get('session')->getFlashBag()->add('erreur', 'Erreur lors de la transmission de la demande');
                }

                return $this->redirect($this->generateUrl('junior_etudiant_listEtudes'));
            } 
            return $this->render('JuniorEtudiantBundle:Etudiant:newAcompte.html.twig', array(
            'form' => $form->createView(), 'idEtude' => $idEtude, 'etude' =>$etude
            ));
        }
    }

    /*     * ************************************************
     * Actions créés automatiquement par le CRUD etudiant
     * (our info et exemples
     * ************************************************* */

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

