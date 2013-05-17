<?php

namespace Junior\EtudiantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Convention
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Junior\EtudiantBundle\Entity\ConventionRepository")
 */
class Convention
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
     * @ORM\Column(name="dateConvention", type="string", length=255)
     */
    private $dateConvention;


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
     * Set dateConvention
     *
     * @param string $dateConvention
     * @return Convention
     */
    public function setDateConvention($dateConvention)
    {
        $this->dateConvention = $dateConvention;
    
        return $this;
    }

    /**
     * Get dateConvention
     *
     * @return string 
     */
    public function getDateConvention()
    {
        return $this->dateConvention;
    }
}