<?php

declare(strict_types=1);

namespace App\ConFinal;

interface ProcesadorPago
{
    public function procesar(float $monto): bool;
}
