<?php

declare(strict_types=1);

namespace App\ConBuilder;

final class VentaBuilder
{
    private ?int $idVenta = null;
    private ?Usuario $usuario = null;
    private ?\DateTimeImmutable $fecha = null;

    /** @var array{producto: Producto, cantidad: int}[] */
    private array $lineasPendientes = [];

    public function paraVenta(int $idVenta): self
    {
        $this->idVenta = $idVenta;
        return $this;
    }

    public function paraUsuario(Usuario $usuario): self
    {
        $this->usuario = $usuario;
        return $this;
    }

    public function conFecha(\DateTimeImmutable $fecha): self
    {
        $this->fecha = $fecha;
        return $this;
    }

    public function agregarItem(Producto $producto, int $cantidad): self
    {
        $this->lineasPendientes[] = ['producto' => $producto, 'cantidad' => $cantidad];
        return $this;
    }

    public function build(): Venta
    {
        if ($this->idVenta === null || $this->usuario === null || $this->fecha === null) {
            throw new \RuntimeException(
                'Faltan datos obligatorios: idVenta, usuario y fecha son requeridos antes de build().'
            );
        }

        $venta = new Venta($this->idVenta, $this->usuario, $this->fecha);

        $idItemAutoincremental = 1;
        foreach ($this->lineasPendientes as $linea) {
            $venta->agregarItem(new ItemVenta(
                idItem: $idItemAutoincremental,
                producto: $linea['producto'],
                cantidad: $linea['cantidad']
            ));
            $idItemAutoincremental++;
        }

        return $venta;
    }
}
