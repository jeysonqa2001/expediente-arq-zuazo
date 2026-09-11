<?php

declare(strict_types=1);

namespace App\ConFactory;

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
