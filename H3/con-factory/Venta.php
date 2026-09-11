<?php

declare(strict_types=1);

namespace App\ConFactory;

final class Venta
{
    /** @var ItemVenta[] */
    private array $items = [];

    private ProcesadorPago $procesador;

    public function __construct(
        private readonly int $idVenta,
        private readonly Usuario $usuario,
        private readonly \DateTimeImmutable $fecha,
        string $tipoPago
    ) {
        $this->procesador = FabricaPago::crear($tipoPago);
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

    public function procesarPago(): bool
    {
        return $this->procesador->procesar($this->calcularTotal());
    }
}
