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

    public function getOrdenesId(): ?int
    {
        return $this->ordenes_id;
    }

    public function getUsuario(): ?Usuarios
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuarios $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Collection|DetallesOrden[]
     */
    public function getDetallesOrden(): Collection
    {
        return $this->detallesOrden;
    }

    public function addDetallesOrden(DetallesOrden $detallesOrden): self
    {
        if (!$this->detallesOrden->contains($detallesOrden)) {
            $this->detallesOrden[] = $detallesOrden;
            $detallesOrden->setOrden($this);
        }

        return $this;
    }

    public function removeDetallesOrden(DetallesOrden $detallesOrden): self
    {
        if ($this->detallesOrden->removeElement($detallesOrden)) {
            // set the owning side to null (unless already changed)
            if ($detallesOrden->getOrden() === $this) {
                $detallesOrden->setOrden(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Productos[]
     */
    public function getProductos(): Collection
    {
        return $this->productos;
    }

    public function addProducto(Productos $producto): self
    {
        if (!$this->productos->contains($producto)) {
            $this->productos[] = $producto;
        }

        return $this;
    }

    public function removeProducto(Productos $producto): self
    {
        $this->productos->removeElement($producto);

        return $this;
    }
}
