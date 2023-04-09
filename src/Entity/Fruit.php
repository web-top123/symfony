<?php

namespace App\Entity;

use App\Repository\FruitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FruitRepository::class)]
class Fruit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $genus = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $numid = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $family = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $forder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenus(): ?string
    {
        return $this->genus;
    }

    public function setGenus(?string $genus): self
    {
        $this->genus = $genus;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNumid(): ?string
    {
        return $this->numid;
    }

    public function setNumid(string $numid): self
    {
        $this->numid = $numid;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(?string $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getForder(): ?string
    {
        return $this->forder;
    }

    public function setForder(?string $forder): self
    {
        $this->forder = $forder;

        return $this;
    }
}
