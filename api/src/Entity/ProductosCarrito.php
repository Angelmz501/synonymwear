<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ProductosCarrito
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $productos_carrito_id = null;

    #[ORM\ManyToOne(targetEntity: CarritoCompras::class, inversedBy: 'productosCarrito')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CarritoCompras $carrito = null;

    #[ORM\ManyToOne(targetEntity: Productos::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Productos $producto = null;

    #[ORM\Column(type: 'integer')]
    private ?int $cantidad = null;

    // Getters y Setters

    public function getProductosCarritoId(): ?int
    {
        return $this->productos_carrito_id;
    }

    public function getCarrito(): ?CarritoCompras
    {
        return $this->carrito;
    }

    public function setCarrito(?CarritoCompras $carrito): self
    {
        $this->carrito = $carrito;

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
}
