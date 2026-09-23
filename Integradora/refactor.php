<?php
//Jeyson Wilfredo Zuazo Mamani

namespace Integradora\Parqueo;

interface IRepositorioEstadias 
{
    public function guardarEstadia(string $placa, string $tipo, int $horas, float $total): void;
}

interface INotificador 
{
    public function enviar(string $mensaje): void;
}

class BaseDeDatosParqueo implements IRepositorioEstadias 
{
    public function guardarEstadia(string $placa, string $tipo, int $horas, float $total): void 
    {
        echo "[BD] INSERT INTO estadias VALUES ('{$placa}', '{$tipo}', {$horas}, {$total})" . PHP_EOL;
    }
}

class WhatsAppDelEdificio implements INotificador 
{
    public function enviar(string $mensaje): void 
    {
        echo "[WHATSAPP] " . $mensaje . PHP_EOL;
    }
}

class GestorDeEstadias 
{
    private IRepositorioEstadias $repositorio;
    private INotificador $notificador;

    // Se cura la violacion DIP (Dependency Inversion Principle) inyectando abstracciones
    public function __construct(IRepositorioEstadias $repositorio, INotificador $notificador) 
    {
        $this->repositorio = $repositorio;
        $this->notificador = $notificador;
    }

    public function registrarSalida(string $placa, string $tipoVehiculo, int $horas): void 
    {
        $tarifaPorHora = match ($tipoVehiculo) {
            'auto' => 5.0,
            'moto' => 3.0,
            'residente' => 1.0,
            default => 5.0,
        };

        $total = $tarifaPorHora * $horas;

        $this->repositorio->guardarEstadia($placa, $tipoVehiculo, $horas, $total);

        echo "----- TICKET DE SALIDA -----" . PHP_EOL;
        echo "Placa {$placa}: {$horas} h como {$tipoVehiculo}" . PHP_EOL;
        echo "TOTAL: " . number_format($total, 2) . " Bs" . PHP_EOL;

        $this->notificador->enviar("Salida registrada: {$placa}, {$horas} h, " . number_format($total, 2) . " Bs");
    }
}

class Demo 
{
    public static function correr(): void 
    {
        $repo = new BaseDeDatosParqueo();
        $wa = new WhatsAppDelEdificio();
        $gestor = new GestorDeEstadias($repo, $wa);

        $gestor->registrarSalida("1234-ABC", "auto", 3);
    }
}