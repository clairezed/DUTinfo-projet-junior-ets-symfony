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

    
    public function findFraisNotInRF() {
        
    }

}
