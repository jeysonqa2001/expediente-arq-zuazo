# PARCIAL 1 — ARQUITECTURA DE SOFTWARE · VARIANTE B (Ferreteria "El Tornillo")
**Lunes 7-sep-2026 · 19:10 a 20:40 (90 minutos) · 15 puntos · individual**

Se te entrega el archivo `examen-p1-B.cs`: el sistema de pedidos de una ferreteria. El codigo
FUNCIONA, pero su diseno tiene **4 violaciones de principios SOLID**.

## Que entregas (en tu repositorio, carpeta `parcial1/`, por commit)

### P1.1 — Detectar (5 puntos)
Un archivo `detecciones.md` con una tabla de 4 filas. Por cada violacion:
- que principio se viola (S, O, L/I o D),
- donde vive (clase y metodo),
- por que es una violacion (1 a 2 lineas con TUS palabras).

### P1.2 — Curar dos (6 puntos: 3 + 3)
Elegi DOS de las cuatro violaciones y corregilas EN CODIGO: un archivo `refactor.cs` con las
piezas nuevas (interfaces, clases partidas, constructor que recibe contratos — lo que tu cura
necesite). El resto del sistema puede quedar referenciado, pero tus dos curas deben estar
completas y coherentes. Podes escribir en C# o en tu lenguaje C-family de preferencia,
manteniendo los nombres del dominio.

### P1.3 — El plano (3 puntos)
`diagrama.png` (o .md con Mermaid, o foto legible de papel): el diagrama de clases del sistema
DESPUES de tus dos curas, con las interfaces marcadas como `<<interface>>` y tu nombre completo
visible dentro del diagrama.

### P1.4 — Entrega prolija (1 punto)
Carpeta `parcial1/` con los 3 artefactos y commit dentro de la ventana.

## Reglas
- **Ventana de commit:** hasta las 20:40. Tolerancia sin castigo hasta las 20:45.
  De 20:45 a 21:00 la nota tiene techo de 12. Despues de las 21:00 no se evalua.
- Trabajo **individual y sin IA**. Podes consultar el material del curso publicado
  en el tablon (codigo y guias). En la defensa final podes ser interrogado sobre cualquier linea de tu parcial.
- Tus dos curas llevan una firma en comentario: `// Refactor: <tu nombre completo>`.
- Pega el link de tu commit como entrega en la tarea de Classroom.

## Rubrica (publicada por anticipado)
| Item | Criterio | Puntos |
|---|---|---|
| P1.1 | 4 violaciones bien identificadas y argumentadas (1.25 c/u) | 5 |
| P1.2 | 2 curas completas y correctas: el principio queda de verdad restaurado (3 c/u) | 6 |
| P1.3 | Diagrama coherente con tus curas, interfaces marcadas, placa con tu nombre | 3 |
| P1.4 | Entrega completa, ordenada y en ventana | 1 |
| **Total** | | **15** |
