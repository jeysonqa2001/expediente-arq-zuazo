<?php

declare(strict_types=1);

namespace App\ConFinal;


interface ObservadorVenta
{
    public function alConfirmarVenta(Venta $venta): void;
}
