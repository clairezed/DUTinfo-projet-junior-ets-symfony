<?php

namespace Junior\EtudiantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Junior\EtudiantBundle\Entity\FactureRepository")
 */
class Facture
{
    
    /**
     * @ORM\OneToOne(targetEntity="Junior\EtudiantBundle\Entity\Etude", inversedBy="facture")
     */
    private $etude;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var date
     *
     * @ORM\Column(name="dateFacture", type="date")
     */
    private $dateFacture;
    
    /**
     * @var float
     *
     * @ORM\Column(name="montantHT", type="float")
     */
    private $montantHT;
    
    /**
     * @var float
     *
     * @ORM\Column(name="montantTTC", type="float")
     */
    private $montantTTC;
    
    /**
     * @var float
     *
     * @ORM\Column(name="montantTVA", type="float")
     */
    private $montantTVA;
    
    /**
     * @var float
     *
     * @ORM\Column(name="coutEtude", type="float")
     */
    private $coutEtude;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function __construct()
    {
        $this->dateFacture = new \Datetime();
    }

   

    /**
     * Set dateFacture
     *
     * @param \DateTime $dateFacture
     * @return Facture
     */
    public function setDateFacture($dateFacture)
    {
        $this->dateFacture = $dateFacture;
    
        return $this;
    }

    /**
     * Get dateFacture
     *
     * @return \DateTime 
     */
    public function getDateFacture()
    {
        return $this->dateFacture;
    }

    /**
     * Set etude
     *
     * @param \Junior\EtudiantBundle\Entity\Etude $etude
     * @return Facture
     */
    public function setEtude(\Junior\EtudiantBundle\Entity\Etude $etude = null)
    {
        $this->etude = $etude;
        $etude->setFacture($this);
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

    /**
     * Set montantHT
     *
     * @param float $montantHT
     * @return Facture
     */
    public function setMontantHT($montantHT)
    {
        $this->montantHT = $montantHT;

        return $this;
    }

    /**
     * Get montantHT
     *
     * @return float 
     */
    public function getMontantHT()
    {
        return $this->montantHT;
    }

    /**
     * Set montantTTC
     *
     * @param float $montantTTC
     * @return Facture
     */
    public function setMontantTTC($montantTTC)
    {
        $this->montantTTC = $montantTTC;

        return $this;
    }

    /**
     * Get montantTTC
     *
     * @return float 
     */
    public function getMontantTTC()
    {
        return $this->montantTTC;
    }

    /**
     * Set montantTVA
     *
     * @param float $montantTVA
     * @return Facture
     */
    public function setMontantTVA($montantTVA)
    {
        $this->montantTVA = $montantTVA;

        return $this;
    }

    /**
     * Get montantTVA
     *
     * @return float 
     */
    public function getMontantTVA()
    {
        return $this->montantTVA;
    }

    /**
     * Set coutEtude
     *
     * @param float $coutEtude
     * @return Facture
     */
    public function setCoutEtude($coutEtude)
    {
        $this->coutEtude = $coutEtude;

        return $this;
    }

    /**
     * Get coutEtude
     *
     * @return float 
     */
    public function getCoutEtude()
    {
        return $this->coutEtude;
    }
}
