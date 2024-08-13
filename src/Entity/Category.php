<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['category:read']]
    )]
class Category
{
    #[Groups(["category:read", "product:read", "prestation:read", "order:read"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(["category:read", "product:read", "prestation:read", "order:read"])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'categories')]
    private ?category $parent_cat = null;

    #[Groups(["category:read", "product:read", "prestation:read", "order:read"])]
    #[ORM\Column]
    private ?float $coef_price = null;

    #[Groups(["category:read", "prestation:read"])]
    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'category')]
    private Collection $products;

    
    #[Groups("category:read")]
    /**
     * @var Collection<int, AttributionPrestationCategory>
     */
    #[ORM\ManyToMany(targetEntity: AttributionPrestationCategory::class, mappedBy: 'Category')]
    private Collection $attributionPrestationCategories;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->attributionPrestationCategories = new ArrayCollection();
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

    public function getParentCat(): ?self
    {
        return $this->parent_cat;
    }

    public function setParentCat(?self $parent_cat): static
    {
        $this->parent_cat = $parent_cat;

        return $this;
    }

    public function getCoefPrice(): ?float
    {
        return $this->coef_price;
    }

    public function setCoefPrice(float $coef_price): static
    {
        $this->coef_price = $coef_price;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AttributionPrestationCategory>
     */
    public function getAttributionPrestationCategories(): Collection
    {
        return $this->attributionPrestationCategories;
    }

    public function addAttributionPrestationCategory(AttributionPrestationCategory $attributionPrestationCategory): static
    {
        if (!$this->attributionPrestationCategories->contains($attributionPrestationCategory)) {
            $this->attributionPrestationCategories->add($attributionPrestationCategory);
            $attributionPrestationCategory->addCategory($this);
        }

        return $this;
    }

    public function removeAttributionPrestationCategory(AttributionPrestationCategory $attributionPrestationCategory): static
    {
        if ($this->attributionPrestationCategories->removeElement($attributionPrestationCategory)) {
            $attributionPrestationCategory->removeCategory($this);
        }

        return $this;
    }
}
