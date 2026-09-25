# Karu Esencial en WordPress

Implementación del diseño en https://www.karuesencial.cl con WordPress, Blocksy (gratis),
Elementor (gratis) y WPForms Lite.

## Qué hay en el sitio

| Elemento | Dónde se edita |
|---|---|
| Páginas Inicio, Productos, Beneficios, Preguntas frecuentes y Contacto | Elementor (plantilla "Elementor ancho completo", cabecera y pie de Blocksy) |
| Colores y tipografías (Nunito + Figtree) | Elementor → Ajustes del sitio (colores y tipografías globales) y Blocksy → Personalizar → Colores / Tipografía |
| Cabecera: logo, menú y botón "Pedir por WhatsApp"; menú móvil | Apariencia → Personalizar → Cabecera (Blocksy) |
| Pie: logo, descripción, navegación, productos, contacto, copyright y WhatsApp | Apariencia → Personalizar → Pie de página (Blocksy) y Apariencia → Widgets (Pie 1 a 4) |
| Menú "Menú principal Karu" | Apariencia → Menús (cabecera, móvil y pie) |
| Botón flotante de WhatsApp | Elementor → Elementos flotantes → "WhatsApp Karu Esencial" (todo el sitio) |
| Formulario "Contacto Karu Esencial" | WPForms → Todos los formularios |
| Página de inicio | Ajustes → Lectura → Página estática "Inicio" |

Todo el contenido usa Containers y widgets nativos de Elementor Free (Título, Editor de
texto, Botón, Imagen, Lista de iconos, Caja de icono, Icono y Acordeón anidado), más el
widget de WPForms. No hay widgets HTML ni CSS personalizado.

## Regenerar la estructura

`build_elementor.py` genera `elementor/*.json` (el `_elementor_data` de cada página).
El argumento es el ID del formulario de WPForms:

```bash
python3 wordpress/build_elementor.py 70
```

Las imágenes de productos son ilustraciones referenciales: se reemplazan desde el widget
Imagen de cada tarjeta cuando existan fotos reales.
