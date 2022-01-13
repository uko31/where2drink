<?php

namespace App\Entity;

use App\Repository\VoteByUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteByUserRepository::class)]
#[ORM\UniqueConstraint(
    name: 'one_vote_idx',
    columns: ['tavern_id', 'voter_id'],
)]
class VoteByUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Tavern::class, inversedBy: 'voteByUsers')]
    private $tavern;

    #[ORM\ManyToOne(targetEntity: People::class, inversedBy: 'voteByUsers')]
    private $voter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTavern(): ?Tavern
    {
        return $this->tavern;
    }

    public function setTavern(?Tavern $tavern): self
    {
        $this->tavern = $tavern;

        return $this;
    }

    public function getVoter(): ?People
    {
        return $this->voter;
    }

    public function setVoter(?People $voter): self
    {
        $this->voter = $voter;

        return $this;
    }
}
