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
}
