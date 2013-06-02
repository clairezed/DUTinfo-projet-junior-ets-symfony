<?php

namespace Junior\EtudiantBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ParticipantRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ParticipantRepository extends EntityRepository
{
    
     public function findEtudebyEtudiant($idEtudiant) {
        $qb = $this->createQueryBuilder('p')
                ->leftJoin('e.participants', 'part')
                ->addSelect('part')
                ->leftJoin('part.etude', 'etude')
                ->addSelect('etude');
        
        $qb->where('e.id = :id')
        ->setParameter('id', $idEtudiant);
        
        return $qb;
    }
}
