<?php

namespace App\Entity;

use App\Repository\LifeformRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: LifeformRepository::class)]
#[Vich\Uploadable]
class Lifeform
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'lifeform', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    /**
     * @var Collection<int, Planet>
     */
    #[ORM\ManyToMany(targetEntity: Planet::class, inversedBy: 'lifeforms')]
    private Collection $planet;

    #[ORM\ManyToOne(inversedBy: 'lifeforms')]
    private ?User $author = null;

    /**
     * @var Collection<int, ReportLifeform>
     */
    #[ORM\OneToMany(targetEntity: ReportLifeform::class, mappedBy: 'lifeform')]
    private Collection $reportLifeforms;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $species = null;

    #[ORM\Column(length: 100)]
    private ?string $behavior = null;

    #[ORM\Column(length: 1500)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    public function __construct()
    {
        $this->planet = new ArrayCollection();
        $this->reportLifeforms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Planet>
     */
    public function getPlanet(): Collection
    {
        return $this->planet;
    }

    public function addPlanet(Planet $planet): static
    {
        if (!$this->planet->contains($planet)) {
            $this->planet->add($planet);
        }

        return $this;
    }

    public function removePlanet(Planet $planet): static
    {
        $this->planet->removeElement($planet);

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

    /**
     * @return Collection<int, ReportLifeform>
     */
    public function getReportLifeforms(): Collection
    {
        return $this->reportLifeforms;
    }

    public function addReportLifeform(ReportLifeform $reportLifeform): static
    {
        if (!$this->reportLifeforms->contains($reportLifeform)) {
            $this->reportLifeforms->add($reportLifeform);
            $reportLifeform->setLifeform($this);
        }

        return $this;
    }

    public function removeReportLifeform(ReportLifeform $reportLifeform): static
    {
        if ($this->reportLifeforms->removeElement($reportLifeform)) {
            // set the owning side to null (unless already changed)
            if ($reportLifeform->getLifeform() === $this) {
                $reportLifeform->setLifeform(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSpecies(): ?string
    {
        return $this->species;
    }

    public function setSpecies(?string $species): static
    {
        $this->species = $species;

        return $this;
    }

    public function getBehavior(): ?string
    {
        return $this->behavior;
    }

    public function setBehavior(string $behavior): static
    {
        $this->behavior = $behavior;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated_at = new \DateTime();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function __toString(): string
    {
        return $this->name; // Pour renvoyer le nom de la créature dans le EasyAdmin
    }
}
