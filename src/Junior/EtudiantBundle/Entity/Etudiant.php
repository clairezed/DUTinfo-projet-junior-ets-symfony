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
     * @ORM\OneToMany(targetEntity="Junior\EtudiantBundle\Entity\Indemnites", mappedBy="etudiant")
     */
    private $indemnites;
    
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
}