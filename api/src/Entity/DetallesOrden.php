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
}
