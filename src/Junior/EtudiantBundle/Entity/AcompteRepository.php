<?php

namespace Junior\EtudiantBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AcompteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AcompteRepository extends EntityRepository
{
    public function findAcomptebyIdEtudiant($idEtudiant) {
        
        $qb = $this->createQueryBuilder('acompte')
                ->leftJoin('acompte.indemnite', 'indem')
                ->addSelect('indem')
                ->leftJoin('indem.etudiant', 'etu')
                ->addSelect('etu');

        $qb->where('etu = :etudiant')
                ->setParameter('etudiant', $idEtudiant)
                ->orderBy('acompte.dateAcompte', 'DESC');

        return $qb->getQuery()
                        ->getResult();
    }
    
    
}
