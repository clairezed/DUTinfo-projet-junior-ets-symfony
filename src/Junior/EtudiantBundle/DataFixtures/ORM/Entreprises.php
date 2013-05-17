<?php
 
namespace Sdz\BlogBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Junior\EtudiantBundle\Entity\Entreprise;
 
class Entreprises implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
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
  }
}