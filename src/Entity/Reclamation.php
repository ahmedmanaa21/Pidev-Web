<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="FK_rec_cin", columns={"cin"})})
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_rec", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRec;

    /**
     * @var string
     *
     * @ORM\Column(name="type_rec", type="string", length=255, nullable=false)
     */
    private $typeRec;

    /**
     * @var string

     *
     * @ORM\Column(name="description_rec", type="text", length=65535, nullable=false)
     * @Assert\Length(
     * min=10,
     * max=100,
     * minMessage = "la description doit comporter au moins {{ limit }}caractéres",
     * maxMessage = "la description doit comporter au plus {{ limit }} caractéres"
     * )
     */
    private $descriptionRec;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_rec", type="date", nullable=false, options={"default"="current_timestamp()"})
     */
    private $dateRec;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cin", referencedColumnName="cin")
     * })
     */
    private $cin;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="archived", type="boolean", nullable=true)
     */
    private $archived = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="screenshot", type="string", length=500, nullable=false)
     */
    private $screenshot;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    public function getIdRec(): ?int
    {
        return $this->idRec;
    }

    public function getTypeRec(): ?string
    {
        return $this->typeRec;
    }

    public function setTypeRec(string $typeRec): self
    {
        $this->typeRec = $typeRec;

        return $this;
    }

    public function getDescriptionRec(): ?string
    {
        return $this->descriptionRec;
    }

    public function setDescriptionRec(string $descriptionRec): self
    {
        $this->descriptionRec = $descriptionRec;

        return $this;
    }

    public function getDateRec(): ?\DateTimeInterface
    {
        return $this->dateRec;
    }

    public function setDateRec(?\DateTimeInterface $dateRec): self
    {
        $this->dateRec = $dateRec;

        return $this;
    }

    public function getCin(): ?Client
    {
        return $this->cin;
    }

    public function setCin(?Client $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(?bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    public function getScreenshot(): ?string
    {
        return $this->screenshot;
    }

    public function setScreenshot(string $screenshot): self
    {
        $this->screenshot = $screenshot;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


}
