<?php

namespace App\Entity;

use App\Repository\MyUserRepository;
use App\Repository\TavernRepository;
use App\Repository\VoteByUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TavernRepository::class)]
class Tavern
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToOne(inversedBy: 'tavern', targetEntity: Address::class, cascade: ['persist', 'remove'])]
    private $address;

    #[ORM\ManyToOne(targetEntity: People::class, inversedBy: 'taverns')]
    private $addedBy;

    #[ORM\OneToMany(mappedBy: 'tavern', targetEntity: VoteByUser::class)]
    private $voteByUsers;

    public function __construct()
    {
        $this->voteByUsers = new ArrayCollection();
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

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getAddedBy(): ?People
    {
        return $this->addedBy;
    }

    public function setAddedBy(?People $addedBy): self
    {
        $this->addedBy = $addedBy;

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
            $voteByUser->setTavern($this);
        }

        return $this;
    }

    public function removeVoteByUser(VoteByUser $voteByUser): self
    {
        if ($this->voteByUsers->removeElement($voteByUser)) {
            // set the owning side to null (unless already changed)
            if ($voteByUser->getTavern() === $this) {
                $voteByUser->setTavern(null);
            }
        }

        return $this;
    }
}
