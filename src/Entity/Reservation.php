<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="FK_rec_zoneC", columns={"id_zoneCamping"})})
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_reservation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReservation;

    /**
     * @var int
     *
     * @ORM\Column(name="cin", type="bigint", nullable=false)
     */
    private $cin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reservation", type="date", nullable=false)
     */
    private $dateReservation;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrPersonne", type="integer", nullable=false)
     */
    private $nbrpersonne;

    /**
     * @var \Zonecamping
     *
     * @ORM\ManyToOne(targetEntity="Zonecamping")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_zoneCamping", referencedColumnName="id")
     * })
     */
    private $idZonecamping;

    public function getIdReservation(): ?int
    {
        return $this->idReservation;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(\DateTimeInterface $dateReservation): self
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    public function getNbrpersonne(): ?int
    {
        return $this->nbrpersonne;
    }

    public function setNbrpersonne(int $nbrpersonne): self
    {
        $this->nbrpersonne = $nbrpersonne;

        return $this;
    }

    public function getIdZonecamping(): ?Zonecamping
    {
        return $this->idZonecamping;
    }

    public function setIdZonecamping(?Zonecamping $idZonecamping): self
    {
        $this->idZonecamping = $idZonecamping;

        return $this;
    }


}
