<?php

declare(strict_types=1);

namespace App\ConObserver;

final class Venta
{
    /** @var ItemVenta[] */
    private array $items = [];

    /** @var ObservadorVenta[] */
    private array $observadores = [];

    private bool $confirmada = false;

    public function __construct(
        private readonly int $idVenta,
        private readonly Usuario $usuario,
        private readonly \DateTimeImmutable $fecha
    ) {
    }

    // ---------------- Parte del patron Observer ----------------

    public function suscribir(ObservadorVenta $observador): void
    {
        $this->observadores[] = $observador;
    }

    public function desuscribir(ObservadorVenta $observador): void
    {
        foreach ($this->observadores as $i => $suscrito) {
            if ($suscrito === $observador) {
                unset($this->observadores[$i]);
            }
        }
        $this->observadores = array_values($this->observadores);
    }

    
    private function notificar(): void
    {
        foreach ($this->observadores as $observador) {
            $observador->alConfirmarVenta($this);
        }
    }

    public function confirmar(): void
    {
        if ($this->confirmada) {
            throw new \RuntimeException('Esta venta ya fue confirmada.');
        }

        if ($this->items === []) {
            throw new \RuntimeException('No se puede confirmar una venta sin items.');
        }

        $this->confirmada = true;
        $this->notificar();
    }

    public function estaConfirmada(): bool
    {
        return $this->confirmada;
    }


    public function agregarItem(ItemVenta $item): void
    {
        if ($this->confirmada) {
            throw new \RuntimeException('No se pueden agregar items a una venta ya confirmada.');
        }
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
}
