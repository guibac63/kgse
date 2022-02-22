<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $flag;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Agent::class)]
    private $agents;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: HidingPlace::class)]
    private $hiding_place;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Mission::class)]
    private $mission;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Target::class)]
    private $target;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Contact::class)]
    private $contact;

    public function __construct()
    {
        $this->agents = new ArrayCollection();
        $this->hiding_place = new ArrayCollection();
        $this->mission = new ArrayCollection();
        $this->target = new ArrayCollection();
        $this->contact = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFlag()
    {
        return $this->flag;
    }

    public function setFlag($flag): self
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * @return Collection<int, Agent>
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents[] = $agent;
            $agent->setCountry($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        if ($this->agents->removeElement($agent)) {
            // set the owning side to null (unless already changed)
            if ($agent->getCountry() === $this) {
                $agent->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, hidingplace>
     */
    public function getHidingPlace(): Collection
    {
        return $this->hiding_place;
    }

    public function addHidingPlace(hidingplace $hidingPlace): self
    {
        if (!$this->hiding_place->contains($hidingPlace)) {
            $this->hiding_place[] = $hidingPlace;
            $hidingPlace->setCountry($this);
        }

        return $this;
    }

    public function removeHidingPlace(hidingplace $hidingPlace): self
    {
        if ($this->hiding_place->removeElement($hidingPlace)) {
            // set the owning side to null (unless already changed)
            if ($hidingPlace->getCountry() === $this) {
                $hidingPlace->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, mission>
     */
    public function getMission(): Collection
    {
        return $this->mission;
    }

    public function addMission(mission $mission): self
    {
        if (!$this->mission->contains($mission)) {
            $this->mission[] = $mission;
            $mission->setCountry($this);
        }

        return $this;
    }

    public function removeMission(mission $mission): self
    {
        if ($this->mission->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getCountry() === $this) {
                $mission->setCountry(null);
            }
        }

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
            $target->setCountry($this);
        }

        return $this;
    }

    public function removeTarget(target $target): self
    {
        if ($this->target->removeElement($target)) {
            // set the owning side to null (unless already changed)
            if ($target->getCountry() === $this) {
                $target->setCountry(null);
            }
        }

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
            $contact->setCountry($this);
        }

        return $this;
    }

    public function removeContact(contact $contact): self
    {
        if ($this->contact->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getCountry() === $this) {
                $contact->setCountry(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
