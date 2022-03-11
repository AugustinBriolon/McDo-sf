<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToOne(targetEntity: District::class, inversedBy: 'restaurants')]
    #[ORM\JoinColumn(nullable: false)]
    private $district;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'create')]
    private $createdAt;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'update')]
    private $updatedAt;

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: ProductRestaurant::class)]
    private $productRestaurants;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $picture;

    public function __construct()
    {
        $this->productRestaurants = new ArrayCollection();
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

    public function getDistrict(): ?District
    {
        return $this->district;
    }

    public function setDistrict(?District $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, ProductRestaurant>
     */
    public function getProductRestaurants(): Collection
    {
        return $this->productRestaurants;
    }

    public function addProductRestaurant(ProductRestaurant $productRestaurant): self
    {
        if (!$this->productRestaurants->contains($productRestaurant)) {
            $this->productRestaurants[] = $productRestaurant;
            $productRestaurant->setRestaurant($this);
        }

        return $this;
    }

    public function removeProductRestaurant(ProductRestaurant $productRestaurant): self
    {
        if ($this->productRestaurants->removeElement($productRestaurant)) {
            // set the owning side to null (unless already changed)
            if ($productRestaurant->getRestaurant() === $this) {
                $productRestaurant->setRestaurant(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}