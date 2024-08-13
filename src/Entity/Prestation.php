<?php

namespace App\Entity;

use App\Repository\PrestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PrestationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['prestation:read']]
    )
]
class Prestation
{
    #[Groups(["order:read", "prestation:read", "category:read", "order:read", "customer:read"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(["orderLine:read", "employee:read", "prestation:read", "category:read", "order:read", "customer:read"])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(["prestation:read", "category:read", "order:read", "customer:read"])]
    #[ORM\Column]
    private ?float $base_price = null;

    /**
     * @var Collection<int, OrderLine>
     */
    #[ORM\OneToMany(targetEntity: OrderLine::class, mappedBy: 'prestation')]
    private Collection $orderLines;


    #[Groups("prestation:read")]
    /**
     * @var Collection<int, AttributionPrestationCategory>
     */
    #[ORM\ManyToMany(targetEntity: AttributionPrestationCategory::class, mappedBy: 'Prestation')]
    private Collection $attributionPrestationCategories;

    public function __construct()
    {
        $this->orderLines = new ArrayCollection();
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

    public function getBasePrice(): ?float
    {
        return $this->base_price;
    }

    public function setBasePrice(float $base_price): static
    {
        $this->base_price = $base_price;

        return $this;
    }

    /**
     * @return Collection<int, OrderLine>
     */
    public function getOrderLines(): Collection
    {
        return $this->orderLines;
    }

    public function addOrderLine(OrderLine $orderLine): static
    {
        if (!$this->orderLines->contains($orderLine)) {
            $this->orderLines->add($orderLine);
            $orderLine->setPrestation($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): static
    {
        if ($this->orderLines->removeElement($orderLine)) {
            // set the owning side to null (unless already changed)
            if ($orderLine->getPrestation() === $this) {
                $orderLine->setPrestation(null);
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
            $attributionPrestationCategory->addPrestation($this);
        }

        return $this;
    }

    public function removeAttributionPrestationCategory(AttributionPrestationCategory $attributionPrestationCategory): static
    {
        if ($this->attributionPrestationCategories->removeElement($attributionPrestationCategory)) {
            $attributionPrestationCategory->removePrestation($this);
        }

        return $this;
    }
}
