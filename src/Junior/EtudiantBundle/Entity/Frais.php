<?php

namespace Junior\EtudiantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Frais
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Junior\EtudiantBundle\Entity\FraisRepository")
 */
class Frais
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
     * @var string
     *
     * @ORM\Column(name="typeFrais", type="string", length=255)
     */
    private $typeFrais;

    /**
     * @var float
     *
     * @ORM\Column(name="montantFrais", type="float")
     */
    private $montantFrais;

    /**
     * @var string
     *
     * @ORM\Column(name="dateAchat", type="string", length=255)
     */
    private $dateAchat;


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
     * Set typeFrais
     *
     * @param string $typeFrais
     * @return Frais
     */
    public function setTypeFrais($typeFrais)
    {
        $this->typeFrais = $typeFrais;
    
        return $this;
    }

    /**
     * Get typeFrais
     *
     * @return string 
     */
    public function getTypeFrais()
    {
        return $this->typeFrais;
    }

    /**
     * Set montantFrais
     *
     * @param float $montantFrais
     * @return Frais
     */
    public function setMontantFrais($montantFrais)
    {
        $this->montantFrais = $montantFrais;
    
        return $this;
    }

    /**
     * Get montantFrais
     *
     * @return float 
     */
    public function getMontantFrais()
    {
        return $this->montantFrais;
    }

    /**
     * Set dateAchat
     *
     * @param string $dateAchat
     * @return Frais
     */
    public function setDateAchat($dateAchat)
    {
        $this->dateAchat = $dateAchat;
    
        return $this;
    }

    /**
     * Get dateAchat
     *
     * @return string 
     */
    public function getDateAchat()
    {
        return $this->dateAchat;
    }
}
