<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MembresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MembresRepository::class)
 *  @ApiResource(
 *
 * collectionOperations={
 *      "post"={
 *          "method"= "POST",
 *          "path" = "/admin/section",
 *          "denormalization_context"={"groups"={"section:wreat"}},
 *      },
 *      "add_membre"={
 *                  "route_name"="addMembre",
 *              },
 *     "lidte_des-membres"={
 *          "method"= "GET",
 *          "path" = "/admin/membre",
 *          "normalization_context"={"groups"={"membres:read"}},
 *      },
 * },
 *     itemOperations={
 *
 *      "get_membre_by_id"={
 *          "method"= "GET",
 *          "path" = "/admin/membre/{id}",
 *          "normalization_context"={"groups"={"membres:read"}},
 *      },
 *     "put"={
 *          "method"= "PUT",
 *          "path" = "/admin/membre/{id}",
 *      },
 *      "recherche_membre"={
 *                  "route_name"="rechercheMembre",
 *
 *              },
 *      },

 *     )
 */
class Membres
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"section/membres:read","membres:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"section/membres:read","membres:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"section/membres:read","membres:read"})
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=Cotiser::class, mappedBy="membre")
     */
    private $cotisers;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"section/membres:read"})
     */
    private $matricule;

    /**
     * @ORM\ManyToOne(targetEntity=Section::class, inversedBy="membres")
     */
    private $section;

    public function __construct()
    {
        $this->cotisers = new ArrayCollection();
    }

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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|Cotiser[]
     */
    public function getCotisers(): Collection
    {
        return $this->cotisers;
    }

    public function addCotiser(Cotiser $cotiser): self
    {
        if (!$this->cotisers->contains($cotiser)) {
            $this->cotisers[] = $cotiser;
            $cotiser->setMembre($this);
        }

        return $this;
    }

    public function removeCotiser(Cotiser $cotiser): self
    {
        if ($this->cotisers->removeElement($cotiser)) {
            // set the owning side to null (unless already changed)
            if ($cotiser->getMembre() === $this) {
                $cotiser->setMembre(null);
            }
        }

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }
}
