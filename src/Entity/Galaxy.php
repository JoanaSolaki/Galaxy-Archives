<?php

namespace App\Entity;

use App\Repository\GalaxyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GalaxyRepository::class)]
#[Vich\Uploadable]
#[UniqueEntity('name', message: 'This name is already taken')]
class Galaxy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\File(
        maxSize: '2M',
        extensions: ['jpg', 'jpeg', "png"],
        extensionsMessage: 'Please upload a valid image',
        maxSizeMessage: 'The file is too large. Allowed maximum size is 2Mo.',
    )]
    #[Vich\UploadableField(mapping: 'galaxy', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\ManyToOne(inversedBy: 'galaxies')]
    private ?User $author = null;

    /**
     * @var Collection<int, Planet>
     */
    #[ORM\OneToMany(targetEntity: Planet::class, mappedBy: 'galaxy')]
    private Collection $planets;

    #[Assert\Length(min: 6)]
    #[Assert\Regex(
        '/^[a-zA-Z0-9_-]{3,15}$/', 
        message: "The characters entered are not correct.")]
    #[ORM\Column(length: 100)]
    private string $name = '';

    #[Assert\Length(min: 20)]
    #[ORM\Column(length: 1500)]
    private string $particularities = '';

    #[Assert\Length(min: 20)]
    #[ORM\Column(length: 1500)]
    private string $description = '';

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    public function __construct()
    {
        $this->planets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, Planet>
     */
    public function getPlanets(): Collection
    {
        return $this->planets;
    }

    public function addPlanet(Planet $planet): static
    {
        if (!$this->planets->contains($planet)) {
            $this->planets->add($planet);
            $planet->setGalaxy($this);
        }

        return $this;
    }

    public function removePlanet(Planet $planet): static
    {
        if ($this->planets->removeElement($planet)) {
            // set the owning side to null (unless already changed)
            if ($planet->getGalaxy() === $this) {
                $planet->setGalaxy(null);
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

    public function getParticularities(): ?string
    {
        return $this->particularities;
    }

    public function setParticularities(string $particularities): static
    {
        $this->particularities = $particularities;

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
        return $this->name; // Pour renvoyer le nom de la galaxie dans le EasyAdmin
    }
}
