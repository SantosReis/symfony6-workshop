<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $address = null;

    /**
     * @var Collection<int, InterestGroup>
     */
    #[ORM\ManyToMany(targetEntity: InterestGroup::class, mappedBy: 'members')]
    private Collection $interestGroup;

    public function __construct()
    {
        $this->interestGroup = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, InterestGroup>
     */
    public function getInterestGroup(): Collection
    {
        return $this->interestGroup;
    }

    public function addInterestGroup(InterestGroup $interestGroup): static
    {
        if (!$this->interestGroup->contains($interestGroup)) {
            $this->interestGroup->add($interestGroup);
            $interestGroup->addMember($this);
        }

        return $this;
    }

    public function removeInterestGroup(InterestGroup $interestGroup): static
    {
        if ($this->interestGroup->removeElement($interestGroup)) {
            $interestGroup->removeMember($this);
        }

        return $this;
    }
}
