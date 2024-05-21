<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class DetallesOrden
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', name:'detalles_orden_id')]
    private ?int $detalles_orden_id = null;

    #[ORM\ManyToOne(targetEntity: Ordenes::class, inversedBy: 'detallesOrden')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ordenes $orden = null;

    #[ORM\ManyToOne(targetEntity: Productos::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Productos $producto = null;

    #[ORM\Column(type: 'integer')]
    private ?int $cantidad = null;

    #[ORM\Column(type: 'float')]
    private ?float $precioUnitario = null;

    // Getters y Setters

    public function getDetallesOrdenId(): ?int
    {
        return $this->detalles_orden_id;
    }

    public function getOrden(): ?Ordenes
    {
        return $this->orden;
    }

    public function setOrden(?Ordenes $orden): self
    {
        $this->orden = $orden;

        return $this;
    }

    public function getProducto(): ?Productos
    {
        return $this->producto;
    }

    public function setProducto(?Productos $producto): self
    {
        $this->producto = $producto;

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
