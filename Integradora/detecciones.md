# PARTE #2

1. **SRP:** La clase `GestorDeEstadias` asume multiples responsabilidades al calcular la tarifa, guardar la estadia en la base de datos, imprimir el ticket por consola y enviar la notificacion de salida.
2. **OCP:** El metodo `RegistrarSalida` evalua los tipos de vehiculo con un condicional `switch` sobre un `string`; para modificar precios o agregar una tarifa nueva se debe editar la clase directamente en lugar de extenderla.
3. **DIP:** `GestorDeEstadias` instancia directamente las clases concretas `BaseDeDatosParqueo` y `WhatsAppDelEdificio` con el operador `new`, dependiendo de modulos de bajo nivel en lugar de depender de abstracciones.