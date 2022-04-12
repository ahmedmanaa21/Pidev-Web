<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zonecamping
 *
 * @ORM\Table(name="zonecamping")
 * @ORM\Entity
 */
class Zonecamping
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_zoneCamping", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idZonecamping;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255, nullable=false)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_centre", type="string", length=255, nullable=false)
     */
    private $nomCentre;

    /**
     * @var string
     *
     * @ORM\Column(name="elegation", type="string", length=255, nullable=false)
     */
    private $elegation;

    /**
     * @var string
     *
     * @ORM\Column(name="description_camping", type="text", length=65535, nullable=false)
     */
    private $descriptionCamping;

    public function getIdZonecamping(): ?int
    {
        return $this->idZonecamping;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getNomCentre(): ?string
    {
        return $this->nomCentre;
    }

    public function setNomCentre(string $nomCentre): self
    {
        $this->nomCentre = $nomCentre;

        return $this;
    }

    public function getElegation(): ?string
    {
        return $this->elegation;
    }

    public function setElegation(string $elegation): self
    {
        $this->elegation = $elegation;

        return $this;
    }

    public function getDescriptionCamping(): ?string
    {
        return $this->descriptionCamping;
    }

    public function setDescriptionCamping(string $descriptionCamping): self
    {
        $this->descriptionCamping = $descriptionCamping;

        return $this;
    }
    public function __toString() {
        return (string) $this->getIdZonecamping();

    }
}
