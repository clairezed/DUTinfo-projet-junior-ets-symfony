<?php
 
namespace Sdz\BlogBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Junior\EtudiantBundle\Entity\Frais;
 
class Frais2 implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $f1 = new Frais();
    $f1->setTypeFrais('Materiel de laboratoire');
    $f1->setMontantFrais('2000');
    $f1->setDateAchat('25/04/2013');
            
    $f2 = new Frais();
    $f2->setTypeFrais('Nourriture galactique standard');
    $f2->setMontantFrais('32');
    $f2->setDateAchat('22/03/2013');
    
    $f3 = new Frais();
    $f3->setTypeFrais('Transport Hyperluminique');
    $f3->setMontantFrais('12500');
    $f3->setDateAchat('03/05/2013');
            
    $manager->persist($f1);
    $manager->persist($f2);
    $manager->persist($f3);
    
    $manager->flush();
  }
}