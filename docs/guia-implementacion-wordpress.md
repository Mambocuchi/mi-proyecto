# Karu Esencial — Guía de implementación en WordPress

Esta guía traduce el diseño de `index.html` a **WordPress + Blocksy (gratis) + Elementor (gratis)**.
Todo lo que aparece en el diseño se puede construir sin Elementor Pro ni Blocksy Pro, y sin
plugins premium. El diseño tampoco depende de Novamira: el plugin se puede usar en paralelo sin
que la página necesite ninguna de sus funciones.

---

## 1. Sistema visual

### Colores (Blocksy → Personalizar → Colores → Paleta global)

| Nombre | Hex | Uso |
|---|---|---|
| Azul principal | `#4A90E2` | Botones, enlaces, acentos, fondo del CTA final |
| Azul hover | `#3A7DCB` | Estado hover de botones |
| Celeste claro | `#B8E0FF` | Íconos de beneficios, burbuja de chat, detalles |
| Blanco | `#FFFFFF` | Fondo principal, tarjetas |
| Celeste suave | `#EDF6FF` | Fondo de Beneficios, footer, etiquetas |
| Blanco cálido | `#FAF8F4` | Fondo de Testimonios y bloque "Próximamente" |
| Gris claro | `#E4ECF4` | Bordes y divisores |
| Gris azulado | `#5B6C82` | Texto secundario |
| Azul oscuro | `#243D5B` | Títulos y texto (tomado del logotipo) |
| Verde WhatsApp | `#25D366` | Solo el botón flotante y el ícono de WhatsApp |

El verde de las hojas del logo (`#5A932A`) solo aparece en detalles mínimos (ícono de hoja del
titular). No se agregan otros colores.

En **Elementor → Configuración del sitio → Colores globales** crea los mismos colores para
reutilizarlos en cada widget (función incluida en Elementor Free).

### Tipografía (Google Fonts, ambas disponibles en Elementor Free y Blocksy)

| Rol | Fuente | Peso | Tamaño escritorio / móvil |
|---|---|---|---|
| H1 (Hero) | Nunito | 900 | 68 px / 40 px, interlineado 1.1, espaciado −0.025em |
| H2 (secciones) | Nunito | 800 | 46 px / 32 px |
| H3 (tarjetas) | Nunito | 800 | 22 px |
| Etiqueta superior (eyebrow) | Nunito | 800 | 13 px, MAYÚSCULAS, espaciado 0.16em, color Azul principal |
| Texto | Figtree | 400 | 17 px / 16 px, interlineado 1.65 |
| Botones | Figtree | 700 | 16–17 px |

Nunito tiene terminaciones redondeadas que conversan con las letras del logo. Figtree es muy
legible en pantallas pequeñas.

### Forma

- Tarjetas: radio 20 px, borde 1 px `#E4ECF4`, sombra muy suave.
- Bloques grandes (hero, CTA final, Próximamente): radio 32 px.
- Botones: forma de píldora (radio 999 px), alto mínimo 48 px (54 px los principales).
- Espacio vertical entre secciones: 128 px en escritorio, 64 px en móvil.
- Ancho máximo del contenido: 1180 px.

### Logotipo

- Usar `assets/img/logo-karu-esencial.webp` (fondo transparente, solo se recortó el margen
  vacío; proporciones, colores y composición intactos). `logo-karu-esencial-original.webp` es el
  archivo tal como se entregó.
- Altura en el header: 56 px en escritorio y 48 px en móvil. En el footer: 72 px.
- Siempre sobre fondos claros (blanco o celeste suave). No deformar, recolorear ni rodear con
  otros elementos.

---

## 2. Estructura, sección por sección

Convención: en Elementor usar **Contenedores** (Flexbox), que están en Elementor Free.
Las clases CSS indicadas se escriben en *Avanzado → Clases CSS* de cada contenedor o widget.

### 1. Header — Blocksy Header Builder (no Elementor)
El widget "Nav Menu" de Elementor es Pro, así que el header se arma con el constructor de header
de Blocksy Free:
- Fila principal: **Logo** (izquierda), **Menú** (derecha), **Botón** "Pedir por WhatsApp"
  → `https://wa.me/56989048914`, abrir en nueva pestaña.
- Menú (Apariencia → Menús): Inicio `#inicio`, Productos `#productos`, Beneficios `#beneficios`,
  Preguntas frecuentes `#preguntas`, Contacto `#contacto` (enlaces personalizados).
- Header fijo ("Sticky"): activarlo en Blocksy si la opción está disponible en la versión
  instalada; si no, el header queda estático sin afectar el diseño.
- Móvil: Blocksy trae el disparador del menú (hamburguesa) y el panel "Offcanvas". Agregar el
  mismo botón de WhatsApp dentro del offcanvas.

### 2. Hero — `id="inicio"`
Contenedor de 2 columnas (55/45), en móvil apilado.
- Columna texto: *Encabezado* eyebrow ("Esenciales para el hogar · Chile"), *Encabezado* H1
  (la frase "más simple." en Azul principal usando `<span>`), *Editor de texto*, dos *Botones*,
  *Lista de íconos* con 3 puntos (ícono `fas fa-check`).
- Columna imagen: *Imagen* con radio 32 px y sombra. La tarjeta flotante "¿Dudas?" es opcional
  (se puede omitir; en móvil está oculta).

### 3. Productos — `id="productos"`
- Encabezado centrado (eyebrow + H2 + texto).
- Contenedor de 3 columnas (2 en tablet, 1 en móvil). Cada tarjeta es un contenedor con clase
  `card product-card` que contiene: *Imagen* (proporción 5:4), etiqueta (texto pequeño con fondo
  celeste suave), H3, texto, título "Usos habituales", *Lista de íconos* y *Botón*
  "Consultar por WhatsApp" con el mensaje prellenado del producto.
- Nota pequeña bajo las tarjetas: "Lee siempre las indicaciones del envase…".
- Bloque **Próximamente**: contenedor con fondo Blanco cálido, radio 32 px. A la izquierda el
  texto; a la derecha 2 tarjetas (Aceite de Oliva, Café en Grano) con insignia "Próximamente" y
  enlace "Avísame por WhatsApp". Cuando un producto llegue, se duplica una tarjeta de producto y
  se elimina su tarjeta de "Próximamente".

### 4. Beneficios — `id="beneficios"`
Fondo Celeste suave. 4 columnas (2 en tablet, 1 en móvil con el ícono a la izquierda).
Widget **Caja de ícono** (Icon Box, Elementor Free). Íconos sugeridos de Font Awesome Free:
Versatilidad `fas fa-th-large`, Simpleza `fas fa-home`, Ahorro `fas fa-coins`,
Conciencia `fas fa-leaf`. Ícono sobre cuadrado redondeado Celeste claro.

### 5. Cómo comprar — `id="como-comprar"`
2 columnas. Izquierda: H2 + 3 pasos (01, 02, 03) + botón "Quiero comprar".
Los números usan Nunito 900 con color celeste y contorno azul (clase `step-num`; si se prefiere
sin CSS, usar Azul principal plano). Derecha: tarjeta con ejemplo de mensaje de WhatsApp
(se oculta en móvil). Solo muestra el mensaje del cliente: no inventa respuestas de la empresa.

### 6. Testimonios — `id="testimonios"`
Estructura preparada **sin testimonios inventados**. Mientras no existan testimonios reales:
tarjetas con borde punteado y el texto "Espacio para testimonio", más el enlace
"¿Ya compraste? Cuéntanos tu experiencia" a WhatsApp.
Cuando haya testimonios reales y autorizados, reemplazar cada tarjeta por: comillas, texto,
nombre y comuna/producto (Elementor Free incluye el widget **Testimonio**).
Opción válida: ocultar la sección completa hasta tener testimonios.

### 7. Preguntas frecuentes — `id="preguntas"`
2 columnas: a la izquierda título + botón "Consultar por WhatsApp"; a la derecha widget
**Acordeón** (Elementor Free) con las 6 preguntas. Primera pregunta abierta por defecto.
Las respuestas no incluyen precios, formatos ni zonas de entrega inventados: todas derivan a
WhatsApp.

### 8. CTA final
Contenedor con fondo Azul principal, radio 32 px, contenido centrado. H2 blanco
"¿Qué necesitas para tu hogar?", texto, botón blanco grande "Pedir por WhatsApp" con ícono
verde, número visible debajo. Los círculos decorativos son 3 contenedores vacíos con
`position: absolute` (opcional).

### 9. Contacto — `id="contacto"`
2 columnas: título a la izquierda; a la derecha una tarjeta destacada de WhatsApp y 3 tarjetas
pequeñas (Teléfono `tel:+56989048914`, Entregas, Redes sociales). **Redes sociales**: reemplazar
`#` por los perfiles reales o eliminar la tarjeta si aún no existen.

### 10. Footer — Blocksy Footer Builder o Elementor
4 columnas: logo + descripción + íconos sociales; Navegación; Productos; Contacto + botón.
Fila inferior: copyright y enlaces legales (Política de privacidad, Términos y condiciones:
crear esas páginas o quitar los enlaces).

### Botón flotante de WhatsApp
Widget **HTML** de Elementor Free (o bloque HTML personalizado en el footer de Blocksy):

```html
<a class="wa-float" href="https://wa.me/56989048914" target="_blank" rel="noopener" aria-label="Pedir por WhatsApp">
  <svg viewBox="0 0 24 24" width="30" height="30" aria-hidden="true"><!-- pegar aquí el path del ícono de WhatsApp de index.html --></svg>
</a>
```
Estilos: ver `.wa-float` en `assets/css/karu.css`.

---

## 3. CSS personalizado

Elementor Free **no** tiene CSS personalizado por widget (es Pro). Por eso el CSS va en
**Apariencia → Personalizar → CSS adicional** (función estándar de WordPress):

1. Copiar de `assets/css/karu.css` solo los bloques que se usen (tokens `:root`, botones,
   `.card`, `.tag`, `.uses`, `.step-num`, `.faq`, `.wa-float`, `.testimonial.is-empty`).
2. Asignar las clases en *Avanzado → Clases CSS* de cada elemento.
3. Anclas de sección: *Avanzado → ID CSS* (`inicio`, `productos`, `beneficios`,
   `como-comprar`, `testimonios`, `preguntas`, `contacto`).

JavaScript: no es necesario. El menú móvil lo resuelve Blocksy y el acordeón lo resuelve
Elementor. `assets/js/karu.js` existe solo para que el prototipo HTML funcione por sí mismo.

## 4. Animaciones

Usar *Avanzado → Efectos de movimiento → Animación de entrada* (Elementor Free):
"Fade In Up", duración "Rápida", solo en tarjetas y bloques. Nada de parallax ni efectos de
scroll (son Pro). Respetar la opción de movimiento reducido del sistema.

## 5. Enlaces de WhatsApp

Todos apuntan a `https://wa.me/56989048914`. Algunos agregan un mensaje prellenado
(`?text=...`) para que el cliente no tenga que escribir desde cero:

| Ubicación | Mensaje prellenado |
|---|---|
| Header, CTA final, contacto, flotante | (sin mensaje) |
| Hero | Hola Karu Esencial, quiero hacer un pedido. |
| Vinagre / Percarbonato / Bicarbonato | Hola Karu Esencial, quiero consultar por el [producto]. |
| Próximamente | Hola Karu Esencial, avísenme cuando llegue el [producto]. |
| Cómo comprar | Hola Karu Esencial, quiero comprar. |
| FAQ | Hola Karu Esencial, tengo una consulta. |
| Testimonios | Hola Karu Esencial, quiero compartir mi experiencia con sus productos. |

Si se prefiere el enlace simple en todos los botones, basta con borrar desde `?text=`.

## 6. Dirección fotográfica

Las ilustraciones SVG de `assets/img/` marcan la composición, el encuadre y la paleta de cada
imagen. Deben reemplazarse por fotografías reales de los productos Karu Esencial.

- **Estilo**: lifestyle + editorial + producto. Luz natural de ventana, lateral y suave. Fondos
  claros (blanco, celeste muy pálido), madera clara, cerámica blanca, textiles de algodón.
- **Hero** (600×560 aprox., horizontal o cuadrado): los tres productos sobre un mesón de madera
  clara, con una rama verde en un florero y paños doblados. Espacio limpio arriba.
- **Tarjetas de producto** (proporción 5:4): un producto por foto, centrado, con un solo objeto
  de apoyo (esponja, bowl de cerámica, cuchara de madera).
- **Próximamente** (5:3): aceite de oliva con rama de olivo y pocillo; café en grano con taza de
  cerámica y granos sobre la mesa. Misma luz y mismos materiales que los de limpieza, para que
  todo se vea parte de una misma marca.
- **Evitar**: guantes de látex, fondos de laboratorio, envases industriales, estudio con fondo
  negro, filtros saturados.
- **Formato web**: WebP, máx. 1600 px de lado, menos de 250 KB por imagen.

## 7. Contenido pendiente de confirmar

No se inventó información. Antes de publicar, confirmar o completar:
- Formatos y precios (hoy se consultan por WhatsApp).
- Zonas de entrega.
- Perfiles de redes sociales.
- Testimonios reales con autorización.
- Páginas legales.
- Usos de cada producto según la ficha técnica y la etiqueta del proveedor (los usos del diseño
  son usos domésticos habituales, sin afirmaciones médicas ni ecológicas).
