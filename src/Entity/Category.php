<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children_categories')]
    private ?self $children = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'children')]
    private Collection $children_categories;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parent')]
    private ?self $parent_category = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent_category')]
    private Collection $parent;

    public function __construct()
    {
        $this->children_categories = new ArrayCollection();
        $this->parent = new ArrayCollection();
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

    public function getChildren(): ?self
    {
        return $this->children;
    }

    public function setChildren(?self $children): static
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildrenCategories(): Collection
    {
        return $this->children_categories;
    }

    public function addChildrenCategory(self $childrenCategory): static
    {
        if (!$this->children_categories->contains($childrenCategory)) {
            $this->children_categories->add($childrenCategory);
            $childrenCategory->setChildren($this);
        }

        return $this;
    }

    public function removeChildrenCategory(self $childrenCategory): static
    {
        if ($this->children_categories->removeElement($childrenCategory)) {
            // set the owning side to null (unless already changed)
            if ($childrenCategory->getChildren() === $this) {
                $childrenCategory->setChildren(null);
            }
        }

        return $this;
    }

    public function getParentCategory(): ?self
    {
        return $this->parent_category;
    }

    public function setParentCategory(?self $parent_category): static
    {
        $this->parent_category = $parent_category;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(self $parent): static
    {
        if (!$this->parent->contains($parent)) {
            $this->parent->add($parent);
            $parent->setParentCategory($this);
        }

        return $this;
    }

    public function removeParent(self $parent): static
    {
        if ($this->parent->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getParentCategory() === $this) {
                $parent->setParentCategory(null);
            }
        }

        return $this;
    }
}
