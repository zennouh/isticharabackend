<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'avocats')]
#[ORM\UniqueConstraint(name: 'unique_email', columns: ['email'])]
class Avocat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(name: 'full_name', type: 'string', length: 255)]
    private string $fullName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(type: 'integer')]
    private int $age;

    // ENUMs → stored as string (Doctrine-safe)
    #[ORM\Column(type: 'string', length: 10)]
    private string $sexe;

    #[ORM\Column(type: 'integer')]
    private int $annesExperience;

    #[ORM\Column(type: 'string', length: 50)]
    private string $specialite;

    #[ORM\Column(type: 'string', length: 3)]
    private string $consultEnLigne = 'no';

    // Relation
    #[ORM\ManyToOne(targetEntity: Ville::class)]
    #[ORM\JoinColumn(name: 'ville_id', referencedColumnName: 'id')]
    private Ville $ville;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function getVille(): Ville
    {
        return $this->ville;
    }

    public function setVille(Ville $ville): self
    {
        $this->ville = $ville;
        return $this;
    }
}
