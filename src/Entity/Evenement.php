<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity
 */

class Evenement
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     * @Assert\Length(
     * min=3,
     * max=50,
     * minMessage = "le nom de client doit comporter au moins {{ limit }}caractéres",
     * maxMessage = "le nom de client doit comporter au plus {{ limit }} caractéres"
     * )
     */
    private $nom;

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

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_deb", type="date", nullable=false)
     * @Assert\Date()
     * @Assert\GreaterThan("today")
     */
    private $dateDeb;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     * @Assert\Date()
     * @Assert\Expression(
     *     "this.getDateDeb() < this.getDateFin()",
     *     message="La date fin ne doit pas être antérieure à la date début"
     * )
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=1000, nullable=false)
     */
    private $image;

    /**
     * @param int $id
     * @param string $nom
     * @param string $description
     * @param \DateTime $dateDeb
     * @param \DateTime $dateFin
     * @param string $image
     */

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDeb(): ?\DateTimeInterface
    {
        return $this->dateDeb;
    }

    public function setDateDeb(\DateTimeInterface $dateDeb): self
    {
        $this->dateDeb = $dateDeb;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

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



}
