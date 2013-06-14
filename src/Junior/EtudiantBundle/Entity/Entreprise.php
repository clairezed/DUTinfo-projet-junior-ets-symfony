<?php

namespace Junior\EtudiantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entreprise
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Junior\EtudiantBundle\Entity\EntrepriseRepository")
 */
class Entreprise
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\OneToMany(targetEntity="Junior\EtudiantBundle\Entity\Convention", mappedBy="entreprise")
     */
    private $convention;

    /**
     * @var string
     *
     * @ORM\Column(name="nomEntreprise", type="string", length=255)
     */
    private $nomEntreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseEntreprise", type="string", length=255)
     */
    private $adresseEntreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="telEntreprise", type="string", length=10)
     */
    private $telEntreprise;


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
     * Set numEntreprise
     *
     * @param integer $numEntreprise
     * @return Entreprise
     */
    public function setNumEntreprise($numEntreprise)
    {
        $this->numEntreprise = $numEntreprise;
    
        return $this;
    }

    /**
     * Get numEntreprise
     *
     * @return integer 
     */
    public function getNumEntreprise()
    {
        return $this->numEntreprise;
    }

    /**
     * Set nomEntreprise
     *
     * @param string $nomEntreprise
     * @return Entreprise
     */
    public function setNomEntreprise($nomEntreprise)
    {
        $this->nomEntreprise = $nomEntreprise;
    
        return $this;
    }

    /**
     * Get nomEntreprise
     *
     * @return string 
     */
    public function getNomEntreprise()
    {
        return $this->nomEntreprise;
    }

    /**
     * Set adresseEntreprise
     *
     * @param string $adresseEntreprise
     * @return Entreprise
     */
    public function setAdresseEntreprise($adresseEntreprise)
    {
        $this->adresseEntreprise = $adresseEntreprise;
    
        return $this;
    }

    /**
     * Get adresseEntreprise
     *
     * @return string 
     */
    public function getAdresseEntreprise()
    {
        return $this->adresseEntreprise;
    }

    /**
     * Set telEntreprise
     *
     * @param integer $telEntreprise
     * @return Entreprise
     */
    public function setTelEntreprise($telEntreprise)
    {
        $this->telEntreprise = $telEntreprise;
    
        return $this;
    }

    /**
     * Get telEntreprise
     *
     * @return integer 
     */
    public function getTelEntreprise()
    {
        return $this->telEntreprise;
    }

    /**
     * Set convention
     *
     * @param \Junior\EtudiantBundle\Entity\Convention $convention
     * @return Entreprise
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
     * Constructor
     */
    public function __construct()
    {
        $this->convention = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add convention
     *
     * @param \Junior\EtudiantBundle\Entity\Convention $convention
     * @return Entreprise
     */
    public function addConvention(\Junior\EtudiantBundle\Entity\Convention $convention)
    {
        $this->convention[] = $convention;

        return $this;
    }

    /**
     * Remove convention
     *
     * @param \Junior\EtudiantBundle\Entity\Convention $convention
     */
    public function removeConvention(\Junior\EtudiantBundle\Entity\Convention $convention)
    {
        $this->convention->removeElement($convention);
    }
}
