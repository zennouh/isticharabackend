<?php

namespace App\Entity;

use App\Core\MyEntityManager;
use App\Core\Services\ObjectMapper;
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


    #[ORM\Column(type: 'string', length: 10)]
    private string $sexe;

    #[ORM\Column(name: "annes_experience", type: 'integer')]
    private int $annesExperience;

    #[ORM\Column(type: 'string', length: 50)]
    private string $specialite;

    #[ORM\Column(name: "consult_en_ligne", type: 'string', length: 3)]
    private string $consultEnLigne = 'no';


    #[ORM\ManyToOne(targetEntity: Ville::class, inversedBy: 'avocats')]
    #[ORM\JoinColumn(name: 'ville_id', referencedColumnName: 'id',)]
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
    // ------------------- PASSWORD -------------------
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    // ------------------- AGE -------------------
    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;
        return $this;
    }

    // ------------------- SEXE -------------------
    public function getSexe(): string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;
        return $this;
    }

    // ------------------- ANNES EXPERIENCE -------------------
    public function getAnnesExperience(): int
    {
        return $this->annesExperience;
    }

    public function setAnnesExperience(int $annesExperience): self
    {
        $this->annesExperience = $annesExperience;
        return $this;
    }

    // ------------------- SPECIALITE -------------------
    public function getSpecialite(): string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;
        return $this;
    }

    // ------------------- CONSULT EN LIGNE -------------------
    public function getConsultEnLigne(): string
    {
        return $this->consultEnLigne;
    }

    public function setConsultEnLigne(string $consultEnLigne): self
    {
        $this->consultEnLigne = $consultEnLigne;
        return $this;
    }

    public static function updateObject(Avocat $avocat, array $data): Avocat
    {
        $reflection = new \ReflectionClass($avocat);

        foreach ($reflection->getProperties() as $property) {
         
            $propName = $property->getName();
            $columnName = ObjectMapper::camelToSnake($propName);

            if (!array_key_exists($columnName, $data)) {
                continue;
            }

            $value = $data[$columnName];

            // handle type conversion
            $type = $property->getType()?->getName();
            $value = match ($type) {
                'int'    => (int) $value,
                'float'  => (float) $value,
                'bool'   => (bool) $value,
                'string' => (string) $value,
                default  => $value,
            };

            $property->setValue($avocat, $value);
        }

        return $avocat;
    }

}
