<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_cmd", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCmd;

     /**
      * @var string

     * @Assert\NotBlank(message="nom doit etre non vide")
     * @Assert\Length(
     *      min = 7,
     *      max = 100,
     *      minMessage = "doit etre >=7 ",
     *      maxMessage = "doit etre <=100" )
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;



    /**
     * @var string
     *
     * @Assert\NotBlank(message="nom doit etre non vide")
     *  @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     *  @Assert\Length(
     * min = 2,
     * max = 50,
     * minMessage = "doit etre >=3",
     * maxMessage = "doit etre <=100"
     * )
     */
    private $prenom;

      /**
       * @var int
    
     * @ORM\Column(name="num_tel", type="integer", nullable=false)
     *  @Assert\NotBlank(message="nom doit etre non vide")
     */
    private $numTel;

    /**
     * @var int
     * @Assert\NotBlank(message="nom doit etre non vide")
     * @ORM\Column(name="codepostal", type="integer", nullable=false)
     
     * 
     */
    private $codepostal;

    /**
     * @var string
     * @Assert\NotBlank(message="nom doit etre non vide")
     * @ORM\Column(name="Etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var string
     * @Assert\NotBlank(message="nom doit etre non vide")
     * @ORM\Column(name="adressmail", type="string", length=255, nullable=false)
     * 
     */
    private $adressmail;

    /**
     * @var string
     * @Assert\NotBlank(message="nom doit etre non vide")
     * @ORM\Column(name="mode_paiment", type="string", length=255, nullable=false)
     * 
     */
    private $modePaiment;

    public function getIdCmd(): ?int
    {
        return $this->idCmd;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumTel(): ?int
    {
        return $this->numTel;
    }

    public function setNumTel(int $numTel): self
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getCodepostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodepostal(int $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getAdressmail(): ?string
    {
        return $this->adressmail;
    }

    public function setAdressmail(string $adressmail): self
    {
        $this->adressmail = $adressmail;

        return $this;
    }

    public function getModePaiment(): ?string
    {
        return $this->modePaiment;
    }

    public function setModePaiment(string $modePaiment): self
    {
        $this->modePaiment = $modePaiment;

        return $this;
    }

 

}

