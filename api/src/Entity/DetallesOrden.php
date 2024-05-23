<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity]
class DetallesOrden
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name:'detalles_orden_id')]
    private ?int $detalles_orden_id = null;

    #[ORM\ManyToOne(targetEntity: Ordenes::class)]
    #[ORM\JoinColumn(name: "ordenes_id", referencedColumnName: "ordenes_id", nullable: false)]
    private ?Ordenes $ordenes_id = null;

    #[ORM\ManyToOne(targetEntity: Productos::class)]
    #[ORM\JoinColumn(name: "productos_id", referencedColumnName: "productos_id", nullable: false)]
    private ?Productos $productos_id = null;

    #[ORM\Column(type: 'integer')]
    private ?int $cantidad = null;

    #[ORM\Column(type: 'float')]
    private ?float $precioUnitario = null;

    // Getters y Setters

    #[SerializedName("detalles_orden_id")]
    public function getDetallesOrdenId(): ?int
    {
        return $this->detalles_orden_id;
    }

    public function getOrden(): ?Ordenes
    {
        return $this->ordenes_id;
    }

    public function setOrden(?Ordenes $ordenes_id): self
    {
        $this->ordenes_id = $ordenes_id;

        return $this;
    }

    public function getProducto(): ?Productos
    {
        return $this->productos_id;
    }

    public function setProducto(?Productos $productos_id): self
    {
        $this->productos_id = $productos_id;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getPrecioUnitario(): ?float
    {
        return $this->precioUnitario;
    }

    public function setPrecioUnitario(float $precioUnitario): self
    {
        $this->precioUnitario = $precioUnitario;

        return $this;
    }
}
