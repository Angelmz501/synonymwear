<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Ordenes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $ordenes_id = null;

    #[ORM\ManyToOne(targetEntity: Usuarios::class, inversedBy: 'ordenes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuarios $usuario = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $estado = null;

    #[ORM\Column(type: 'float')]
    private ?float $total = null;

    #[ORM\OneToMany(mappedBy: 'orden', targetEntity: DetallesOrden::class)]
    private Collection $detallesOrden;

    #[ORM\ManyToMany(targetEntity: Productos::class, inversedBy: 'ordenes')]
    private Collection $productos;

    public function __construct()
    {
        $this->detallesOrden = new ArrayCollection();
        $this->productos = new ArrayCollection();
    }

    // Getters y Setters
}
