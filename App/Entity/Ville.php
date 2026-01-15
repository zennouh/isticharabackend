<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'villes')]
#[ORM\UniqueConstraint(name: 'unique_name', columns: ['name'])]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $region;

    #[ORM\Column(type: 'string', length: 255, name: "code_postale")]
    private string $codePostale;

    #[ORM\Column(type: 'datetime_immutable', name:"create_at")]
    private DateTimeImmutable $createAt;


    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: Avocat::class, cascade: ['persist', 'remove'])]
    private Collection $avocats;

    public function __construct()
    {
        $this->createAt = new DateTimeImmutable();
        $this->avocats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;
        return $this;
    }

    public function getCodePostale(): string
    {
        return $this->codePostale;
    }

    public function setCodePostale(string $codePostale): self
    {
        $this->codePostale = $codePostale;
        return $this;
    }

    public function getCreateAt(): DateTimeImmutable
    {
        return $this->createAt;
    }


    public function getAvocats(): Collection
    {
        return $this->avocats;
    }

    public function addAvocat(Avocat $avocat): self
    {
        if (!$this->avocats->contains($avocat)) {
            $this->avocats->add($avocat);
            $avocat->setVille($this); // keep inverse side updated
        }
        return $this;
    }

    // public function removeAvocat(Avocat $avocat): self
    // {
    //     if ($this->avocats->removeElement($avocat)) {
    //         if ($avocat->getVille() === $this) {
    //             $avocat->setVille(null);
    //         }
    //     }
    //     return $this;
    // }
}
