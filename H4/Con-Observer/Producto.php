<?php

declare(strict_types=1);

namespace App\ConObserver;

/**
 * Producto
 *
 * SRP: solo conoce sus propios datos (id, sku, nombre, precio).
 * No calcula subtotales de venta ni conoce el inventario; eso es
 * responsabilidad de otras clases (ItemVenta, Inventario), lo cual
 * mantiene a Producto simple y reutilizable en cualquier contexto.
 */
final class Producto
{
    public function __construct(
        private readonly int $idProducto,
        private readonly string $sku,
        private readonly string $nombre,
        private readonly float $precio
    ) {
        if ($precio < 0) {
            throw new \InvalidArgumentException('El precio no puede ser negativo.');
        }
    }

    public function getIdProducto(): int
    {
        return $this->idProducto;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }
}
