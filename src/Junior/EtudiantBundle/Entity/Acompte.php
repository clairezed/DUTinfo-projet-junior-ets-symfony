<?php

namespace Junior\EtudiantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acompte
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Junior\EtudiantBundle\Entity\AcompteRepository")
 */
class Acompte
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
     * @var float
     *
     * @ORM\Column(name="montantAcompte", type="float")
     */
    private $montantAcompte;

    /**
     * @var string
     *
     * @ORM\Column(name="dateAcompte", type="string", length=255)
     */
    private $dateAcompte;


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
     * Set montantAcompte
     *
     * @param float $montantAcompte
     * @return Acompte
     */
    public function setMontantAcompte($montantAcompte)
    {
        $this->montantAcompte = $montantAcompte;
    
        return $this;
    }

    /**
     * Get montantAcompte
     *
     * @return float 
     */
    public function getMontantAcompte()
    {
        return $this->montantAcompte;
    }

    /**
     * Set dateAcompte
     *
     * @param string $dateAcompte
     * @return Acompte
     */
    public function setDateAcompte($dateAcompte)
    {
        $this->dateAcompte = $dateAcompte;
    
        return $this;
    }

    /**
     * Get dateAcompte
     *
     * @return string 
     */
    public function getDateAcompte()
    {
        return $this->dateAcompte;
    }
}
