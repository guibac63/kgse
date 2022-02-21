<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastname;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $avatar;

    #[ORM\Column(type: 'datetime')]
    private $creation_date;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: Agent::class)]
    private $agents;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: skills::class)]
    private $skills;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: hidingplace::class)]
    private $hidingplace;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: mission::class)]
    private $mission;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: contact::class)]
    private $contact;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: target::class)]
    private $target;

    public function __construct()
    {
        $this->agents = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->hidingplace = new ArrayCollection();
        $this->mission = new ArrayCollection();
        $this->contact = new ArrayCollection();
        $this->target = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

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
            $agent->setAdmin($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        if ($this->agents->removeElement($agent)) {
            // set the owning side to null (unless already changed)
            if ($agent->getAdmin() === $this) {
                $agent->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, skills>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(skills $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->setAdmin($this);
        }

        return $this;
    }

    public function removeSkill(skills $skill): self
    {
        if ($this->skills->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getAdmin() === $this) {
                $skill->setAdmin(null);
            }
        }

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
            $hidingplace->setAdmin($this);
        }

        return $this;
    }

    public function removeHidingplace(hidingplace $hidingplace): self
    {
        if ($this->hidingplace->removeElement($hidingplace)) {
            // set the owning side to null (unless already changed)
            if ($hidingplace->getAdmin() === $this) {
                $hidingplace->setAdmin(null);
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
            $mission->setAdmin($this);
        }

        return $this;
    }

    public function removeMission(mission $mission): self
    {
        if ($this->mission->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getAdmin() === $this) {
                $mission->setAdmin(null);
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
            $contact->setAdmin($this);
        }

        return $this;
    }

    public function removeContact(contact $contact): self
    {
        if ($this->contact->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getAdmin() === $this) {
                $contact->setAdmin(null);
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
            $target->setAdmin($this);
        }

        return $this;
    }

    public function removeTarget(target $target): self
    {
        if ($this->target->removeElement($target)) {
            // set the owning side to null (unless already changed)
            if ($target->getAdmin() === $this) {
                $target->setAdmin(null);
            }
        }

        return $this;
    }
}
