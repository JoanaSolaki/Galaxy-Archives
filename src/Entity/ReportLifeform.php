<?php

namespace App\Entity;

use App\Repository\ReportLifeformRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportLifeformRepository::class)]
class ReportLifeform
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reportLifeforms')]
    private ?Lifeform $lifeform = null;

    #[ORM\ManyToOne(inversedBy: 'reportLifeforms')]
    private ?User $author = null;

    #[ORM\Column(length: 1500)]
    private ?string $body = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $update_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLifeform(): ?Lifeform
    {
        return $this->lifeform;
    }

    public function setLifeform(?Lifeform $lifeform): static
    {
        $this->lifeform = $lifeform;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(?\DateTimeInterface $update_at): static
    {
        $this->update_at = $update_at;

        return $this;
    }
}