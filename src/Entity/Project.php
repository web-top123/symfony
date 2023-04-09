<?php
 
namespace App\Entity;
 
use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
 
#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
 
    #[ORM\Column(type: 'string', length: 255)]
    private $name;
 
    #[ORM\Column(type: 'text')]
    private $description;
 
    #[Gedmo\Timestampable(on:"update")]
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created_at;
 
    #[Gedmo\Timestampable(on:"update")]
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated_at;
 
    public function getId(): ?int
    {
        return $this->id;
    }
 
    public function getName(): ?string
    {
        return $this->name;
    }
 
    public function setName(string $name): self
    {
        $this->name = $name;
 
        return $this;
    }
 
    public function getDescription(): ?string
    {
        return $this->description;
    }
 
    public function setDescription(string $description): self
    {
        $this->description = $description;
 
        return $this;
    }
 
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }
 
    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;
 
        return $this;
    }
 
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }
 
    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;
 
        return $this;
    }
}