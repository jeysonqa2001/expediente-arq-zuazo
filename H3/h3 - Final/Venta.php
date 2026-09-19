<?php

declare(strict_types=1);

namespace App\ConFinal;

final class Venta
{
    /** @var ItemVenta[] */
    private array $items = [];

    /** @var ObservadorVenta[] */
    private array $observadores = [];

    private bool $confirmada = false;
    private bool $pagoAprobado = false;

    public function __construct(
        private readonly int $idVenta,
        private readonly Usuario $usuario,
        private readonly \DateTimeImmutable $fecha,
        private readonly ProcesadorPago $procesador // <- se recibe ya construido (Adapter incluido)
    ) {
    }

    public function suscribir(ObservadorVenta $observador): void
    {
        $this->observadores[] = $observador;
    }

    private function notificar(): void
    {
        foreach ($this->observadores as $observador) {
            $observador->alConfirmarVenta($this);
        }
    }

    public function confirmar(): bool
    {
        if ($this->confirmada) {
            throw new \RuntimeException('Esta venta ya fue confirmada.');
        }

        if ($this->items === []) {
            throw new \RuntimeException('No se puede confirmar una venta sin items.');
        }

        echo "Intentando cobrar la venta #{$this->idVenta}...\n";

        $this->pagoAprobado = $this->procesador->procesar($this->calcularTotal());

        if (!$this->pagoAprobado) {
            echo "Pago RECHAZADO. La venta NO se confirma, no se notifica a nadie.\n";
            return false;
        }

        $this->confirmada = true;
        echo "Pago APROBADO. Confirmando venta y notificando...\n";
        $this->notificar();

        return true;
    }

    public function estaConfirmada(): bool
    {
        return $this->confirmada;
    }

    public function getPagoAprobado(): bool
    {
        return $this->pagoAprobado;
    }

    // ---------------- Comportamiento heredado de la base ----------------

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
