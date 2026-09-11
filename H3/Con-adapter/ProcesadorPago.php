<?php

declare(strict_types=1);

namespace App\ConAdapter;

interface ProcesadorPago
{
    public function procesar(float $monto): bool;
}
