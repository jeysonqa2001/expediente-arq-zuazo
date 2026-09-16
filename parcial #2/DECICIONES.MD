# Parcial 2 P2.1

* **Situacion 1: Patron Observer (Observador)**
  Se usa Observer porque desacopla el modulo de prestamos de los notificadores (correo, morosidad, pantalla, multas)[cite: 1]. Si no se aplica, se viola el principio Open-Closed al tener que modificar el codigo core de prestamos cada vez que se agregue un nuevo interesado, lo que incrementa el riesgo de romper la logica de negocio existente con cada cambio que se aplice o ocurra.

* **Situacion 2: Patron Strategy (Estrategia)**
  Se usa Strategy para encapsular las reglas de calculo de multas en clases independientes (Infantil, Adulto, Tercera Edad). Si no se aplica, se mantiene codigo duplicado en multiples modulos mediante estructuras if-else rigidas, lo que provoca que cuando el concejo municipal cambie las reglas, haya que buscar y actualizar el codigo en varios lugares, rompiendo el principio de Responsabilidad Unica.

* **Situacion 3: Patron Adapter (Adaptador)**
  Se usa Adapter para convertir la interfaz incompatible del servicio externo estatal (PushRecord, fechas e idiomas distintos) a la interfaz requerida por el dominio de la biblioteca. Si no se aplica, el codigo del dominio se acoplaria directamente a un servicio externo, que no se puede modificar ya que cambia de version constantemente, forzando a reescribir la logica propia de la biblioteca con cada actualizacion externa.

---

## P2.3 La conexion SOLID

**Modulo implementado:** Situacion 2 (Patron Strategy).  
**Principio rescatado:** **Open/Closed Principle** y **Single Responsibility Principle**.  
**Evidencia en codigo:** En la interfaz `EstrategiaMulta` y la clase `CalculadoraMulta`. Al requerir una nueva regla de calculo, se crea una nueva clase implementando la interfaz sin tocar el contexto (`CalculadoraMulta`), permitiendo extender la funcionalidad del sistema sin modificar el codigo existente. Asimismo, cada tipo de socio calcula su multa de forma independiente (SRP).