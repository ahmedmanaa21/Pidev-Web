<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offre
 *
 * @ORM\Table(name="offre", indexes={@ORM\Index(name="ref_equipement", columns={"ref_equipement"})})
 * @ORM\Entity
 */
class Offre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_promotion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPromotion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debutpromo", type="date", nullable=false)
     */
    private $dateDebutpromo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_finpromo", type="date", nullable=false)
     */
    private $dateFinpromo;

    /**
     * @var string
     *
     * @ORM\Column(name="Pourcentagepromo", type="string", length=11, nullable=false)
     */
    private $pourcentagepromo;

    /**
     * @var \Equipement
     *
     * @ORM\ManyToOne(targetEntity="Equipement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ref_equipement", referencedColumnName="ref_equipement")
     * })
     */
    private $refEquipement;

    public function getIdPromotion(): ?int
    {
        return $this->idPromotion;
    }

    public function getDateDebutpromo(): ?\DateTimeInterface
    {
        return $this->dateDebutpromo;
    }

    public function setDateDebutpromo(\DateTimeInterface $dateDebutpromo): self
    {
        $this->dateDebutpromo = $dateDebutpromo;

        return $this;
    }

    public function getDateFinpromo(): ?\DateTimeInterface
    {
        return $this->dateFinpromo;
    }

    public function setDateFinpromo(\DateTimeInterface $dateFinpromo): self
    {
        $this->dateFinpromo = $dateFinpromo;

        return $this;
    }

    public function getPourcentagepromo(): ?string
    {
        return $this->pourcentagepromo;
    }

    public function setPourcentagepromo(string $pourcentagepromo): self
    {
        $this->pourcentagepromo = $pourcentagepromo;

        return $this;
    }

    public function getRefEquipement(): ?Equipement
    {
        return $this->refEquipement;
    }

    public function setRefEquipement(?Equipement $refEquipement): self
    {
        $this->refEquipement = $refEquipement;

        return $this;
    }


}
