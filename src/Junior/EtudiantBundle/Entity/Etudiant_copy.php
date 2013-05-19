<?php

namespace Junior\EtudiantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etudiant
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Junior\EtudiantBundle\Entity\EtudiantRepository")
 */
class Etudiant
{

    /**
     * @ORM\OneToMany(targetEntity="Junior\EtudiantBundle\Entity\Participant", mappedBy="etudiant")
     */
    private $participants;
    
    /**
     * @ORM\OneToMany(targetEntity="Junior\EtudiantBundle\Entity\Indemnites", mappedBy="etudiant")
     */
    private $indemnites;
    
    /**
     * @ORM\OneToMany(targetEntity="Junior\EtudiantBundle\Entity\Frais", mappedBy="etudiant")
     */
    private $frais;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="numEtudiant", type="string", length=255)
     */
    private $numEtudiant;

    /**
     * @var string
     *
     * @ORM\Column(name="nomEtudiant", type="string", length=255)
     */
    private $nomEtudiant;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseEtudiant", type="string", length=255)
     */
    private $adresseEtudiant;

    /**
     * @var integer
     *
     * @ORM\Column(name="numSecu", type="integer")
     */
    private $numSecu;

    /**
     * @var string
     *
     * @ORM\Column(name="dateNaissance", type="string", length=255)
     */
    private $dateNaissance;
    
    /**
     * @var string
     *
     * @ORM\Column(name="telEtudiant", type="string", length=10)
     */
    private $telEtudiant;


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
     * Set numEtudiant
     *
     * @param string $numEtudiant
     * @return Etudiant
     */
    public function setNumEtudiant($numEtudiant)
    {
        $this->numEtudiant = $numEtudiant;
    
        return $this;
    }

    /**
     * Get numEtudiant
     *
     * @return string 
     */
    public function getNumEtudiant()
    {
        return $this->numEtudiant;
    }

    /**
     * Set nomEtudiant
     *
     * @param string $nomEtudiant
     * @return Etudiant
     */
    public function setNomEtudiant($nomEtudiant)
    {
        $this->nomEtudiant = $nomEtudiant;
    
        return $this;
    }

    /**
     * Get nomEtudiant
     *
     * @return string 
     */
    public function getNomEtudiant()
    {
        return $this->nomEtudiant;
    }

    /**
     * Set adresseEtudiant
     *
     * @param string $adresseEtudiant
     * @return Etudiant
     */
    public function setAdresseEtudiant($adresseEtudiant)
    {
        $this->adresseEtudiant = $adresseEtudiant;
    
        return $this;
    }

    /**
     * Get adresseEtudiant
     *
     * @return string 
     */
    public function getAdresseEtudiant()
    {
        return $this->adresseEtudiant;
    }

    /**
     * Set numSecu
     *
     * @param integer $numSecu
     * @return Etudiant
     */
    public function setNumSecu($numSecu)
    {
        $this->numSecu = $numSecu;
    
        return $this;
    }

    /**
     * Get numSecu
     *
     * @return integer 
     */
    public function getNumSecu()
    {
        return $this->numSecu;
    }

    /**
     * Set dateNaissance
     *
     * @param string $dateNaissance
     * @return Etudiant
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
    
        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return string 
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->indemnites = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add indemnites
     *
     * @param \Junior\EtudiantBundle\Entity\Indemnites $indemnites
     * @return Etudiant
     */
    public function addIndemnite(\Junior\EtudiantBundle\Entity\Indemnites $indemnites)
    {
        $this->indemnites[] = $indemnites;
    
        return $this;
    }

    /**
     * Remove indemnites
     *
     * @param \Junior\EtudiantBundle\Entity\Indemnites $indemnites
     */
    public function removeIndemnite(\Junior\EtudiantBundle\Entity\Indemnites $indemnites)
    {
        $this->indemnites->removeElement($indemnites);
    }

    /**
     * Get indemnites
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndemnites()
    {
        return $this->indemnites;
    }

    /**
     * Add frais
     *
     * @param \Junior\EtudiantBundle\Entity\Frais $frais
     * @return Etudiant
     */
    public function addFrai(\Junior\EtudiantBundle\Entity\Frais $frais)
    {
        $this->frais[] = $frais;

        return $this;
    }

    /**
     * Remove frais
     *
     * @param \Junior\EtudiantBundle\Entity\Frais $frais
     */
    public function removeFrai(\Junior\EtudiantBundle\Entity\Frais $frais)
    {
        $this->frais->removeElement($frais);
    }

    /**
     * Get frais
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFrais()
    {
        return $this->frais;
    }

    /**
     * Add participants
     *
     * @param \Junior\EtudiantBundle\Entity\Participant $participants
     * @return Etudiant
     */
    public function addParticipant(\Junior\EtudiantBundle\Entity\Participant $participants)
    {
        $this->participants[] = $participants;

        return $this;
    }

    /**
     * Remove participants
     *
     * @param \Junior\EtudiantBundle\Entity\Participant $participants
     */
    public function removeParticipant(\Junior\EtudiantBundle\Entity\Participant $participants)
    {
        $this->participants->removeElement($participants);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Set telEtudiant
     *
     * @param string $telEtudiant
     * @return Etudiant
     */
    public function setTelEtudiant($telEtudiant)
    {
        $this->telEtudiant = $telEtudiant;

        return $this;
    }

    /**
     * Get telEtudiant
     *
     * @return string 
     */
    public function getTelEtudiant()
    {
        return $this->telEtudiant;
    }
}