<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class HistorialInventario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $historial_inventario_id = null;

    #[ORM\ManyToOne(targetEntity: Productos::class, inversedBy: 'historialInventario')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Productos $producto = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $fechaCambio = null;

    #[ORM\Column(type: 'integer')]
    private ?int $cantidadAnterior = null;

    #[ORM\Column(type: 'integer')]
    private ?int $cantidadNueva = null;

    // Getters y Setters
}
