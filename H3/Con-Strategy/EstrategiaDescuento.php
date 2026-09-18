<?php

declare(strict_types=1);

namespace App\ConStrategy;

interface EstrategiaDescuento
{
    public function calcularDescuento(Venta $venta): float;
}
