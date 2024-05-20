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
}
