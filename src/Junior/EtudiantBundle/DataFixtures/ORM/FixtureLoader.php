<?php

namespace Junior\EtudiantBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Junior\EtudiantBundle\Entity\Acompte;
use Junior\EtudiantBundle\Entity\Indemnites;
use Junior\EtudiantBundle\Entity\Etudiant;
use Junior\EtudiantBundle\Entity\Etude;
use Junior\EtudiantBundle\Entity\Participant;
use Junior\EtudiantBundle\Entity\Convention;
use Junior\EtudiantBundle\Entity\Entreprise;
use Junior\EtudiantBundle\Entity\Frais;
use Junior\EtudiantBundle\Entity\RemboursementFrais;
use Junior\EtudiantBundle\Entity\Facture;

class FixtureLoader implements FixtureInterface, ContainerAwareInterface {

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {


        $dupont = new Etudiant();
        $dupont->setNumEtudiant('e1');
        $dupont->setNomEtudiant('Dupont');
        $dupont->setAdresseEtudiant('8, rue de la Choucroute Farcie');
        $dupont->setNumSecu('123456');
        $dupont->setDateNaissance(new \DateTime('1987/12/13')); 
        $dupont->setTelEtudiant('0612345678');
        $dupont->setUsername('e1');
        $dupont->setEmail('dupont@etu.com');
        $encoder = $this->container
                ->get('security.encoder_factory')
                ->getEncoder($dupont);
        $dupont->setPassword($encoder->encodePassword('secret', $dupont->getSalt()));
        $dupont->setRoles(array('ROLE_ETUDIANT'));
        $dupont->setEnabled(true);


        $durand = new Etudiant();
        $durand->setNumEtudiant('e2');
        $durand->setNomEtudiant('Durand');
        $durand->setAdresseEtudiant('12, rue du Poney Farceur');
        $durand->setNumSecu('654321');
        $durand->setDateNaissance(new \DateTime('1983/02/28'));
        $durand->setTelEtudiant('0687654321');
        $durand->setUsername('e2');
        $durand->setEmail('durand@etu.com');
        $encoder = $this->container
                        ->get('security.encoder_factory')->getEncoder($durand);
        $durand->setPassword($encoder->encodePassword('secret', $durand->getSalt()));
        $durand->setRoles(array('ROLE_ETUDIANT'));
        $durand->setEnabled(true);


        $duchmol = new Etudiant();
        $duchmol->setNumEtudiant('e3');
        $duchmol->setNomEtudiant('Duchmol');
        $duchmol->setAdresseEtudiant('16, rue de la Belette Farceuse');
        $duchmol->setNumSecu('987654');
        $duchmol->setDateNaissance(new \DateTime('1982/04/22'));
        $duchmol->setTelEtudiant('0601020304');
        $duchmol->setUsername('e3');
        $duchmol->setEmail('duchmol@etu.com');
        $encoder = $this->container
                        ->get('security.encoder_factory')->getEncoder($duchmol);
        $duchmol->setPassword($encoder->encodePassword('secret', $duchmol->getSalt()));
        $duchmol->setRoles(array('ROLE_ETUDIANT'));
        $duchmol->setEnabled(true);

        $dugland = new Etudiant();
        $dugland->setNumEtudiant('e4');
        $dugland->setNomEtudiant('Dugland');
        $dugland->setAdresseEtudiant('20, rue de l\'Hippocampe Hilare');
        $dugland->setNumSecu('456789');
        $dugland->setDateNaissance(new \DateTime('1988/09/05'));
        $dugland->setTelEtudiant('0604030201');
        $dugland->setUsername('e4');
        $dugland->setEmail('dugland@etu.com');
        $encoder = $this->container
                        ->get('security.encoder_factory')->getEncoder($dugland);
        $dugland->setPassword($encoder->encodePassword('secret', $dugland->getSalt()));
        $dugland->setRoles(array('ROLE_ETUDIANT'));
        $dugland->setEnabled(true);


        $manager->persist($dupont);
        $manager->persist($durand);
        $manager->persist($duchmol);
        $manager->persist($dugland);
        $manager->flush();

        $dspr = new Entreprise();
        $dspr->setNomEntreprise('DeathStar PR');
        $dspr->setAdresseEntreprise('5, rue de l\'Empereur, 75000 Coruscant');
        $dspr->setTelEntreprise('0299556677');

        $uc = new Entreprise();
        $uc->setNomEntreprise('Umbrella Corporation');
        $uc->setAdresseEntreprise('8, rue du Zombie Joyeux, 69000 Racoon City');
        $uc->setTelEntreprise('0623456789');

        $manager->persist($dspr);
        $manager->persist($uc);
        $manager->flush();

        $dspr_c = new Convention();
        $dspr_c->setDateConvention(new \DateTime('2013/03/12'));
        $dspr_c->setEntreprise($dspr);

        $uc_c = new Convention();
        $uc_c->setDateConvention(new \DateTime('2012/11/08'));
        $uc_c->setEntreprise($uc);
        
        $dspr_c2 = new Convention();
        $dspr_c2->setDateConvention(new \DateTime('2013/05/08'));
        $dspr_c2->setEntreprise($dspr);

        $manager->persist($dspr_c);
        $manager->persist($uc_c);
        $manager->persist($dspr_c2);
        $manager->flush();

        $dspr_e = new Etude();
        $dspr_e->setNomEtude('La réception de la politique familiale impériale dans les mondes de la Bordure Extérieure');
        $dspr_e->setPrixJournee('300');
        $dspr_e->setConvention($dspr_c);
        $dspr_e->setStatutEtude('En cours');
        $dspr_e->setDateFinPrevue(new \DateTime('2013/09/07'));
        $dspr_e->setNbJoursEtude('30');

        $uc_e = new Etude();
        $uc_e->setNomEtude('Projection prévisionnelle de propagation d\'un virus mutagène');
        $uc_e->setPrixJournee('200');
        $uc_e->setConvention($uc_c);
        $uc_e->setStatutEtude('En cours');
        $uc_e->setDateFinPrevue(new \DateTime('2013/08/12'));
        $uc_e->setNbJoursEtude('15');
        
        $dspr_e2 = new Etude();
        $dspr_e2->setNomEtude('L\'impact relations publiques longue durée de la destruction d\'une planète');
        $dspr_e2->setPrixJournee('300');
        $dspr_e2->setConvention($dspr_c2);
        $dspr_e2->setStatutEtude('Terminée');
        $dspr_e2->setDateFinPrevue(new \DateTime('2013/12/23'));
        $dspr_e2->setNbJoursEtude('25');

        $manager->persist($dspr_e);
        $manager->persist($uc_e);
        $manager->persist($dspr_e2);
        $manager->flush();
        
        $dspr_e2f = new Facture();
        $dspr_e2f->setEtude($dspr_e2);
        $dspr_e2f->setCoutEtude('7500');
        $dspr_e2f->setMontantHT('7500');
        $dspr_e2f->setMontantTVA('1470');
        $dspr_e2f->setMontantTTC('8970');
        
        $manager->persist($dspr_e2f);
        $manager->flush();

        $p1 = new Participant();
        $p1->setEtude($uc_e);
        $p1->setEtudiant($dupont);
        $p1->setStatutEtudiant("Reponsable");

        $p2 = new Participant();
        $p2->setEtude($uc_e);
        $p2->setEtudiant($durand);
        $p2->setStatutEtudiant("Participant");

        $p3 = new Participant();
        $p3->setEtude($uc_e);
        $p3->setEtudiant($duchmol);
        $p3->setStatutEtudiant("Participant");

        $p4 = new Participant();
        $p4->setEtude($dspr_e);
        $p4->setEtudiant($duchmol);
        $p4->setStatutEtudiant("Reponsable");

        $p5 = new Participant();
        $p5->setEtude($dspr_e);
        $p5->setEtudiant($durand);
        $p5->setStatutEtudiant("Participant");

        $p6 = new Participant();
        $p6->setEtude($dspr_e);
        $p6->setEtudiant($dupont);
        $p6->setStatutEtudiant("Participant");
        
        $p7 = new Participant();
        $p7->setEtude($dspr_e2);
        $p7->setEtudiant($dupont);
        $p7->setStatutEtudiant("Reponsable");
        
        $p8 = new Participant();
        $p8->setEtude($dspr_e2);
        $p8->setEtudiant($durand);
        $p8->setStatutEtudiant("Participant");

        $manager->persist($p1);
        $manager->persist($p2);
        $manager->persist($p3);
        $manager->persist($p4);
        $manager->persist($p5);
        $manager->persist($p6);
        $manager->persist($p7);
        $manager->persist($p8);
        $manager->flush();

        
        
         $rf1 = new RemboursementFrais();
        $rf1->setDateRemboursement(new \DateTime('2013/02/04'));
//        $rf1->addFrai($f1);
//        $rf1->addFrai($f2);

        $rf2 = new RemboursementFrais();
        $rf2->setDateRemboursement(new \DateTime('2013/05/06')); 
//        $rf2->addFrai($f3);

        $rf3 = new RemboursementFrais();
        $rf3->setDateRemboursement(new \DateTime('2013/06/05')); 
//        $rf3->addFrai($f4);
        
        

        $manager->persist($rf1);
        $manager->persist($rf2);
        $manager->persist($rf3);
        $manager->flush();


        $f1 = new Frais();
        $f1->setEtude($dspr_e);
        $f1->setEtudiant($durand);
        $f1->setTypeFrais('Materiel de laboratoire');
        $f1->setMontantFrais('2000');
        $f1->setDateAchat(new \DateTime('2013/04/15')); 
        $f1->setRemboursementsFrais($rf1);


        $f2 = new Frais();
        $f2->setEtude($dspr_e);
        $f2->setEtudiant($durand);
        $f2->setTypeFrais('Nourriture galactique standard');
        $f2->setMontantFrais('32');
        $f2->setDateAchat(new \DateTime('2013/04/22')); 
        $f2->setRemboursementsFrais($rf1);

        $f3 = new Frais();
        $f3->setEtude($uc_e);
        $f3->setEtudiant($dupont);
        $f3->setTypeFrais('Transport Hyperluminique');
        $f3->setMontantFrais('12500');
        $f3->setDateAchat(new \DateTime('2013/05/08')); 
        $f3->setRemboursementsFrais($rf2);

        $f4 = new Frais();
        $f4->setEtude($uc_e);
        $f4->setEtudiant($duchmol);
        $f4->setTypeFrais('tournevis sonic');
        $f4->setMontantFrais('1200');
        $f4->setDateAchat(new \DateTime('2013/06/30')); 
        $f4->setRemboursementsFrais($rf3);

        $f5 = new Frais();
        $f5->setEtude($dspr_e);
        $f5->setEtudiant($dupont);
        $f5->setTypeFrais('location licorne');
        $f5->setMontantFrais('80');
        $f5->setDateAchat(new \DateTime('2013/07/14')); 
        

        $manager->persist($f1);
        $manager->persist($f2);
        $manager->persist($f3);
        $manager->persist($f4);
        $manager->persist($f5);
        $manager->flush();


       
        
        

        $i1 = new Indemnites();
        $i1->setEtude($uc_e);
        $i1->setEtudiant($dupont);
        $i1->setNbJours('75');
        $i1->setRetenue('5');
        $i1->setIndemniteJournee('50');

        $i2 = new Indemnites();
        $i2->setEtude($uc_e);
        $i2->setEtudiant($durand);
        $i2->setNbJours('75');
        $i2->setRetenue('5');
        $i2->setIndemniteJournee('50');

        $i3 = new Indemnites();
        $i3->setEtude($uc_e);
        $i3->setEtudiant($duchmol);
        $i3->setNbJours('75');
        $i3->setRetenue('5');
        $i3->setIndemniteJournee('50');

        $i4 = new Indemnites();
        $i4->setEtude($dspr_e);
        $i4->setEtudiant($duchmol);
        $i4->setNbJours('120');
        $i4->setRetenue('6');
        $i4->setIndemniteJournee('60');

        $i5 = new Indemnites();
        $i5->setEtude($dspr_e);
        $i5->setEtudiant($durand);
        $i5->setNbJours('120');
        $i5->setRetenue('6');
        $i5->setIndemniteJournee('60');

        $i6 = new Indemnites();
        $i6->setEtude($dspr_e);
        $i6->setEtudiant($dupont);
        $i6->setNbJours('120');
        $i6->setRetenue('6');
        $i6->setIndemniteJournee('60');
        
        $i7 = new Indemnites();
        $i7->setEtude($dspr_e2);
        $i7->setEtudiant($dupont);
        $i7->setNbJours('40');
        $i7->setRetenue('4');
        $i7->setIndemniteJournee('50');

        $i8 = new Indemnites();
        $i8->setEtude($dspr_e2);
        $i8->setEtudiant($durand);
        $i8->setNbJours('40');
        $i8->setRetenue('4');
        $i8->setIndemniteJournee('50');
        
        $manager->persist($i1);
        $manager->persist($i2);
        $manager->persist($i3);
        $manager->persist($i4);
        $manager->persist($i5);
        $manager->persist($i6);
        $manager->persist($i7);
        $manager->persist($i8);
        $manager->flush();

        $a1 = new Acompte();
        $a1->setIndemnite($i1);
        $a1->setDateAcompte(new \DateTime('2013/05/18')); 
        $a1->setMontantAcompte('300');
        $a1->setStatutAcompte('En attente');

        $a2 = new Acompte();
        $a2->setIndemnite($i2);
        $a2->setDateAcompte(new \DateTime('2013/03/13')); 
        $a2->setMontantAcompte('280.5');
        $a2->setStatutAcompte('Validé');

        $manager->persist($a1);
        $manager->persist($a2);
        $manager->flush();
    }

}