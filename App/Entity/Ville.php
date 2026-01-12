<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

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

    #[ORM\Column(type: 'string', length: 255)]
    private string $codePostale;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createAt;

    public function __construct()
    {
        $this->createAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
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
}
