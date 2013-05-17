<?php
 
namespace Sdz\BlogBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Junior\EtudiantBundle\Entity\Etudiant;
 
class Etudiants implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $dupont = new Etudiant();
    $dupont->setNumEtudiant('e1');
    $dupont->setNomEtudiant('Dupont');
    $dupont->setAdresseEtudiant('8, rue de la Choucroute Farcie');
    $dupont->setNumSecu('123456');
    $dupont->setDateNaissance('13/12/1987');
      
    $durand = new Etudiant();
    $durand->setNumEtudiant('e2');
    $durand->setNomEtudiant('Durand');
    $durand->setAdresseEtudiant('12, rue du Poney Farceur');
    $durand->setNumSecu('654321');
    $durand->setDateNaissance('28/02/1983');

    $duchmol = new Etudiant();
    $duchmol->setNumEtudiant('e3');
    $duchmol->setNomEtudiant('Duchmol');
    $duchmol->setAdresseEtudiant('16, rue de la Belette Farceuse');
    $duchmol->setNumSecu('987654');
    $duchmol->setDateNaissance('24/04/1982');
    
    $dugland = new Etudiant();
    $dugland->setNumEtudiant('e4');
    $dugland->setNomEtudiant('Dugland');
    $dugland->setAdresseEtudiant('20, rue de l\'Hippocampe Hilare');
    $dugland->setNumSecu('456789');
    $dugland->setDateNaissance('05/09/1986');                 
 
    $manager->persist($duchmol);
    $manager->persist($dugland);
    $manager->persist($dupont);
    $manager->persist($durand);
    
    $manager->flush();
  }
}