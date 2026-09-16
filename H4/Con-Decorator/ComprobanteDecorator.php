<?php

declare(strict_types=1);

namespace App\ConDecorator;

abstract class ComprobanteDecorator implements Comprobante
{
    public function __construct(protected readonly Comprobante $envuelto)
    {
    }

    public function generar(Venta $venta): string
    {
        return $this->envuelto->generar($venta);
    }
}
