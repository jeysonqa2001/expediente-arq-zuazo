<?php

declare(strict_types=1);

namespace App\ConObserver;

/**
 * Usuario
 *
 * SRP: esta clase solo se encarga de representar los datos de un
 * usuario del sistema. No sabe nada de ventas, ni de pagos, ni de
 * inventario. Esa separación es lo que permite que, mas adelante,
 * los patrones (Factory, Adapter, Builder) se apliquen sobre Venta
 * o sobre el procesamiento de pagos sin tener que tocar Usuario.
 */
final class Usuario
{
    public function __construct(
        private readonly int $idUsuario,
        private readonly string $nombre,
        private readonly string $email
    ) {
    }

    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
