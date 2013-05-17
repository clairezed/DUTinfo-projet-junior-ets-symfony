<?php
 
namespace Sdz\BlogBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Junior\EtudiantBundle\Entity\Etude;
 
class Etudes implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $dspr = new Etude();
    $dspr->setNomEtude('La réception de la politique familiale impériale dans les mondes de la Bordure Extérieure');
    $dspr->setPrixJournee('150');

    $uc = new Etude();
    $uc->setNomEtude('Projection prévisionnelle de propagation d\'un virus mutagène');
    $uc->setPrixJournee('210.5');
 
    $manager->persist($dspr);
    $manager->persist($uc);
    
    $manager->flush();
  }
}