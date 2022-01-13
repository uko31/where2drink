<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $street;

    #[ORM\Column(type: 'string', length: 5)]
    private $zip;

    #[ORM\Column(type: 'string', length: 255)]
    private $city;

    #[ORM\OneToOne(mappedBy: 'address', targetEntity: Tavern::class, cascade: ['persist', 'remove'])]
    private $tavern;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getTavern(): ?Tavern
    {
        return $this->tavern;
    }

    public function setTavern(?Tavern $tavern): self
    {
        // unset the owning side of the relation if necessary
        if ($tavern === null && $this->tavern !== null) {
            $this->tavern->setAddress(null);
        }

        // set the owning side of the relation if necessary
        if ($tavern !== null && $tavern->getAddress() !== $this) {
            $tavern->setAddress($this);
        }

        $this->tavern = $tavern;

        return $this;
    }
}
