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
     * @ORM\ManyToOne(targetEntity="Junior\EtudiantBundle\Entity\Entreprise")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entreprise;
    
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
     * @ORM\Column(name="dateConvention", type="date", length=255)
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
     * @param \DateTime $dateConvention
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
     * @return \DateTime 
     */
    public function getDateConvention()
    {
        return $this->dateConvention;
    }

    /**
     * Set entreprise
     *
     * @param \Junior\EtudiantBundle\Entity\Entreprise $entreprise
     * @return Convention
     */
    public function setEntreprise(\Junior\EtudiantBundle\Entity\Entreprise $entreprise)
    {
        $this->entreprise = $entreprise;
    
        return $this;
    }

    /**
     * Get entreprise
     *
     * @return \Junior\EtudiantBundle\Entity\Entreprise 
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }
}