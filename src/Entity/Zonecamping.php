<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255, nullable=false)
     * @Assert\Length(
     * min=3,
     * max=50,
     * minMessage = "la region doit comporter au moins {{ limit }}caractéres",
     * maxMessage = "la region de client doit comporter au plus {{ limit }} caractéres"
     * )
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="delegation", type="string", length=255, nullable=false)
     * @Assert\Length(
     * min=3,
     * max=50,
     * minMessage = "la delegation doit comporter au moins {{ limit }}caractéres",
     * maxMessage = "la delegation doit comporter au plus {{ limit }} caractéres"
     * )
     */
    private $delegation;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_centre", type="string", length=255, nullable=false)
     * @Assert\Length(
     * min=3,
     * max=50,
     * minMessage = "le nom_centre doit comporter au moins {{ limit }}caractéres",
     * maxMessage = "le nom_centre doit comporter au plus {{ limit }} caractéres"
     * )
     */
    private $nomCentre;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=false)
     *@Assert\NotBlank(message="Number is required")
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=false)
     * @Assert\NotBlank(message="Number is required")
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     * @Assert\Length(
     * min=3,
     * max=50,
     * minMessage = "la description doit comporter au moins {{ limit }}caractéres",
     * maxMessage = "la description doit comporter au plus {{ limit }} caractéres"
     * )
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDelegation(): ?string
    {
        return $this->delegation;
    }

    public function setDelegation(string $delegation): self
    {
        $this->delegation = $delegation;

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

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


}
