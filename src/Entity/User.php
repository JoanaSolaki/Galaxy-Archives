<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[Vich\Uploadable]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'avatar', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, Galaxy>
     */
    #[ORM\OneToMany(targetEntity: Galaxy::class, mappedBy: 'author')]
    private Collection $galaxies;

    /**
     * @var Collection<int, Planet>
     */
    #[ORM\OneToMany(targetEntity: Planet::class, mappedBy: 'author')]
    private Collection $planets;

    /**
     * @var Collection<int, Lifeform>
     */
    #[ORM\OneToMany(targetEntity: Lifeform::class, mappedBy: 'author')]
    private Collection $lifeforms;

    /**
     * @var Collection<int, ReportPlanet>
     */
    #[ORM\OneToMany(targetEntity: ReportPlanet::class, mappedBy: 'author')]
    private Collection $reportPlanets;

    /**
     * @var Collection<int, ReportLifeform>
     */
    #[ORM\OneToMany(targetEntity: ReportLifeform::class, mappedBy: 'author')]
    private Collection $reportLifeforms;

    #[ORM\Column(length: 100)]
    private ?string $username = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    public function __construct()
    {
        $this->galaxies = new ArrayCollection();
        $this->planets = new ArrayCollection();
        $this->lifeforms = new ArrayCollection();
        $this->reportPlanets = new ArrayCollection();
        $this->reportLifeforms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Galaxy>
     */
    public function getGalaxies(): Collection
    {
        return $this->galaxies;
    }

    public function addGalaxy(Galaxy $galaxy): static
    {
        if (!$this->galaxies->contains($galaxy)) {
            $this->galaxies->add($galaxy);
            $galaxy->setAuthor($this);
        }

        return $this;
    }

    public function removeGalaxy(Galaxy $galaxy): static
    {
        if ($this->galaxies->removeElement($galaxy)) {
            // set the owning side to null (unless already changed)
            if ($galaxy->getAuthor() === $this) {
                $galaxy->setAuthor(null);
            }
        }

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
            $planet->setAuthor($this);
        }

        return $this;
    }

    public function removePlanet(Planet $planet): static
    {
        if ($this->planets->removeElement($planet)) {
            // set the owning side to null (unless already changed)
            if ($planet->getAuthor() === $this) {
                $planet->setAuthor(null);
            }
        }

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
            $lifeform->setAuthor($this);
        }

        return $this;
    }

    public function removeLifeform(Lifeform $lifeform): static
    {
        if ($this->lifeforms->removeElement($lifeform)) {
            // set the owning side to null (unless already changed)
            if ($lifeform->getAuthor() === $this) {
                $lifeform->setAuthor(null);
            }
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
            $reportPlanet->setAuthor($this);
        }

        return $this;
    }

    public function removeReportPlanet(ReportPlanet $reportPlanet): static
    {
        if ($this->reportPlanets->removeElement($reportPlanet)) {
            // set the owning side to null (unless already changed)
            if ($reportPlanet->getAuthor() === $this) {
                $reportPlanet->setAuthor(null);
            }
        }

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
            $reportLifeform->setAuthor($this);
        }

        return $this;
    }

    public function removeReportLifeform(ReportLifeform $reportLifeform): static
    {
        if ($this->reportLifeforms->removeElement($reportLifeform)) {
            // set the owning side to null (unless already changed)
            if ($reportLifeform->getAuthor() === $this) {
                $reportLifeform->setAuthor(null);
            }
        }

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

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

    public function serialize()
    {
        $this->imageFile = base64_encode($this->imageFile);
    }

    public function unserialize($serialized)
    {
        $this->imageFile = base64_decode($this->imageFile);

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

    public function __toString(): string
    {
        return $this->username; // Pour renvoyer le pseudo dans le EasyAdmin
    }
}
