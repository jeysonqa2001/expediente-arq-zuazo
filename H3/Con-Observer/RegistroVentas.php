<?php

declare(strict_types=1);

namespace App\ConObserver;

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
