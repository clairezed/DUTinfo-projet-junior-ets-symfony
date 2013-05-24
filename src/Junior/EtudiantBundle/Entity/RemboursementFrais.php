<?php

namespace Junior\EtudiantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RemboursementFrais
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Junior\EtudiantBundle\Entity\RemboursementFraisRepository")
 */
class RemboursementFrais {

    /**
     * @ORM\OneToMany(targetEntity="Junior\EtudiantBundle\Entity\Frais", mappedBy="remboursementsFrais", cascade={"persist"})
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
     * @var date
     *
     * @ORM\Column(name="dateRemboursement", type="date")
     */
    private $dateRemboursement;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->frais = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * @param \DateTime $dateRemboursement
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
     * @return \DateTime 
     */
    public function getDateRemboursement()
    {
        return $this->dateRemboursement;
    }

    /**
     * Add frais
     *
     * @param \Junior\EtudiantBundle\Entity\Frais $frais
     * @return RemboursementFrais
     */
    public function addFrai(\Junior\EtudiantBundle\Entity\Frais $frais)
    {
        $this->frais[] = $frais;
    
        return $this;
    }

    /**
     * Remove frais
     *
     * @param \Junior\EtudiantBundle\Entity\Frais $frais
     */
    public function removeFrai(\Junior\EtudiantBundle\Entity\Frais $frais)
    {
        $this->frais->removeElement($frais);
    }

    /**
     * Get frais
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFrais()
    {
        return $this->frais;
    }
    
    
    
    
    public function __toString() {
        return "'+$this->id+'";
    }
    

    public function getMontantTotal() {
        $listFrais = $this->frais;
        $total = 0;
        foreach ($listFrais as $frais) {
            $total+=$frais->getMontantFrais();
        }

        return $total;
    }
    
    
}