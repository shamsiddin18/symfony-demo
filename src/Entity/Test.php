<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'test')]
class Test
{
    #[ORM\Column(
        name: 'id',
        type: Types::INTEGER
    )]
        #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
         private ?int $id;

    #[ORM\Column(
        name: 'name',
        type: Types::INTEGER,
        length: 120
    )]
        private string $name;

    #[ORM\Column(
        )]
        private int $subjectId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSubjectId(): int
    {
        return $this->subjectId;
    }

    public function setSubjectId(int $subjectId): void
    {
        $this->subjectId = $subjectId;
    }
}
