<?php
 
namespace Sdz\BlogBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Junior\EtudiantBundle\Entity\RemboursementFrais;
 
class Remboursements implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $f1 = new RemboursementFrais();
    $f1->setDateRemboursement('27/04/2013');
            
    $f2 = new RemboursementFrais();
    $f2->setDateRemboursement('28/03/2013');
    
    $f3 = new RemboursementFrais();
    $f3->setDateRemboursement('06/05/2013');
            
    $manager->persist($f1);
    $manager->persist($f2);
    $manager->persist($f3);
    
    $manager->flush();
  }
}