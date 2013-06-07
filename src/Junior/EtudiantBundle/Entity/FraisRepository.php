<?php

namespace Junior\EtudiantBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FraisRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FraisRepository extends EntityRepository {

    public function findFraisbyIdEtudiant($idEtudiant) {

        $qb = $this->createQueryBuilder('frais')
                ->leftJoin('frais.etudiant', 'etu')
                ->addSelect('etu')
                ->leftJoin('frais.etude', 'etude')
                ->addSelect('etude');

        $qb->where('etu = :etudiant')
                ->setParameter('etudiant', $idEtudiant)
                ->orderBy('frais.dateAchat', 'DESC');

        return $qb->getQuery()
                        ->getResult();
    }

    public function findFraisByStatut($statut) {
        $qb = $this->createQueryBuilder('frais');

        $qb->where('frais.statutFrais = :statut')
                ->setParameter('statut', $statut);

        return $qb->getQuery()
                        ->getResult();
    }

    
    // Query used in GestionController - listFrais -> to show valid frais that have to be paid to student
    public function findFraisNotInRF() {
         $qb = $this->createQueryBuilder('frais');

        $qb->where('frais.remboursementsFrais is null');
        
        $qb->andWhere('frais.statutFrais = :statut')
                ->setParameter('statut', 'Validé');

        return $qb->getQuery()
                        ->getResult();
    }
    
    // Query used in ChoixEtudiantRFType
    public function findFraisNotInRF2() {
         $qb = $this->createQueryBuilder('frais');

        $qb->where('frais.remboursementsFrais is null');
        
        $qb->andWhere('frais.statutFrais = :statut')
                ->setParameter('statut', 'Validé');

        return $qb;
    }
    
     // Query used in GestionController - listFrais -> to show valid frais that have to be paid to student
    public function findFraisNotInRFbyStudent($idEtudiant) {
         $qb = $this->createQueryBuilder('frais');

        $qb->where('frais.remboursementsFrais is null');
        
        $qb->andWhere('frais.statutFrais = :statut')
                ->setParameter('statut', 'Validé');

        return $qb->getQuery()
                        ->getResult();
    }

}
