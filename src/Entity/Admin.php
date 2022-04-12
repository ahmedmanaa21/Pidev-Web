<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\True_;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


use Doctrine\ORM\Mapping as ORM;

/**
 * Admin
 *
 * @ORM\Table(name="admin")
 * @ORM\Entity
 */
class Admin implements UserInterface
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
     * @ORM\Column(name="nom", type="string", length=40, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(
     * min=3,
     * max=50,
     * minMessage = "le prenom de l'admin doit comporter au moins {{ limit }} caractéres",
     * maxMessage = "le prenom de l'admin doit comporter au plus {{ limit }} caractéres"
     *)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=40, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(
     * min=3,
     * max=50,
     * minMessage = "le prenom de l'admin doit comporter au moins {{ limit }} caractéres",
     * maxMessage = "le prenom de l'admin doit comporter au plus {{ limit }} caractéres"
     *)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(
     * min=3,
     * max=15,
     * minMessage = "le mot de passe de client doit comporter au moins {{ limit }}caractéres",
     * maxMessage = "le mot de passe de client doit comporter au plus {{ limit }} caractéres"
     *)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=15, nullable=false)
     * @Assert\NotBlank
     */
    private $mdp;

    /**
     * @var int
     *
     * @ORM\Column(name="numtel", type="bigint", nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(
     * min=8,
     * max=8,
     * minMessage = "le cin de client doit comporter 8 chiffres",
     * maxMessage = "le cin de client doit comporter 8 chiffres"
     *)
     */
    private $numtel;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getNumtel(): ?string
    {
        return $this->numtel;
    }

    public function setNumtel(string $numtel): self
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getRoles()
    {
        // TODO: Implement getSalt() method.
    }
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }
    public function getPassword()
    {
        return $this->mdp;
    }

}
