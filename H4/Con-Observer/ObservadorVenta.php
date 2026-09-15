<?php

declare(strict_types=1);

namespace App\ConObserver;

/**
 * ObservadorVenta (contrato del Observer)
 *
 * Cualquier clase que quiera "enterarse" de que se confirmo una
 * venta solo tiene que implementar esta interfaz. Venta no sabe ni
 * le importa quien la implementa: puede haber 1, 2 o 10
 * observadores, y Venta ni se entera de sus nombres.
 *
 * ISP: el contrato es minimo, un solo metodo. No obliga a nadie a
 * implementar cosas que no necesita.
 */
interface ObservadorVenta
{
    /**
     * Se llama cuando la venta queda confirmada.
     * Recibe la venta completa para que cada observador saque de
     * ella lo que le interese (el total, los items, el cliente...).
     */
    public function alConfirmarVenta(Venta $venta): void;
}
