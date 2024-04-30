<?php

namespace App\Entity;

use App\Repository\PlanetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PlanetRepository::class)]
#[Vich\Uploadable]
class Planet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'planets')]
    private ?Galaxy $galaxy = null;

    #[ORM\ManyToOne(inversedBy: 'planets')]
    private ?User $author = null;

    #[Assert\File(
        maxSize: '2M',
        extensions: ['jpg', 'jpeg', "png"],
        extensionsMessage: 'Please upload a valid image',
        maxSizeMessage: 'The file is too large. Allowed maximum size is 2Mo.',
    )]
    #[Vich\UploadableField(mapping: 'planets', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    /**
     * @var Collection<int, Lifeform>
     */
    #[ORM\ManyToMany(targetEntity: Lifeform::class, mappedBy: 'planet')]
    private Collection $lifeforms;

    /**
     * @var Collection<int, ReportPlanet>
     */
    #[ORM\OneToMany(targetEntity: ReportPlanet::class, mappedBy: 'planet')]
    private Collection $reportPlanets;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $type = null;

    #[ORM\Column(length: 100)]
    private ?string $lifeCondition = null;

    #[ORM\Column(length: 1500)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    public function __construct()
    {
        $this->lifeforms = new ArrayCollection();
        $this->reportPlanets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGalaxy(): ?Galaxy
    {
        return $this->galaxy;
    }

    public function setGalaxy(?Galaxy $galaxy): static
    {
        $this->galaxy = $galaxy;

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
     * @return Collection<int, Lifeform>
     */
    public function getLifeforms(): Collection
    {
        return $this->lifeforms;
    }

    public function addLifeform(Lifeform $lifeform): static
    {
        if (!$this->lifeforms->contains($lifeform)) {
            $this->lifeforms->add($lifeform);
            $lifeform->addPlanet($this);
        }

        return $this;
    }

    public function removeLifeform(Lifeform $lifeform): static
    {
        if ($this->lifeforms->removeElement($lifeform)) {
            $lifeform->removePlanet($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ReportPlanet>
     */
    public function getReportPlanets(): Collection
    {
        return $this->reportPlanets;
    }

    public function addReportPlanet(ReportPlanet $reportPlanet): static
    {
        if (!$this->reportPlanets->contains($reportPlanet)) {
            $this->reportPlanets->add($reportPlanet);
            $reportPlanet->setPlanet($this);
        }

        return $this;
    }

    public function removeReportPlanet(ReportPlanet $reportPlanet): static
    {
        if ($this->reportPlanets->removeElement($reportPlanet)) {
            // set the owning side to null (unless already changed)
            if ($reportPlanet->getPlanet() === $this) {
                $reportPlanet->setPlanet(null);
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getLifeCondition(): ?string
    {
        return $this->lifeCondition;
    }

    public function setLifeCondition(string $lifeCondition): static
    {
        $this->lifeCondition = $lifeCondition;

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
        return $this->name; // Pour renvoyer le nom de la planète dans le EasyAdmin
    }
}
