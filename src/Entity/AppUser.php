<?php

namespace App\Entity;

use App\Repository\AppUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;

#[ApiResource(paginationEnabled: true)]
#[ApiFilter(SearchFilter::class, properties: [
    'status' => 'exact', 
    'organization' => 'exact' 
])]

#[ORM\Entity(repositoryClass: AppUserRepository::class)]
class AppUser
{
    const STATUS_PENDING = 'En attente';
    const STATUS_ACTIVE = 'Actif';
    const STATUS_INACTIVE = 'Inactif';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $last_login = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $deleted_at = null;

    #[ORM\ManyToOne(inversedBy: 'appUsers')]
    private ?Organization $organization = null;

    #[ORM\Column(length: 255, options: ["default" => self::STATUS_PENDING])]
    private ?string $status = self::STATUS_PENDING;

    #[ORM\OneToMany(targetEntity: Talk::class, mappedBy: 'user')]
    private Collection $talks;

    #[ORM\OneToMany(targetEntity: Reminder::class, mappedBy: 'user')]
    private Collection $reminders;

    public function __construct()
    {
        $this->talks = new ArrayCollection();
        $this->reminders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->last_login;
    }

    public function setLastLogin(\DateTimeInterface $last_login): static
    {
        $this->last_login = $last_login;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(\DateTimeImmutable $deleted_at): static
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): static
    {
        $this->organization = $organization;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Talk>
     */
    public function getTalks(): Collection
    {
        return $this->talks;
    }

    public function addTalk(Talk $talk): static
    {
        if (!$this->talks->contains($talk)) {
            $this->talks->add($talk);
            $talk->setUser($this);
        }

        return $this;
    }

    public function removeTalk(Talk $talk): static
    {
        if ($this->talks->removeElement($talk)) {
            // set the owning side to null (unless already changed)
            if ($talk->getUser() === $this) {
                $talk->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reminder>
     */
    public function getReminders(): Collection
    {
        return $this->reminders;
    }

    public function addReminder(Reminder $reminder): static
    {
        if (!$this->reminders->contains($reminder)) {
            $this->reminders->add($reminder);
            $reminder->setUser($this);
        }

        return $this;
    }

    public function removeReminder(Reminder $reminder): static
    {
        if ($this->reminders->removeElement($reminder)) {
            // set the owning side to null (unless already changed)
            if ($reminder->getUser() === $this) {
                $reminder->setUser(null);
            }
        }

        return $this;
    }
}
