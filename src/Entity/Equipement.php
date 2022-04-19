<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use App\Repository\EquipementRepository;

/**
 * @ORM\Table(name="equipement")
 * @ORM\Entity(repositoryClass=EquipementRepository::class)
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
     *@Assert\NotBlank
     * @ORM\Column(name="nom_equipement", type="string", length=255, nullable=false)
     *      * @Assert\Length(
     * min=3,
     * max=50,
     * minMessage = "le nom doit comporter au moins {{ limit }} caractéres",
     * maxMessage = "le prenom  doit comporter au plus {{ limit }} caractéres"
     *)
     */
    private $nomEquipement;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;
 /**
     * @Assert\File(maxSize="500000000k")
     */
    public  $file;


    public function getWebpath(){


        return null === $this->image ? null : $this->getUploadDir().'/'.$this->image;
    }
    protected  function  getUploadRootDir(){

        return __DIR__.'/../../../public/Upload'.$this->getUploadDir();
    }
    protected function getUploadDir(){

        return'';
    }
    public function getUploadFile(){
        if (null === $this->getFile()) {
            $this->image = "3.jpg";
            return;
        }


        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()

        );

        // set the path property to the filename where you've saved the file
        $this->image = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }





    /**
     * @var float
     *@Assert\NotBlank
     * @ORM\Column(name="prix_equipement", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixEquipement;

    /**
     * @var string
     *
     * @ORM\Column(name="description_equipement", type="text", length=65535, nullable=false)
     * * @Assert\NotBlank(message = "Ce champ est requis")
     * @Assert\Length(
     *      min = 20,
     *      max = 200,
     *      minMessage = "La description doit avoir au minimum {{ limit }} lettres",
     *      maxMessage = "La description doit avoir au maximum {{ limit }} lettres"
     * )
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
    public function __toString(){
        $ref=strval($this->refEquipement);
        return $ref;
    }
    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }
   
}
