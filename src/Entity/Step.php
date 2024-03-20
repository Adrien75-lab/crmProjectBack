<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StepRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ApiResource(paginationEnabled: false)]
#[ApiFilter(SearchFilter::class, properties: [
    'user' => 'exact' ,
    'organization' => 'exact'
])]
#[ORM\Entity(repositoryClass: StepRepository::class)]
class Step
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\ManyToMany(targetEntity: Organization::class, inversedBy: 'steps')]
    private Collection $organization;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column]
    private ?bool $isValidated = null;

    public function __construct()
    {
        $this->organization = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, Organization>
     */
    public function getOrganization(): Collection
    {
        return $this->organization;
    }

    public function addOrganization(Organization $organization): static
    {
        if (!$this->organization->contains($organization)) {
            $this->organization->add($organization);
        }

        return $this;
    }

    public function removeOrganization(Organization $organization): static
    {
        $this->organization->removeElement($organization);

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function isIsValidated(): ?bool
    {
        return $this->isValidated;
    }

    public function setIsValidated(bool $isValidated): static
    {
        $this->isValidated = $isValidated;

        return $this;
    }
}
