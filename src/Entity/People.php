<?php

namespace App\Entity;

use App\Repository\PeopleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
#[ORM\Entity(repositoryClass: PeopleRepository::class)]
class People implements UserInterface, PasswordAuthenticatedUserInterface
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

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nickname;

    #[ORM\OneToMany(mappedBy: 'addedBy', targetEntity: Tavern::class)]
    private $taverns;

    #[ORM\OneToMany(mappedBy: 'voter', targetEntity: VoteByUser::class)]
    private $voteByUsers;    

    public function __construct()
    {
        $this->taverns = new ArrayCollection();
        $this->voteByUsers = new ArrayCollection();
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
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * @return Collection|Tavern[]
     */
    public function getTaverns(): Collection
    {
        return $this->taverns;
    }

    public function addTavern(Tavern $tavern): self
    {
        if (!$this->taverns->contains($tavern)) {
            $this->taverns[] = $tavern;
            $tavern->setAddedBy($this);
        }

        return $this;
    }

    public function removeTavern(Tavern $tavern): self
    {
        if ($this->taverns->removeElement($tavern)) {
            // set the owning side to null (unless already changed)
            if ($tavern->getAddedBy() === $this) {
                $tavern->setAddedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VoteByUser[]
     */
    public function getVoteByUsers(): Collection
    {
        return $this->voteByUsers;
    }

    public function addVoteByUser(VoteByUser $voteByUser): self
    {
        if (!$this->voteByUsers->contains($voteByUser)) {
            $this->voteByUsers[] = $voteByUser;
            $voteByUser->setVoter($this);
        }

        return $this;
    }

    public function removeVoteByUser(VoteByUser $voteByUser): self
    {
        if ($this->voteByUsers->removeElement($voteByUser)) {
            // set the owning side to null (unless already changed)
            if ($voteByUser->getVoter() === $this) {
                $voteByUser->setVoter(null);
            }
        }

        return $this;
    }    
}
