<?php

declare(strict_types=1);

namespace App\ConStrategy;

final class SinDescuento implements EstrategiaDescuento
{
    public function calcularDescuento(Venta $venta): float
    {
        return 0.0;
    }
}
