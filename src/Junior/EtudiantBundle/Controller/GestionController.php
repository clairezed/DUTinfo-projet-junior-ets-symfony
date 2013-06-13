<?php

namespace Junior\EtudiantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Junior\EtudiantBundle\Entity\Etudiant;
use Junior\EtudiantBundle\Entity\Etude;
use Junior\EtudiantBundle\Entity\Facture;
//use Junior\EtudiantBundle\Entity\Frais;
use Junior\EtudiantBundle\Entity\Indemnites;
use Junior\EtudiantBundle\Entity\Entreprise;
use Junior\EtudiantBundle\Entity\Convention;
use Junior\EtudiantBundle\Entity\Participant;
use Junior\EtudiantBundle\Entity\RemboursementFrais;
use Junior\EtudiantBundle\Form\EtudiantType;
use Junior\EtudiantBundle\Form\NewEtudiantType;
//use Junior\EtudiantBundle\Form\NewRemboursementFraisType;
use Junior\EtudiantBundle\Form\EtudeType;
use Junior\EtudiantBundle\Form\ChoixEntrepriseType;
use Junior\EtudiantBundle\Form\ChoixEtudiantRFType;
use Junior\EtudiantBundle\Form\ChoixResponsableType;
use Junior\EtudiantBundle\Form\EntrepriseType;
use Junior\EtudiantBundle\Form\GroupeType;
use Junior\EtudiantBundle\Form\ConventionType;
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
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $listEtudes = $em->getRepository('JuniorEtudiantBundle:Etude')->findAll();
            $listAcomptesEnCours = $em->getRepository('JuniorEtudiantBundle:Acompte')->findAllAcomptesEnCours();
        }

        return $this->render('JuniorEtudiantBundle:Gestion:dashboardGestion.html.twig', array('listEtudes' => $listEtudes, 'listAcomptesEnCours' => $listAcomptesEnCours));
    }

    /*     * ************************************************
     * Actions de manipulation des infos ETUDIANT
     * ************************************************* */

    public function listEtudiantsAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $list_etudiant = $em->getRepository('JuniorEtudiantBundle:Etudiant')->findAll();

        return $this->render('JuniorEtudiantBundle:Gestion:listEtudiants.html.twig', array(
                    'list_etudiant' => $list_etudiant,
        ));
    }

    public function showEtudiantAction($idEtudiant) {
        $em = $this->getDoctrine()->getEntityManager();
        $etudiant = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($idEtudiant);
        if ($etudiant === null) {
            throw $this->createNotFoundException('Oups, y a un soucis pour trouver l\étudiant [id=' . $idEtudiant . '].');
        }
        $cpt = 0;
        $indemnites = array(NULL);
        $participants = $em->getRepository('JuniorEtudiantBundle:Participant')->findParticipantsbyEtudiant($idEtudiant);
        foreach ($participants as $participant) {
            $idEtudiant = $participant->getEtudiant()->getId();
            $idEtude = $participant->getEtude()->getId();   
            $indemnites[$cpt] = $em->getRepository('JuniorEtudiantBundle:Indemnites')-> findOneBy(array('etudiant' => $idEtudiant, 'etude' => $idEtude));
            $indemnites[$cpt] = $indemnites[$cpt]->getNbJours() * $indemnites[$cpt]->getIndemniteJournee();
            $cpt++;
        }

        return $this->render('JuniorEtudiantBundle:Gestion:showEtudiant.html.twig', array(
                    'etudiant' => $etudiant,
                    'participants' => $participants,
                    'indemnites'    => $indemnites,
        ));
    }

    public function newEtudiantAction() {
        $em = $this->getDoctrine()->getManager();
        $etudiant = new Etudiant();

        $form = $this->createForm(new NewEtudiantType(), $etudiant);
        $request = $this->getRequest();

        if (($request->getMethod() == 'POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $etudiant->setEnabled(true);
                $etudiant->setUsername($etudiant->getNumEtudiant());
                $etudiant->setPlainPassword('secret');
                $etudiant->setRoles(array('ROLE_ETUDIANT'));
                $em->persist($etudiant);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', 'L\'étudiant
a bien été créé');
                return $this->redirect($this->generateUrl('junior_gestion_listEtudiants'));
            }
        }
        return $this->render('JuniorEtudiantBundle:Gestion:newEtudiant.html.twig', array(
                    'form' => $form->createView(),
                        )
        );
    }

    public function editEtudiantAction($idEtudiant) {
        $em = $this->getDoctrine()->getManager();
        $etudiant = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($idEtudiant);

        if (!$etudiant) {
            throw $this->createNotFoundException('Unable to find Etudiant entity.');
        }

        $form = $this->createForm(new EtudiantType($etudiant), $etudiant);
        $request = $this->getRequest();

        if (($request->getMethod() == 'POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $em->persist($etudiant);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', 'L\'étudiant a bien été modifié');

                return $this->redirect($this->generateUrl('junior_gestion_showEtudiant', array(
                                    'idEtudiant' => $etudiant->getId(),
                )));
            }
        }
//        else {
//            $this->get('session')->getFlashBag()->add('info', 'Ya un problème mec');
//        }
        return $this->render('JuniorEtudiantBundle:Gestion:editEtudiant.html.twig', array(
                    'form' => $form->createView(),
                    'etudiant' => $etudiant,
                        )
        );
    }

    public function deleteEtudiantAction($idEtudiant) {

// On crée un formulaire vide, qui ne contiendra que le champ CSRF
// Cela permet de protéger la suppression d'article contre cette faille

        $em = $this->getDoctrine()->getManager();
        $etudiant = $em->getRepository('JuniorEtudiantBundle:Etudiant')->find($idEtudiant);

        $form = $this->createFormBuilder()->getForm();
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
// On supprime l'article
                $em = $this->getDoctrine()->getManager();
                $em->remove($etudiant);
                $em->flush();
// On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Etudiant
bien supprimé');
// Puis on redirige vers l'accueil
                return $this->redirect($this->generateUrl('junior_gestion_listEtudiants'));
//                    return $this->redirect(JuniorEtudiantBundle:Gestion:listEtudiants.html.twig);
            }
        }
// Si la requête est en GET, on affiche une page de confirmation avant de supprimer
        return $this->render('JuniorEtudiantBundle:Gestion:deleteEtudiant.html.twig', array(
                    'etudiant' => $etudiant,
                    'form' => $form->createView(),
                    'idEtudiant' => $etudiant->getId(),
        ));
    }

    /*     * ************************************************
     * Actions de manipulation des infos ACOMPTE
     * ************************************************* */

    public function listAcomptesAction() {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $listAcomptesEnCours = $em->getRepository('JuniorEtudiantBundle:Acompte')->findAllAcomptesEnCours();
            $listAcomptesValides = $em->getRepository('JuniorEtudiantBundle:Acompte')->findAllAcomptesValides();
        }
        return $this->render('JuniorEtudiantBundle:Gestion:listAcomptes.html.twig', array('listAcomptesEnCours' => $listAcomptesEnCours, 'listAcomptesValides' => $listAcomptesValides));
    }

    public function validAcompteAction($idAcompte) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $acompte = $em->getRepository('JuniorEtudiantBundle:Acompte')->findOneById($idAcompte);
            $acompte->setStatutAcompte('Validé');
            $em->persist($acompte);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'Acompte validé');
        }
        return $this->redirect($this->generateUrl('junior_gestion_listAcomptes'));
    }

    public function showAcompteAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:showAcompte.html.twig');
    }

    /**************************************************
     * Actions de manipulation des infos FRAIS
     * **************************************************/

    public function listFraisAction() {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $listFraisEnregistrés = $em->getRepository('JuniorEtudiantBundle:Frais')->findFraisByStatut('Enregistré');
            $listFraisNotInRF = $em->getRepository('JuniorEtudiantBundle:Frais')->findFraisNotInRF();
            $list_rf = $em->getRepository('JuniorEtudiantBundle:RemboursementFrais')->findAll();
        }
        return $this->render('JuniorEtudiantBundle:Gestion:listFrais.html.twig', array(
                    'listFraisEnregistrés' => $listFraisEnregistrés,
                    'listFraisNotInRF' => $listFraisNotInRF,
                    'list_rf' => $list_rf
        ));
    }

    public function sortFraisAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:sortFrais.html.twig');
    }

    public function validFraisAction($idFrais) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $frais = $em->getRepository('JuniorEtudiantBundle:Frais')->findOneById($idFrais);
            $frais->setStatutFrais('Validé');
            $em->persist($frais);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'Frais validé');
        }
        return $this->redirect($this->generateUrl('junior_gestion_listFrais'));
    }

    public function refusFraisAction($idFrais) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $frais = $em->getRepository('JuniorEtudiantBundle:Frais')->findOneById($idFrais);
            $frais->setStatutFrais('Refusé');
            $em->persist($frais);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'Frais refusé');
        }
        return $this->redirect($this->generateUrl('junior_gestion_listFrais'));
    }

    public function selectEtudiantRFAction() {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $form = $this->createForm(new ChoixEtudiantRFType());
            $request = $this->getRequest();

            if ($request->getMethod() == 'POST') {
                $postData = $request->request->get('junior_etudiantbundle_choixetudiantrftype');

                $idFrais = $postData['etudiants'];
                $frais = $em->getRepository('JuniorEtudiantBundle:Frais')->findOneById($idFrais);
                $idEtudiant = $frais->getEtudiant()->getId();

                return $this->redirect($this->generateUrl('junior_gestion_newRF', array(
                                    'idEtudiant' => $idEtudiant,
                )));
            }
            return $this->render('JuniorEtudiantBundle:Gestion:selectEtudiantRF.html.twig', array(
                        'form' => $form->createView()));
        }
    }

    public function newRFAction($idEtudiant) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $rf = new RemboursementFrais;
            $rf->setDateRemboursement(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $etudiant = $em->getRepository('JuniorEtudiantBundle:Etudiant')->findOneById($idEtudiant);
//            var_dump($idEtudiant);
            $listFraisNewRF = $em->getRepository('JuniorEtudiantBundle:Frais')
                    ->findFraisNotInRFbyStudent($idEtudiant);
            $listEtudes = $em->getRepository('JuniorEtudiantBundle:Etude')
                    ->findEtudesbyStudent($idEtudiant);
//            $conventions = array(NULL);
//            $cpt = 0;
            foreach ($listFraisNewRF as $frais) {
//                    $etudiant = $em->getRepository('JuniorEtudiantBundle:Etudiant')->findOneById($participant);
                $rf->addFrai($frais);
                $frais->setRemboursementsFrais($rf);
                $em->persist($frais);
//                $conventions[$cpt] = $frais->getEtude()->getConvention()->getId();
//                $cpt++;
//                                var_dump($frais->getTypeFrais());
            }

            $em->persist($rf);
            $em->flush();
        }
        return $this->render('JuniorEtudiantBundle:Gestion:newRF.html.twig', array(
                    'rf' => $rf,
                    'etudiant' => $etudiant,
                    'listFrais' => $listFraisNewRF,
                    'listEtudes' => $listEtudes
        ));
    }

    public function showRFAction($idRF, $idEtudiant) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $rf = $em->getRepository('JuniorEtudiantBundle:RemboursementFrais')->findOneById($idRF);
            $etudiant = $em->getRepository('JuniorEtudiantBundle:Etudiant')->findOneById($idEtudiant);
            $listFrais = $rf->getFrais();
            $listEtudes = $em->getRepository('JuniorEtudiantBundle:Etude')
                    ->findEtudesbyStudent($idEtudiant);
        }
        return $this->render('JuniorEtudiantBundle:Gestion:showRF.html.twig', array(
                    'rf' => $rf,
                    'etudiant' => $etudiant,
                    'listFrais' => $listFrais,
                    'listEtudes' => $listEtudes
        ));
    }

    public function cancelRFAction($idRF) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $rf = $em->getRepository('JuniorEtudiantBundle:RemboursementFrais')->findOneById($idRF);
            foreach ($rf->getFrais() as $frais) {
                $frais->setRemboursementsFrais(null);
                $em->persist($frais);
            }
            $em->remove($rf);
            $em->persist($rf);
            $em->flush();

            return $this->redirect($this->generateUrl('junior_gestion_listFrais'));
        }
    }

    public function listRFAction() {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getEntityManager();

            $list_rf = $em->getRepository('JuniorEtudiantBundle:RemboursementFrais')->findAll();

            return $this->render('JuniorEtudiantBundle:Gestion:listRF.html.twig', array(
                        'list_rf' => $list_rf
            ));
        }
    }

    /*     * ************************************************
     * Actions de manipulation des infos ETUDE
     * ************************************************* */

    public function listEtudesAction() {

        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $listEtudes = $em->getRepository('JuniorEtudiantBundle:Etude')->findAll();
        }
        return $this->render('JuniorEtudiantBundle:Gestion:listEtudes.html.twig', array('etudes' => $listEtudes));
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
            $etudiants = array(NULL);
            $statuts = array(NULL);
//            $nbJours = $etude->getIndemnites()->getNbJours();

            foreach ($listParticipants as $participant) {
                $statuts[$cpt] = $participant->getStatutEtudiant();
                $etudiants[$cpt] = $participant->getEtudiant();
                $cpt++;
            }
        }

        return $this->render('JuniorEtudiantBundle:Gestion:showEtude.html.twig', array(
                    'etude' => $etude,
                    'entreprise' => $entreprise,
                    'etudiants' => $etudiants,
                    'statuts' => $statuts));
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
            $etude->setStatutEtude('En cours');

            $form = $this->createForm(new EtudeType(), $etude);
            $request = $this->getRequest();

            if (($request->getMethod() == 'POST')) {
                $form->bind($request);
                if ($form->isValid()) {
                    $em->persist($etude);
                    $em->flush();
                    $idEtude = $etude->getId();
                    return $this->redirect($this->generateUrl('junior_gestion_newGroupe', array('idEtude' => $idEtude)));
                }
            }
        }
        return $this->render('JuniorEtudiantBundle:Gestion:newEtude.html.twig', array('form' => $form->createView()));
    }

    public function newGroupeAction($idEtude) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $etude = $em->getRepository('JuniorEtudiantBundle:Etude')->findOneById($idEtude);
            $nbParticipants = 0;

            $form = $this->createForm(new GroupeType());
            $request = $this->getRequest();

            if ($request->getMethod() == 'POST') {
                $postData = $request->request->get('junior_etudiantbundle_groupetype');
                $participants = $postData['participants'];

                foreach ($participants as $participant) {
                    $nbParticipants++;
                }

                foreach ($participants as $participant) {
                    $etudiant = $em->getRepository('JuniorEtudiantBundle:Etudiant')->findOneById($participant);
                    $membre = new Participant();
                    $membre->setEtude($etude);
                    $membre->setEtudiant($etudiant);
                    $membre->setStatutEtudiant("Participant");
                    $indemnite = new Indemnites();
                    $indemnite->setEtude($etude);
                    $indemnite->setEtudiant($etudiant);
                    $indemnite->setRetenue(5);
                    $indemnite->setNbJours($etude->getNbJoursEtude() / $nbParticipants);
                    $indemnite->setIndemniteJournee($etude->getPrixJournee() / $nbParticipants);
                    $em->persist($indemnite);
                    $em->persist($membre);
                    $em->flush();
                }
                return $this->redirect($this->generateUrl('junior_gestion_choixResponsable', array('idEtude' => $idEtude)));
            }
        }
        return $this->render('JuniorEtudiantBundle:Gestion:newGroupe.html.twig', array('form' => $form->createView()));
    }

    public function choixResponsableAction($idEtude) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $form = $this->createForm(new ChoixResponsableType($idEtude));
            $request = $this->getRequest();

            if ($request->getMethod() == 'POST') {
                $postData = $request->request->get('junior_etudiantbundle_choixresponsabletype');
                $idEtudiant = $postData['participants'];
                $participant = $em->getRepository('JuniorEtudiantBundle:Participant')->findOneBy(array('etudiant' => $idEtudiant, 'etude' => $idEtude));
                $participant->setStatutEtudiant("Responsable");
                $em->persist($participant);
                $em->flush();
                return $this->redirect($this->generateUrl('junior_gestion_listEtudes'));
            }
        }
        return $this->render('JuniorEtudiantBundle:Gestion:choixResponsable.html.twig', array('form' => $form->createView()));
    }

    public function editEtudeAction() {
        return $this->render('JuniorEtudiantBundle:Gestion:editEtude.html.twig');
    }

    public function closeEtudeAction($idEtude) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
//            $em = $this->getDoctrine()->getManager();
//            $etude = $em->getRepository('JuniorEtudiantBundle:Etude')->findOneById($idEtude);
//            $etude->setStatutEtude("Terminée");
//            $em->persist($etude);
//            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'Etude clôturée');
        }
        //return $this->redirect('JuniorEtudiantBundle:Gestion:listEtudes.html.twig');
        return $this->redirect($this->generateUrl('junior_gestion_listEtudes'));
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

            if (($request->getMethod() == 'POST')) {
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
            $em = $this->getDoctrine()->getManager();
            $entreprise = new Entreprise();
            $form = $this->createForm(new EntrepriseType(), $entreprise);
            $request = $this->getRequest();

            if (($request->getMethod() == 'POST')) {
                $form->bind($request);
                if ($form->isValid()) {
                    $em->persist($entreprise);
                    $em->flush();
                    $idEntreprise = $entreprise->getId();
                    return $this->redirect($this->generateUrl('junior_gestion_newConvention', array('idEntreprise' => $idEntreprise)));
                }
            }
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
                if ($form->isValid()) {
                    $em->persist($convention);
                    $em->flush();
                    $idConvention = $convention->getId();
                    return $this->redirect($this->generateUrl('junior_gestion_newEtude', array('idConvention' => $idConvention)));
                }
            }
        }
        return $this->render('JuniorEtudiantBundle:Gestion:newConvention.html.twig', array('form' => $form->createView()));
    }

    /*     * ************************************************
     * Actions de manipulation des infos FACTURE
     * ************************************************* */

    public function newFactureAction($idEtude) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $cpt = 0;
            $em = $this->getDoctrine()->getManager();
            $etude = $em->getRepository('JuniorEtudiantBundle:Etude')->findOneById($idEtude);
            $rf = $em->getRepository('JuniorEtudiantBundle:RemboursementFrais')->findAll();
            $listRF = $em->getRepository('JuniorEtudiantBundle:Etude')->findRFbyEtude($etude, $rf);
            $montantRF[0] = array(NULL);
            $totalRF = 0;

            if ($listRF[0] != NULL) {
                foreach ($listRF as $rf) {
                    $montantRF[$cpt] = $em->getRepository('JuniorEtudiantBundle:Etude')->findMontantRFbyEtude($etude, $rf);
                    $totalRF += $montantRF[$cpt];
                    $cpt++;
                }
            }

            $coutEtude = $etude->getPrixJournee() * $etude->getNbJoursEtude();
            $montantHT = $coutEtude + $totalRF;
            $montantTVA = $montantHT * 19.6 / 100;
            $montantTTC = $montantHT + $montantTVA;

            $facture = new Facture();
            $facture->setEtude($etude);
            $facture->setCoutEtude($coutEtude);
            $facture->setMontantHT($montantHT);
            $facture->setMontantTVA($montantTVA);
            $facture->setMontantTTC($montantTTC);
            $etude->setStatutEtude('Terminée');
            $em->persist($facture);
            $em->persist($etude);
            $em->flush();

            return $this->render('JuniorEtudiantBundle:Gestion:newFacture.html.twig', array(
                        'facture' => $facture,
                        'listRF' => $listRF,
                        'montantRF' => $montantRF));
        }
    }

    public function cancelFactureAction($idFacture) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $facture = $em->getRepository('JuniorEtudiantBundle:Facture')->findOneById($idFacture);
            $etude = $facture->getEtude();
            $etude->setStatutEtude('En cours');

            $em->remove($facture);
            $em->persist($etude);
            $em->flush();

            return $this->redirect($this->generateUrl('junior_gestion_listEtudes'));
        }
    }

    public function showFactureAction($idEtude) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $etude = $em->getRepository('JuniorEtudiantBundle:Etude')->findOneById($idEtude);
            $facture = $etude->getFacture();

            $rf = $em->getRepository('JuniorEtudiantBundle:RemboursementFrais')->findAll();
            $listRF = $em->getRepository('JuniorEtudiantBundle:Etude')->findRFbyEtude($etude, $rf);
            $montantRF[0] = array(NULL);
            $cpt = 0;

            if ($listRF[0] != NULL) {
                foreach ($listRF as $rf) {
                    $montantRF[$cpt] = $em->getRepository('JuniorEtudiantBundle:Etude')->findMontantRFbyEtude($etude, $rf);
                    $cpt++;
                }
            }

            return $this->render('JuniorEtudiantBundle:Gestion:showFacture.html.twig', array('facture' => $facture, 'listRF' => $listRF, 'montantRF' => $montantRF));
        }
    }

    /*     * ************************************************
     * Actions de manipulation des infos INDEMNITES
     * ************************************************* */

    public function selectEtudiantIndemnitesAction($idEtude) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $form = $this->createForm(new ChoixResponsableType($idEtude));
            $request = $this->getRequest();

            if ($request->getMethod() == 'POST') {
                $postData = $request->request->get('junior_etudiantbundle_choixresponsabletype');
                $idEtudiant = $postData['participants'];

                return $this->redirect($this->generateUrl('junior_gestion_showIndemnites', array(
                                    'idEtudiant' => $idEtudiant,
                                    'idEtude' => $idEtude)));
            }
            return $this->render('JuniorEtudiantBundle:Gestion:selectEtudiantIndemnites.html.twig', array(
                        'form' => $form->createView()));
        }
    }

    public function showIndemnitesAction($idEtudiant, $idEtude) {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('JuniorEtudiantBundle::layout.html.twig');
        } else {
            $em = $this->getDoctrine()->getManager();
            $etudiant = $em->getRepository('JuniorEtudiantBundle:Etudiant')->findOneById($idEtudiant);
            $indemnites = $em->getRepository('JuniorEtudiantBundle:Indemnites')->findOneBy(array('etudiant' => $idEtudiant, 'etude' => $idEtude));
            $statut = $em->getRepository('JuniorEtudiantBundle:Participant')->findOneBy(array('etudiant' => $idEtudiant, 'etude' => $idEtude))->getStatutEtudiant();
            $montantsAcomptes = $em->getRepository('JuniorEtudiantBundle:Indemnites')->findMontantsAcomptesByIndemnites($indemnites);
            $totalAcomptes = $em->getRepository('JuniorEtudiantBundle:Indemnites')->findTotalAcomptesByIndemnites($indemnites);
            $acomptes = $indemnites->getAcomptes();

            return $this->render('JuniorEtudiantBundle:Gestion:showIndemnites.html.twig', array('etudiant' => $etudiant, 'indemnites' => $indemnites, 'montantsAcomptes' => $montantsAcomptes, 'acomptes' => $acomptes, 'totalAcomptes' => $totalAcomptes, 'statut' => $statut));
        }
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

