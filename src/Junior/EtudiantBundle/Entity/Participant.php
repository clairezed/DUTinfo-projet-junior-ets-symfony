<?php

namespace Junior\EtudiantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participant
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Junior\EtudiantBundle\Entity\ParticipantRepository")
 */
class Participant
{
//    /**
//     * @var integer
//     *
//     * @ORM\Column(name="id", type="integer")
//     * @ORM\Id
//     * @ORM\GeneratedValue(strategy="AUTO")
//     */
//    private $id;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Junior\EtudiantBundle\Entity\Etudiant", inversedBy="participants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etudiant;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Junior\EtudiantBundle\Entity\Etude", inversedBy="participants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etude;

    /**
     * @var string
     *
     * @ORM\Column(name="statutEtudiant", type="string", length=255)
     */
    private $statutEtudiant;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set statutEtudiant
     *
     * @param string $statutEtudiant
     * @return Participant
     */
    public function setStatutEtudiant($statutEtudiant)
    {
        $this->statutEtudiant = $statutEtudiant;

        return $this;
    }

    /**
     * Get statutEtudiant
     *
     * @return string 
     */
    public function getStatutEtudiant()
    {
        return $this->statutEtudiant;
    }

    /**
     * Set etudiant
     *
     * @param \Junior\EtudiantBundle\Entity\Etudiant $etudiant
     * @return Participant
     */
    public function setEtudiant(\Junior\EtudiantBundle\Entity\Etudiant $etudiant)
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * Get etudiant
     *
     * @return \Junior\EtudiantBundle\Entity\Etudiant 
     */
    public function getEtudiant()
    {
        return $this->etudiant;
    }

    /**
     * Set etude
     *
     * @param \Junior\EtudiantBundle\Entity\Etude $etude
     * @return Participant
     */
    public function setEtude(\Junior\EtudiantBundle\Entity\Etude $etude)
    {
        $this->etude = $etude;

        return $this;
    }

    /**
     * Get etude
     *
     * @return \Junior\EtudiantBundle\Entity\Etude 
     */
    public function getEtude()
    {
        return $this->etude;
    }
}
