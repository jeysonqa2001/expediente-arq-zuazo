## EVALUACION INTEGRADORA - VARIANTE B
## PARQUEO TORRE CENTAL

```mermaid
classDiagram
    %% Jeyson Wilfredo Zuazo Mamani

    class TipoVehiculo {
        <<enumeration>>
        AUTO
        MOTO
        RESIDENTE
    }

    class EstadoEstadia {
        <<enumeration>>
        EN_CURSO
        POR_PAGAR
        PAGADA
        ANULADA
    }

    class Vehiculo {
        -string placa
        -TipoVehiculo tipo
        +getTipo() TipoVehiculo
    }

    class Estadia {
        -DateTime horaEntrada
        -DateTime horaSalida
        -EstadoEstadia estado
        -decimal montoTotal
        +calcularMonto() float
        +anular() void
    }

    class Tarifa {
        -float precioPorHora
        +actualizarTarifa(float nuevoPrecio) void
    }

    class Usuario {
        <<abstract>>
        #string id
        #string nombre
    }

    class Portero {
        +registrarEntrada(Vehiculo v) Estadia
        +registrarSalida(Estadia e) void
    }

    class Administrador {
        +ajustarTarifa(Tarifa t, float precio) void
        +anularEstadia(Estadia e) void
        +generarReporteIngresos() Reporte
    }

    class IObservadorEstadia {
        <<interface>>
        +notificarExcesoTiempo(string placa, float horas) void
    }

    class ServicioNotificacionOwner {
        +notificarExcesoTiempo(string placa, float horas) void
    }

    Usuario <|-- Portero : Hereda
    Usuario <|-- Administrador : Hereda
    Estadia "1" --> "1" Vehiculo : Registra
    Estadia "1" --> "1" EstadoEstadia : Posee
    Vehiculo "1" --> "1" TipoVehiculo : Clasificado como
    Administrador ..> Tarifa : Ajusta
    ServicioNotificacionOwner ..|> IObservadorEstadia : Implementa
    Estadia "1" o-- "*" IObservadorEstadia : Notifica (> 24h)