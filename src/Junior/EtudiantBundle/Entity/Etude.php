<?php

namespace Junior\EtudiantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etude
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Junior\EtudiantBundle\Entity\EtudeRepository")
 */
class Etude
{
    
    /**
     * @ORM\OneToOne(targetEntity="Junior\EtudiantBundle\Entity\Facture", cascade={"persist"})
     */
    private $facture;
    
    /**
     * @ORM\OneToOne(targetEntity="Junior\EtudiantBundle\Entity\Convention", cascade={"persist"})
     */
    private $convention;
    
    /**
     * @ORM\OneToMany(targetEntity="Junior\EtudiantBundle\Entity\Participant", mappedBy="etude")
     */
    private $participants;
    
    /**
     * @ORM\OneToMany(targetEntity="Junior\EtudiantBundle\Entity\Indemnites", mappedBy="etude")
     */
    private $indemnites;
    
    /**
     * @ORM\OneToMany(targetEntity="Junior\EtudiantBundle\Entity\Frais", mappedBy="etude")
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
     * @ORM\Column(name="nomEtude", type="string", length=255)
     */
    private $nomEtude;

    /**
     * @var float
     *
     * @ORM\Column(name="prixJournee", type="float")
     */
    private $prixJournee;


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
     * Set numConvention
     *
     * @param integer $numConvention
     * @return Etude
     */
    public function setNumConvention($numConvention)
    {
        $this->numConvention = $numConvention;
    
        return $this;
    }

    /**
     * Get numConvention
     *
     * @return integer 
     */
    public function getNumConvention()
    {
        return $this->numConvention;
    }

    /**
     * Set nomEtude
     *
     * @param string $nomEtude
     * @return Etude
     */
    public function setNomEtude($nomEtude)
    {
        $this->nomEtude = $nomEtude;
    
        return $this;
    }

    /**
     * Get nomEtude
     *
     * @return string 
     */
    public function getNomEtude()
    {
        return $this->nomEtude;
    }

    /**
     * Set prixJournee
     *
     * @param float $prixJournee
     * @return Etude
     */
    public function setPrixJournee($prixJournee)
    {
        $this->prixJournee = $prixJournee;
    
        return $this;
    }

    /**
     * Get prixJournee
     *
     * @return float 
     */
    public function getPrixJournee()
    {
        return $this->prixJournee;
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
     * @return Etude
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
     * Set facture
     *
     * @param \Junior\EtudiantBundle\Entity\Facture $facture
     * @return Etude
     */
    public function setFacture(\Junior\EtudiantBundle\Entity\Facture $facture = null)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \Junior\EtudiantBundle\Entity\Facture 
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Set convention
     *
     * @param \Junior\EtudiantBundle\Entity\Convention $convention
     * @return Etude
     */
    public function setConvention(\Junior\EtudiantBundle\Entity\Convention $convention = null)
    {
        $this->convention = $convention;

        return $this;
    }

    /**
     * Get convention
     *
     * @return \Junior\EtudiantBundle\Entity\Convention 
     */
    public function getConvention()
    {
        return $this->convention;
    }

    /**
     * Add frais
     *
     * @param \Junior\EtudiantBundle\Entity\Frais $frais
     * @return Etude
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
     * @return Etude
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
    
    
    public function __toString() {
        return $this->nomEtude;
    }
}