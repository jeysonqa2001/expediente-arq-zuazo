# ADR-0001: Usar el patrón Adapter para integrar la pasarela de pago externa

## Contexto
El Sistema de Tienda de Alimentos necesita cobrar ventas en línea usando una
**pasarela de pago externa**. Esa pasarela expone su propia
interfaz, con su propio formato de datos y sus propios métodos, que no
tiene por qué coincidir con cómo nuestra Lógica de negocio quiere trabajar
internamente (por ejemplo, nuestras clases de Venta usan un formato propio
de monto, moneda y método de pago).

Si la Lógica de negocio llama **directamente** a los métodos de la pasarela,
quedamos acoplados a esa API puntual: cualquier cambio en la pasarela (o si
el día de mañana cambiamos de proveedor) obliga a tocar código en varios
lugares de la lógica de venta, violando el principio de responsabilidad
única y el de abierto/cerrado (SOLID).

## Decisión
Se introduce una clase **`AdaptadorPasarelaTarjeta`** que implementa una
interfaz propia del sistema (ej. `PasarelaDePago`) y por dentro traduce esas
llamadas al formato específico que exige la pasarela externa real.

La Lógica de negocio solo conoce la interfaz `PasarelaDePago`; nunca habla
directamente con la API externa. El Adaptador es el único punto de contacto
con el mundo exterior.

## Alternativas consideradas

1. **Llamar a la API de la pasarela directamente desde la Lógica de negocio.**
   Descartada: acopla fuertemente el núcleo del sistema a un proveedor
   específico y mezcla reglas de negocio con detalles de integración.

2. **Poner la lógica de traducción dentro de cada caso de uso que cobra
   (duplicar la conversión en varios lugares).**
   Descartada: viola DRY y hace que un cambio en la pasarela obligue a
   modificar múltiples clases en lugar de una sola.

## Consecuencias

**Positivas**
- La Lógica de negocio queda desacoplada del proveedor de pago concreto.
- Si mañana cambiamos de pasarela, solo se reemplaza/agrega un nuevo
  Adaptador; el resto del sistema no se toca.
- Facilita testear la lógica de venta con un Adaptador falso (mock), sin
  depender de la pasarela real.

**Negativas / costos**
- Se agrega una capa extra de indirección (una clase más) para un caso que,
  si solo hubiera un proveedor para siempre, podría resolverse más directo.
- Hay que mantener la interfaz `PasarelaDePago` sincronizada si la pasarela
  agrega funcionalidades nuevas que queremos aprovechar.