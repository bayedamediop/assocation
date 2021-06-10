<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SectionRepository::class)
 *  @ApiResource(
 *
 * collectionOperations={
 *      "post"={
 *          "method"= "POST",
 *          "path" = "/admin/section",
 *          "denormalization_context"={"groups"={"section:wreat"}},
 *      },
 *      "add_section"={
 *                  "route_name"="addSection",
 *              }
 * },
 *itemOperations={
 *
 *      "lidte_des-membre_d1_section"={
 *          "method"= "GET",
 *          "path" = "/admin/section/{id}/membres",
 *          "normalization_context"={"groups"={"section/membres:read"}},
 *      },
 *      "put"={
 *          "method"= "PUT",
 *          "path" = "/admin/membre/{id}",
 *      },
 *      },
 *     )
 */
class Section
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"section/membres:wreat"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"section:wreat"})
     */
    private $somme;



    /**
     * @ORM\OneToMany(targetEntity=Membres::class, mappedBy="section")
     *@Groups({"section/membres:read"})
     */
    private $membres;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="section")
     */
    private $users;


    public function __construct()
    {

        $this->membres = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getSomme(): ?int
    {
        return $this->somme;
    }

    public function setSomme(int $somme): self
    {
        $this->somme = $somme;

        return $this;
    }

    /**
     * @return Collection|Membres[]
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membres $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres[] = $membre;
            $membre->setSection($this);
        }

        return $this;
    }

    public function removeMembre(Membres $membre): self
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getSection() === $this) {
                $membre->setSection(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setSection($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getSection() === $this) {
                $user->setSection(null);
            }
        }

        return $this;
    }
}
