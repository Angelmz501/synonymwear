<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity]
class HistorialInventario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $historial_inventario_id = null;

    #[ORM\ManyToOne(targetEntity: Productos::class)]
    #[ORM\JoinColumn(name: "productos_id", referencedColumnName: "productos_id", nullable: false)]
    private ?Productos $productos_id = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $fechaCambio = null;

    #[ORM\Column(type: 'integer')]
    private ?int $cantidadAnterior = null;

    #[ORM\Column(type: 'integer')]
    private ?int $cantidadNueva = null;

    // Getters y Setters

    #[SerializedName("historial_inventario_id")]
    public function getHistorialInventarioId(): ?int
    {
        return $this->historial_inventario_id;
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

    public function getFechaCambio(): ?\DateTimeInterface
    {
        return $this->fechaCambio;
    }

    public function setFechaCambio(?\DateTimeInterface $fechaCambio): self
    {
        $this->fechaCambio = $fechaCambio;
        return $this;
    }

    public function getCantidadAnterior(): ?int
    {
        return $this->cantidadAnterior;
    }

    public function setCantidadAnterior(?int $cantidadAnterior): self
    {
        $this->cantidadAnterior = $cantidadAnterior;
        return $this;
    }

    public function getCantidadNueva(): ?int
    {
        return $this->cantidadNueva;
    }

    public function setCantidadNueva(?int $cantidadNueva): self
    {
        $this->cantidadNueva = $cantidadNueva;
        return $this;
    }
}
