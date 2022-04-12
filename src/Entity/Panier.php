<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier", indexes={@ORM\Index(name="eq", columns={"ref_equipement"}), @ORM\Index(name="eu", columns={"Cin"})})
 * @ORM\Entity
 */
class Panier
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_panier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPanier;

    /**
     * @var float
     *
     * @ORM\Column(name="total_panier", type="float", precision=10, scale=0, nullable=false)
     */
    private $totalPanier;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_equipement", type="integer", nullable=false)
     */
    private $nbrEquipement;

    /**
     * @var int
     *
     * @ORM\Column(name="prix_equipement", type="integer", nullable=false)
     */
    private $prixEquipement;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Cin", referencedColumnName="cin")
     * })
     */
    private $cin;

    /**
     * @var \Equipement
     *
     * @ORM\ManyToOne(targetEntity="Equipement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ref_equipement", referencedColumnName="ref_equipement")
     * })
     */
    private $refEquipement;

    public function getIdPanier(): ?int
    {
        return $this->idPanier;
    }

    public function getTotalPanier(): ?float
    {
        return $this->totalPanier;
    }

    public function setTotalPanier(float $totalPanier): self
    {
        $this->totalPanier = $totalPanier;

        return $this;
    }

    public function getNbrEquipement(): ?int
    {
        return $this->nbrEquipement;
    }

    public function setNbrEquipement(int $nbrEquipement): self
    {
        $this->nbrEquipement = $nbrEquipement;

        return $this;
    }

    public function getPrixEquipement(): ?int
    {
        return $this->prixEquipement;
    }

    public function setPrixEquipement(int $prixEquipement): self
    {
        $this->prixEquipement = $prixEquipement;

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
