<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipement
 *
 * @ORM\Table(name="equipement")
 * @ORM\Entity
 */
class Equipement
{
    /**
     * @var int
     *
     * @ORM\Column(name="ref_equipement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $refEquipement;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_equipement", type="string", length=255, nullable=false)
     */
    private $nomEquipement;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_equipement", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixEquipement;

    /**
     * @var string
     *
     * @ORM\Column(name="description_equipement", type="text", length=65535, nullable=false)
     */
    private $descriptionEquipement;

    public function getRefEquipement(): ?int
    {
        return $this->refEquipement;
    }

    public function getNomEquipement(): ?string
    {
        return $this->nomEquipement;
    }

    public function setNomEquipement(string $nomEquipement): self
    {
        $this->nomEquipement = $nomEquipement;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrixEquipement(): ?float
    {
        return $this->prixEquipement;
    }

    public function setPrixEquipement(float $prixEquipement): self
    {
        $this->prixEquipement = $prixEquipement;

        return $this;
    }

    public function getDescriptionEquipement(): ?string
    {
        return $this->descriptionEquipement;
    }

    public function setDescriptionEquipement(string $descriptionEquipement): self
    {
        $this->descriptionEquipement = $descriptionEquipement;

        return $this;
    }


}
