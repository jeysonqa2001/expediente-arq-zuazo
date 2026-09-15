<?php

declare(strict_types=1);

namespace App\ConStrategy;

final class Venta
{
    /** @var ItemVenta[] */
    private array $items = [];

    private float $descuentoAplicado = 0.0;

    public function __construct(
        private readonly int $idVenta,
        private readonly Usuario $usuario,
        private readonly \DateTimeImmutable $fecha
    ) {
    }

    public function agregarItem(ItemVenta $item): void
    {
        $this->items[] = $item;
    }

    /** @return ItemVenta[] */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getIdVenta(): int
    {
        return $this->idVenta;
    }

    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }

    public function getFecha(): \DateTimeImmutable
    {
        return $this->fecha;
    }

    public function calcularTotal(): float
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            $total += $item->calcularSubtotal();
        }
        return $total;
    }

    // ---------------- Parte del patron Strategy ----------------

    public function aplicarEstrategiaDescuento(EstrategiaDescuento $estrategia): void
    {
        $this->descuentoAplicado = $estrategia->calcularDescuento($this);
    }

    public function getDescuentoAplicado(): float
    {
        return $this->descuentoAplicado;
    }

    public function calcularTotalConDescuento(): float
    {
        return $this->calcularTotal() - $this->descuentoAplicado;
    }
}
