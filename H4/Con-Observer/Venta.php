<?php

declare(strict_types=1);

namespace App\ConObserver;

/**
 * Venta (copia de base/Venta.php + Observer)
 *
 * Aqui Venta es el SUJETO (subject/observable) del patron.
 * El EVENTO de dominio es: "se confirmo la venta".
 *
 * Diferencia respecto a la base: ahora mantiene una lista de
 * observadores suscritos y, cuando se llama a confirmar(), les
 * avisa a todos.
 *
 * OCP: si mañana el negocio necesita que al confirmar una venta
 * tambien se emita una factura electronica, se crea una clase
 * nueva que implemente ObservadorVenta y se suscribe. Esta clase
 * Venta NO se modifica ni una linea.
 *
 * DIP: Venta depende de la abstraccion ObservadorVenta, nunca de
 * las clases concretas (NotificadorCliente, ControlInventario...).
 */
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

    /**
     * Dispara el EVENTO: avisa a todos los suscritos que la venta
     * quedo confirmada. Venta no sabe que hace cada uno con el
     * aviso, solo cumple con notificar.
     */
    private function notificar(): void
    {
        foreach ($this->observadores as $observador) {
            $observador->alConfirmarVenta($this);
        }
    }

    /**
     * Confirma la venta y dispara la notificacion a los observadores.
     */
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
