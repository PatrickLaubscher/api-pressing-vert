<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\ExistsFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\OrderLineRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderLineRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['orderLine:read']])
]
#[ApiFilter(SearchFilter::class, properties: ['employee.firstname' => 'partial', 'order_line_status.name' => 'partial', 'product.name' => 'partial'])]
#[ApiFilter(ExistsFilter::class, properties:['employee'])]

class OrderLine
{
    #[Groups(["orderLine:read", "employee:read", "order:read", "customer:read"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(["orderLine:read", "employee:read", "order:read", "customer:read"])]
    #[ORM\ManyToOne(inversedBy: 'orderLines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[Groups(["orderLine:read", "employee:read", "order:read", "customer:read"])]
    #[ORM\ManyToOne(inversedBy: 'orderLines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prestation $prestation = null;

    #[Groups(["orderLine:read", "employee:read"])]
    #[ORM\ManyToOne(inversedBy: 'orderLines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $main_order = null;

    #[Groups(["orderLine:read", "employee:read", "order:read", "customer:read"])]
    #[ORM\ManyToOne(inversedBy: 'orderLines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OrderLineStatus $order_line_status = null;

    #[Groups(["orderLine:read", "employee:read", "order:read", "customer:read"])]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $qty = null;

    #[Groups(["orderLine:read", "employee:read", "order:read", "customer:read"])]
    #[ORM\Column]
    private ?float $price = null;

    #[Groups(["orderLine:read", "order:read"])]
    #[ORM\ManyToOne(inversedBy: 'orderLines')]
    private ?Employee $employee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getPrestation(): ?Prestation
    {
        return $this->prestation;
    }

    public function setPrestation(?Prestation $prestation): static
    {
        $this->prestation = $prestation;

        return $this;
    }

    public function getMainOrder(): ?Order
    {
        return $this->main_order;
    }

    public function setMainOrder(?Order $main_order): static
    {
        $this->main_order = $main_order;

        return $this;
    }

    public function getOrderLineStatus(): ?OrderLineStatus
    {
        return $this->order_line_status;
    }

    public function setOrderLineStatus(?OrderLineStatus $order_line_status): static
    {
        $this->order_line_status = $order_line_status;

        return $this;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): static
    {
        $this->qty = $qty;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): static
    {
        $this->employee = $employee;

        return $this;
    }
}
