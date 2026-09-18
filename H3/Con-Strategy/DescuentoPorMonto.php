<?php

declare(strict_types=1);

namespace App\ConStrategy;

final class DescuentoPorMonto implements EstrategiaDescuento
{
    private const UMBRAL_MONTO = 200.0;
    private const PORCENTAJE_DESCUENTO = 0.10; // 10%

    public function calcularDescuento(Venta $venta): float
    {
        $total = $venta->calcularTotal();

        if ($total < self::UMBRAL_MONTO) {
            return 0.0;
        }

        return $total * self::PORCENTAJE_DESCUENTO;
    }
}
