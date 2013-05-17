<?php

namespace Junior\EtudiantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Junior
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Junior\EtudiantBundle\Entity\JuniorRepository")
 */
class Junior
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
     * @ORM\Column(name="numSiret", type="string", length=255)
     */
    private $numSiret;

    /**
     * @var string
     *
     * @ORM\Column(name="nomJunior", type="string", length=255)
     */
    private $nomJunior;


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
     * Set numSiret
     *
     * @param string $numSiret
     * @return Junior
     */
    public function setNumSiret($numSiret)
    {
        $this->numSiret = $numSiret;
    
        return $this;
    }

    /**
     * Get numSiret
     *
     * @return string 
     */
    public function getNumSiret()
    {
        return $this->numSiret;
    }

    /**
     * Set nomJunior
     *
     * @param string $nomJunior
     * @return Junior
     */
    public function setNomJunior($nomJunior)
    {
        $this->nomJunior = $nomJunior;
    
        return $this;
    }

    /**
     * Get nomJunior
     *
     * @return string 
     */
    public function getNomJunior()
    {
        return $this->nomJunior;
    }
}
