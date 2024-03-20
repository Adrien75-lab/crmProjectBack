<?php

namespace App\Entity;

use App\Repository\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource(paginationEnabled: false)]
#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
class Organization
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    private ?string $referent_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $referent_function = null;

    #[ORM\Column(length: 255)]
    private ?string $referent_mail = null;

    #[ORM\Column(length: 255)]
    private ?string $referent_phone = null;

    #[ORM\OneToMany(targetEntity: AppUser::class, mappedBy: 'organization')]
    private Collection $appUsers;

    #[ORM\OneToMany(targetEntity: Talk::class, mappedBy: 'organization')]
    private Collection $talks;

    #[ORM\OneToMany(targetEntity: Reminder::class, mappedBy: 'organization')]
    private Collection $reminders;

    #[ORM\ManyToMany(targetEntity: Step::class, mappedBy: 'organization')]
    private Collection $steps;

    #[ORM\OneToMany(targetEntity: Contact::class, mappedBy: 'organization')]
    private Collection $contacts;

   

    public function __construct()
    {
        $this->appUsers = new ArrayCollection();
        $this->talks = new ArrayCollection();
        $this->reminders = new ArrayCollection();
        $this->steps = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getReferentName(): ?string
    {
        return $this->referent_name;
    }

    public function setReferentName(string $referent_name): static
    {
        $this->referent_name = $referent_name;

        return $this;
    }

    public function getReferentFunction(): ?string
    {
        return $this->referent_function;
    }

    public function setReferentFunction(?string $referent_function): static
    {
        $this->referent_function = $referent_function;

        return $this;
    }

    public function getReferentMail(): ?string
    {
        return $this->referent_mail;
    }

    public function setReferentMail(string $referent_mail): static
    {
        $this->referent_mail = $referent_mail;

        return $this;
    }

    public function getReferentPhone(): ?string
    {
        return $this->referent_phone;
    }

    public function setReferentPhone(string $referent_phone): static
    {
        $this->referent_phone = $referent_phone;

        return $this;
    }

    /**
     * @return Collection<int, AppUser>
     */
    public function getAppUsers(): Collection
    {
        return $this->appUsers;
    }

    public function addAppUser(AppUser $appUser): static
    {
        if (!$this->appUsers->contains($appUser)) {
            $this->appUsers->add($appUser);
            $appUser->setOrganization($this);
        }

        return $this;
    }

    public function removeAppUser(AppUser $appUser): static
    {
        if ($this->appUsers->removeElement($appUser)) {
            // set the owning side to null (unless already changed)
            if ($appUser->getOrganization() === $this) {
                $appUser->setOrganization(null);
            }
        }

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
            $talk->setOrganization($this);
        }

        return $this;
    }

    public function removeTalk(Talk $talk): static
    {
        if ($this->talks->removeElement($talk)) {
            // set the owning side to null (unless already changed)
            if ($talk->getOrganization() === $this) {
                $talk->setOrganization(null);
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
            $reminder->setOrganization($this);
        }

        return $this;
    }

    public function removeReminder(Reminder $reminder): static
    {
        if ($this->reminders->removeElement($reminder)) {
            // set the owning side to null (unless already changed)
            if ($reminder->getOrganization() === $this) {
                $reminder->setOrganization(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Step>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): static
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->addOrganization($this);
        }

        return $this;
    }

    public function removeStep(Step $step): static
    {
        if ($this->steps->removeElement($step)) {
            $step->removeOrganization($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): static
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setOrganization($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): static
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getOrganization() === $this) {
                $contact->setOrganization(null);
            }
        }

        return $this;
    }

    
    

   
    
}
