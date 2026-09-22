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

    class GestorDeEstadias {
        +registrarEntrada(string placa, string tipo) void
        +registrarSalida(string placa, string tipoVehiculo, int horas) void
    }

    class IRepositorioEstadias {
        <<interface>>
        +guardarEstadia(string placa, string tipo, int horas, decimal total) void
    }

    class BaseDeDatosParqueo {
        +guardarEstadia(string placa, string tipo, int horas, decimal total) void
    }

    class IObservadorEstadia {
        <<interface>>
        +notificarExcesoTiempo(string placa, float horas) void
    }

    class WhatsAppDelEdificio {
        +enviar(string mensaje) void
        +notificarExcesoTiempo(string placa, float horas) void
    }

    class Tarifa {
        -decimal tarifaPorHora
        +actualizarTarifa(decimal tarifa) void
    }

    BaseDeDatosParqueo ..|> IRepositorioEstadias : Implementa
    WhatsAppDelEdificio ..|> IObservadorEstadia : Implementa
    GestorDeEstadias --> IRepositorioEstadias : Usa
    GestorDeEstadias --> IObservadorEstadia : Notifica
    GestorDeEstadias ..> TipoVehiculo : Utiliza
    GestorDeEstadias ..> EstadoEstadia : Utiliza
    GestorDeEstadias ..> Tarifa : Consulta