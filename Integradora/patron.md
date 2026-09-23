# Parte 3 - El Patron de Diseno
Se requiere que un vehiculo que tiene mas de 24 horas, el dueño reciba un aviso por cada vehiculo que supere las 24h de estadia.
Se utilizo el Patron Observer

```php
<?php

namespace Integradora\Parqueo;

interface IObservadorEstadia 
{
    public function notificarExcesoTiempo(string $placa, int$horas): void;
}

class WhatsAppDelEdificio implements IObservadorEstadia 
{
    public function notificarExcesoTiempo(string $placa, int$horas): void 
    {
        echo "[ALERTA 24H] Vehiculo {$placa} supero las {$horas} horas en el parqueo." . PHP_EOL;
    }
}

class Estadia 
{
    private array $observadores = [];

    public function agregarObservador(IObservadorEstadia $observador): void 
    {
        $this->observadores[] =$observador;
    }

    public function verificarTiempo(string $placa, int$horas): void 
    {
        if ($horas > 24) {
            foreach ($this->observadores as $obs) {$obs->notificarExcesoTiempo($placa,$horas);
            }
        }
    }
}