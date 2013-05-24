<?php

namespace Junior\EtudiantBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\ManyToOne(targetEntity="Junior\EtudiantBundle\Entity\Indemnites", inversedBy="acomptes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $indemnite;
    
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
     * @var date
     *
     * @ORM\Column(name="dateAcompte", type="date")
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

    /**
     * Set indemnite
     *
     * @param \Junior\EtudiantBundle\Entity\Indemnites $indemnite
     * @return Acompte
     */
    public function setIndemnite(\Junior\EtudiantBundle\Entity\Indemnites $indemnite)
    {
        $this->indemnite = $indemnite;
        return $this;
    }

    /**
     * Get indemnite
     *
     * @return \Junior\EtudiantBundle\Entity\Indemnites 
     */
    public function getIndemnite()
    {
        return $this->indemnite;
    }
}
