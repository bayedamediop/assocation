<?php

namespace App\Entity;

use App\Repository\CotiserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CotiserRepository::class)
 */
class Cotiser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $somme;

    /**
     * @ORM\ManyToOne(targetEntity=Membres::class, inversedBy="cotisers")
     */
    private $membre;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMembre(): ?Membres
    {
        return $this->membre;
    }

    public function setMembre(?Membres $membre): self
    {
        $this->membre = $membre;

        return $this;
    }
}
