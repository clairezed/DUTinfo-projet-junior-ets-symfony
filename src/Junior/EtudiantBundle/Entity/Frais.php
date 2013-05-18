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
     * @ORM\OneToMany(targetEntity="Junior\EtudiantBundle\Entity\RemboursementFrais", mappedBy="frais")
     */
    private $remboursementsFrais;
    
    /**
     * @ORM\ManyToOne(targetEntity="Junior\EtudiantBundle\Entity\Etudiant", inversedBy="frais")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etudiant;
    
    /**
     * @ORM\ManyToOne(targetEntity="Junior\EtudiantBundle\Entity\Etude", inversedBy="frais")
     * @ORM\JoinColumn(nullable=false)
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

    /**
     * Set etudiant
     *
     * @param \Junior\EtudiantBundle\Entity\Etudiant $etudiant
     * @return Frais
     */
    public function setEtudiant(\Junior\EtudiantBundle\Entity\Etudiant $etudiant)
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * Get etudiant
     *
     * @return \Junior\EtudiantBundle\Entity\Etudiant 
     */
    public function getEtudiant()
    {
        return $this->etudiant;
    }

    /**
     * Set etude
     *
     * @param \Junior\EtudiantBundle\Entity\Etude $etude
     * @return Frais
     */
    public function setEtude(\Junior\EtudiantBundle\Entity\Etude $etude)
    {
        $this->etude = $etude;

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
     * Constructor
     */
    public function __construct()
    {
        $this->remboursementsFrais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add remboursementsFrais
     *
     * @param \Junior\EtudiantBundle\Entity\RemboursementFrais $remboursementsFrais
     * @return Frais
     */
    public function addRemboursementsFrai(\Junior\EtudiantBundle\Entity\RemboursementFrais $remboursementsFrais)
    {
        $this->remboursementsFrais[] = $remboursementsFrais;

        return $this;
    }

    /**
     * Remove remboursementsFrais
     *
     * @param \Junior\EtudiantBundle\Entity\RemboursementFrais $remboursementsFrais
     */
    public function removeRemboursementsFrai(\Junior\EtudiantBundle\Entity\RemboursementFrais $remboursementsFrais)
    {
        $this->remboursementsFrais->removeElement($remboursementsFrais);
    }

    /**
     * Get remboursementsFrais
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRemboursementsFrais()
    {
        return $this->remboursementsFrais;
    }
}
