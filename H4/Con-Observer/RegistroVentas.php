<?php

declare(strict_types=1);

namespace App\ConObserver;

/**
 * RegistroVentas (observador 3)
 *
 * Tercer observador, agregado justamente para demostrar el valor
 * del patron: NO hubo que modificar ni una linea de Venta para
 * sumarlo. Solo se creo esta clase y se suscribio en el demo.
 *
 * Lleva el acumulado del dia para el reporte de caja.
 *
 * SRP: solo acumula cifras. No manda correos ni toca inventario.
 */
final class RegistroVentas implements ObservadorVenta
{
    private int $cantidadVentas = 0;
    private float $montoAcumulado = 0.0;

    public function alConfirmarVenta(Venta $venta): void
    {
        $this->cantidadVentas++;
        $this->montoAcumulado += $venta->calcularTotal();

        $monto = number_format($venta->calcularTotal(), 2);
        $acumulado = number_format($this->montoAcumulado, 2);

        echo "[RegistroVentas] Venta #{$venta->getIdVenta()} registrada (Bs {$monto})\n";
        echo "   Acumulado del dia: {$this->cantidadVentas} ventas / Bs {$acumulado}\n";
    }

    public function getCantidadVentas(): int
    {
        return $this->cantidadVentas;
    }

    public function getMontoAcumulado(): float
    {
        return $this->montoAcumulado;
    }
}
