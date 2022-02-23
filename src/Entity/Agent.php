<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: AgentRepository::class)]
class Agent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastname;

    #[ORM\Column(type: 'date')]
    private $birth_date;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $avatar;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $last_update;

    #[ORM\ManyToOne(targetEntity: Country::class, inversedBy: 'agents')]
    #[ORM\JoinColumn(nullable: false)]
    private $country;

    #[ORM\ManyToOne(targetEntity: Admin::class, inversedBy: 'agents')]
    private $admin;

    #[ORM\ManyToMany(targetEntity: Mission::class, mappedBy: 'agent')]
    private $missions;

    #[ORM\ManyToMany(targetEntity: Skills::class, inversedBy: 'agent')]
    private $agent_skills;

    public function __construct()
    {
        $this->missions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(\DateTimeInterface $birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

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
     * @return Collection<int, skills>
     */
    public function getAgentSkills(): Collection
    {
        return $this->agent_skills;
    }

    public function addAgentSkill(skills $agentSkill): self
    {
        if (!$this->agent_skills->contains($agentSkill)) {
            $this->agent_skills[] = $agentSkill;
        }

        return $this;
    }

    public function removeAgentSkill(skills $agentSkill): self
    {
        $this->agent_skills->removeElement($agentSkill);

        return $this;
    }

    public function getCountry(): ?country
    {
        return $this->country;
    }

    public function setCountry(?country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getAdmin(): ?admin
    {
        return $this->admin;
    }

    public function setAdmin(?admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    #[Pure] public function __toString(): string
    {
        return ($this->getFirstname().' '.$this->getLastname());
    }

    /**
     * @return Collection<int, Mission>
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions[] = $mission;
            $mission->addAgent($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->removeElement($mission)) {
            $mission->removeAgent($this);
        }

        return $this;
    }

}
