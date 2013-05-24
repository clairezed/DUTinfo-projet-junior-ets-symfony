<?php

namespace Junior\EtudiantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RemboursementFrais
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Junior\EtudiantBundle\Entity\RemboursementFraisRepository")
 */
class RemboursementFrais
{
    
    /**
     * @ORM\ManyToOne(targetEntity="Junior\EtudiantBundle\Entity\Frais", inversedBy="remboursementsFrais")
     * @ORM\JoinColumn(nullable=false)
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
     * @ORM\Column(name="dateRemboursement", type="string", length=255)
     */
    private $dateRemboursement;


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
     * Set dateRemboursement
     *
     * @param string $dateRemboursement
     * @return RemboursementFrais
     */
    public function setDateRemboursement($dateRemboursement)
    {
        $this->dateRemboursement = $dateRemboursement;
    
        return $this;
    }

    /**
     * Get dateRemboursement
     *
     * @return string 
     */
    public function getDateRemboursement()
    {
        return $this->dateRemboursement;
    }

    /**
     * Set frais
     *
     * @param \Junior\EtudiantBundle\Entity\Frais $frais
     * @return RemboursementFrais
     */
    public function setFrais(\Junior\EtudiantBundle\Entity\Frais $frais)
    {
        $this->frais = $frais;

        return $this;
    }

    /**
     * Get frais
     *
     * @return \Junior\EtudiantBundle\Entity\Frais 
     */
    public function getFrais()
    {
        return $this->frais;
    }
    
    public function getNbFrais()
    {
        
    }
    
    public function getMontantTotal()
    {
        
    }
    
}
