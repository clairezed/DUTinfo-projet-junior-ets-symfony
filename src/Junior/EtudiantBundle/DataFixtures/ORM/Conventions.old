<?php
 
namespace Sdz\BlogBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Junior\EtudiantBundle\Entity\Convention;
 
class Conventions implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $dspr = new Convention();
    $dspr->setDateConvention('23/03/2013');

    $uc = new Convention();
    $uc->setDateConvention('08/11/2012');
            
    $manager->persist($dspr);
    $manager->persist($uc);
    
    $manager->flush();
  }
}