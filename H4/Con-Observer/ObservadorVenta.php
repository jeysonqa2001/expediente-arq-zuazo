<?php

declare(strict_types=1);

namespace App\ConObserver;

interface ObservadorVenta
{
    public function alConfirmarVenta(Venta $venta): void;
}
