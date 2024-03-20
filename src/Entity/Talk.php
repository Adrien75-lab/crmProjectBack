<?php

namespace App\Entity;

use App\Repository\TalkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ApiResource(paginationEnabled: false)]
#[ApiFilter(SearchFilter::class, properties: [
    'user' => 'exact' ,
    'organization' => 'exact'
])]
#[ORM\Entity(repositoryClass: TalkRepository::class)]
class Talk
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datetime = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    #[ORM\ManyToOne(inversedBy: 'talks')]
    private ?Organization $organization = null;

  

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'user')]
    private Collection $talks;

    #[ORM\ManyToOne(inversedBy: 'talks')]
    private ?AppUser $user = null;

    public function __construct()
    {
        $this->talks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): static
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

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


    /**
     * @return Collection<int, self>
     */
    public function getTalks(): Collection
    {
        return $this->talks;
    }

    public function addTalk(self $talk): static
    {
        if (!$this->talks->contains($talk)) {
            $this->talks->add($talk);
           
        }

        return $this;
    }

    public function removeTalk(self $talk): static
    {
        if ($this->talks->removeElement($talk)) {
            // set the owning side to null (unless already changed)
           
        }

        return $this;
    }

    public function getUser(): ?AppUser
    {
        return $this->user;
    }

    public function setUser(?AppUser $user): static
    {
        $this->user = $user;

        return $this;
    }
}
