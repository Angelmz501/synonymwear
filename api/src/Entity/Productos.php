<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Productos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $productos_id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: 'text')]
    private ?string $descripcion = null;

    #[ORM\Column(type: 'float')]
    private ?float $precio = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $talla = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private ?int $cantidadInventario = null;

    #[ORM\ManyToOne(targetEntity: Categorias::class, inversedBy: 'productos')]
    private ?Categorias $categoria = null;

    #[ORM\OneToMany(mappedBy: 'producto', targetEntity: HistorialInventario::class)]
    private Collection $historialInventario;

    #[ORM\ManyToMany(targetEntity: Ordenes::class, mappedBy: 'productos')]
    private Collection $ordenes;

    public function __construct()
    {
        $this->historialInventario = new ArrayCollection();
        $this->ordenes = new ArrayCollection();
    }

    // Getters y Setters

    public function getProductosId(): ?int
    {
        return $this->productos_id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getTalla(): ?string
    {
        return $this->talla;
    }

    public function setTalla(?string $talla): self
    {
        $this->talla = $talla;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getCantidadInventario(): ?int
    {
        return $this->cantidadInventario;
    }

    public function setCantidadInventario(int $cantidadInventario): self
    {
        $this->cantidadInventario = $cantidadInventario;

        return $this;
    }

    public function getCategoria(): ?Categorias
    {
        return $this->categoria;
    }

    public function setCategoria(?Categorias $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * @return Collection|HistorialInventario[]
     */
    public function getHistorialInventario(): Collection
    {
        return $this->historialInventario;
    }

    public function addHistorialInventario(HistorialInventario $historialInventario): self
    {
        if (!$this->historialInventario->contains($historialInventario)) {
            $this->historialInventario[] = $historialInventario;
            $historialInventario->setProducto($this);
        }

        return $this;
    }

    public function removeHistorialInventario(HistorialInventario $historialInventario): self
    {
        if ($this->historialInventario->removeElement($historialInventario)) {
            // set the owning side to null (unless already changed)
            if ($historialInventario->getProducto() === $this) {
                $historialInventario->setProducto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ordenes[]
     */
    public function getOrdenes(): Collection
    {
        return $this->ordenes;
    }

    public function addOrden(Ordenes $orden): self
    {
        if (!$this->ordenes->contains($orden)) {
            $this->ordenes[] = $orden;
            $orden->addProducto($this);
        }

        return $this;
    }

    public function removeOrden(Ordenes $orden): self
    {
        if ($this->ordenes->removeElement($orden)) {
            $orden->removeProducto($this);
        }

        return $this;
    }
}
