<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
class Mission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $code_name;

    #[ORM\Column(type: 'string', length: 255)]
    private $category;

    #[ORM\Column(type: 'string', length: 255)]
    private $status;

    #[ORM\Column(type: 'date')]
    private $beginning_date;

    #[ORM\Column(type: 'date')]
    private $ending_date;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $last_update;

    #[ORM\ManyToOne(targetEntity: Country::class, inversedBy: 'mission')]
    #[ORM\JoinColumn(nullable: false)]
    private $country;

    #[ORM\ManyToOne(targetEntity: Admin::class, inversedBy: 'mission')]
    private $admin;

    #[ORM\ManyToOne(targetEntity: Skills::class, inversedBy: 'missions')]
    #[ORM\JoinColumn(nullable: false)]
    private $skills;

    #[ORM\ManyToMany(targetEntity: Contact::class, inversedBy: 'missions')]
    private $contact;

    #[ORM\ManyToMany(targetEntity: HidingPlace::class, inversedBy: 'missions')]
    private $hidingplace;

    #[ORM\ManyToMany(targetEntity: Agent::class, inversedBy: 'missions')]
    private $agent;

    #[ORM\ManyToMany(targetEntity: Target::class, inversedBy: 'missions')]
    private $target;



    public function __construct()
    {
        $this->contact = new ArrayCollection();
        $this->hidingplace = new ArrayCollection();
        $this->agent = new ArrayCollection();
        //$this->targets = new ArrayCollection();
        $this->target = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getCodeName(): ?string
    {
        return $this->code_name;
    }

    public function setCodeName(string $code_name): self
    {
        $this->code_name = $code_name;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getBeginningDate(): ?\DateTimeInterface
    {
        return $this->beginning_date;
    }

    public function setBeginningDate(\DateTimeInterface $beginning_date): self
    {
        $this->beginning_date = $beginning_date;

        return $this;
    }

    public function getEndingDate(): ?\DateTimeInterface
    {
        return $this->ending_date;
    }

    public function setEndingDate(\DateTimeInterface $ending_date): self
    {
        $this->ending_date = $ending_date;

        return $this;
    }

    public function getLastUpdate(): ?\DateTimeInterface
    {
        return $this->last_update;
    }

    public function setLastUpdate(?\DateTimeInterface $last_update): self
    {
        $this->last_update = $last_update;

        return $this;
    }

    /**
     * @return Collection<int, agent>
     */
    public function getAgent(): Collection
    {
        return $this->agent;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agent->contains($agent)) {
            $this->agent[] = $agent;
            $agent->addMission($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        if ($this->agent->removeElement($agent)) {
            $agent->removeMission($this);
        }

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getSkills(): ?skills
    {
        return $this->skills;
    }

    public function setSkills(?skills $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * @return Collection<int, contact>
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(contact $contact): self
    {
        if (!$this->contact->contains($contact)) {
            $this->contact[] = $contact;
        }

        return $this;
    }

    public function removeContact(contact $contact): self
    {
        $this->contact->removeElement($contact);

        return $this;
    }

    /**
     * @return Collection<int, hidingplace>
     */
    public function getHidingplace(): Collection
    {
        return $this->hidingplace;
    }

    public function addHidingplace(hidingplace $hidingplace): self
    {
        if (!$this->hidingplace->contains($hidingplace)) {
            $this->hidingplace[] = $hidingplace;
        }

        return $this;
    }

    public function removeHidingplace(hidingplace $hidingplace): self
    {
        $this->hidingplace->removeElement($hidingplace);

        return $this;
    }

    /**
     * @return Collection<int, target>
     */
    public function getTarget(): Collection
    {
        return $this->target;
    }

    public function addTarget(target $target): self
    {
        if (!$this->target->contains($target)) {
            $this->target[] = $target;
        }

        return $this;
    }

    public function removeTarget(target $target): self
    {
        $this->target->removeElement($target);

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }
}
