<?php

declare(strict_types=1);

namespace App\ConDecorator;

interface Comprobante
{
    public function generar(Venta $venta): string;
}
