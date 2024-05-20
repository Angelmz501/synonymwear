<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class CarritoCompras
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $carrito_id = null;

    #[ORM\OneToOne(inversedBy: 'carritoCompras', targetEntity: Usuarios::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuarios $usuario = null;

    #[ORM\Column(type: 'float')]
    private ?float $total = null;

    #[ORM\OneToMany(mappedBy: 'carrito', targetEntity: ProductosCarrito::class)]
    private Collection $productosCarrito;

    public function __construct()
    {
        $this->productosCarrito = new ArrayCollection();
    }

    // Getters y Setters
}
