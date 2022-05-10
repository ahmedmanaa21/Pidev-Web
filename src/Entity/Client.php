<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\True_;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email !")
 */
class Client implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="cin", type="bigint", nullable=false)
     * @ORM\Id
     * @Assert\NotBlank
     * @Assert\Length(
     * min=8,
     * max=8,
     * minMessage = "le cin de client doit comporter 8 chiffres",
     * maxMessage = "le cin de client doit comporter 8 chiffres"
     *)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="nomPrenom", type="string", length=30, nullable=false )
     * @Assert\NotBlank
     * @Assert\Regex(
     * pattern = "/^([a-zA-Z' ]+)$/",
     * htmlPattern = "[a-zA-Z'-'\s]*"
     * )
     */
    private $nomprenom;

    /**
     * @var string
     *
     * @ORM\Column(name="surnom", type="string", length=11, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(
     * min=3,
     * max=50,
     * minMessage = "le surnom de client doit comporter au moins {{ limit }}caractéres",
     * maxMessage = "le surnom de client doit comporter au plus {{ limit }} caractéres"
     *)
     */
    private $surnom;

    /**
     * @var string
     *
     * @ORM\Column(name="Sexe", type="string", length=5, nullable=false)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=40, nullable=false)
     * @Assert\Email(
     *     message = "L'e-mail '{{ value }}' n'est pas un e-mail valide.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=255, nullable=false )
     *
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date", nullable=false)
     * @Assert\NotBlank
     * @Assert\LessThanOrEqual("-18 years",message = "You have to be 18 years or older")
     */
    private $datenaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=11, nullable=false)
     * @Assert\NotBlank
     *
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=1000, nullable=false)
     *
     * 
     */
    private $image;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    protected $captchaCode;

    public function getCin(): ?string
    {
        return $this->cin;
    }
    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getNomprenom(): ?string
    {
        return $this->nomprenom;
    }

    public function setNomprenom(string $nomprenom): self
    {
        $this->nomprenom = $nomprenom;

        return $this;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getSurnom(): ?string
    {
        return $this->surnom;
    }

    public function setSurnom(string $surnom): self
    {
        $this->surnom = $surnom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

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


    public function getDatenaissance(): ?\DateTimeInterface
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(\DateTimeInterface $datenaissance): self
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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


    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername()
    {
        return $this->surnom;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    public function getCaptchaCode()
    {
        return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
        $this->captchaCode = $captchaCode;
    }
    public function __toString() {
        return (string) $this->getCin();

    }
}
