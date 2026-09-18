# Modelo C4 — Sistema de Tienda de Alimentos

## Nivel 1 — Contexto (el sistema y su mundo)


**La pregunta que responde:** ¿quién usa el sistema y con qué otros sistemas habla?
Una caja para MI sistema; personas y sistemas externos alrededor. Nada de detalles internos.

```mermaid
%%{init: {'theme': 'neutral'}}%%
flowchart TD
    Cajero["👤 Cajero<br/>(registra ventas)"]
    Administrador["👤 Administrador<br/>(gestiona catálogo y stock)"]

    Sistema["🏪 SISTEMA DE TIENDA DE ALIMENTOS<br/>Registra ventas, aplica descuentos,<br/>controla stock y avisa cuando algo se agota"]

    Pasarela["💳 Pasarela de pago<br/>(externa)"]
    Correo["📧 Servicio de correo<br/>(externo)"]
    Cliente["👤 Cliente<br/>(recibe comprobantes y avisos)"]

    Cajero -->|registra ventas| Sistema
    Administrador -->|gestiona catálogo y stock| Sistema
    Sistema -->|cobra en línea| Pasarela
    Sistema -->|envía comprobantes y avisos| Correo
    Correo -->|entrega el aviso| Cliente
```
---

## Nivel 2 — Contenedores (el zoom adentro del sistema) — *borrador*

*Nota: este nivel es un borrador. El curso no exige bajar a nivel 3-4 (componentes/clases individuales) — esa parte ya está resuelta como código en `h3/`.*


**La pregunta que responde:** ¿de qué piezas ejecutables/almacenes está hecho el sistema?
Cada contenedor es algo que corre o almacena: la app, la base de datos, un servicio.

```mermaid
flowchart TD
    Cajero["👤 Cajero"]
    Administrador["👤 Administrador"]

    subgraph Sistema["🏪 SISTEMA DE TIENDA DE ALIMENTOS"]
        App["🌐 Aplicación<br/>PHP<br/>Pantallas de venta, stock y reportes"]
        Logica["⚙️ Lógica de negocio<br/>PHP<br/>Ventas, descuentos, control de stock<br/>(acá viven SOLID y los patrones)"]
        BD[("🗄️ Base de datos<br/>SQL<br/>Productos, ventas, movimientos")]
        Avisos["🔔 Servicio de avisos<br/>PHP<br/>Observer: publica stock-bajo<br/>a los suscriptores"]
    end

    Pasarela["💳 Pasarela de pago<br/>(externa)"]
    Correo["📧 Servicio de correo<br/>(externo)"]

    Cajero --> App
    Administrador --> App
    App --> Logica
    Logica --> BD
    Logica -->|publica evento stock-bajo| Avisos
    Logica -->|cobra en línea| Pasarela
    Avisos --> Correo
```