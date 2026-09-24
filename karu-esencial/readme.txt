=== Karü Esencial ===

Tema de bloques (Full Site Editing) para la landing page de Karü Esencial,
emprendimiento de productos de limpieza naturales.

Requiere WordPress 6.6 o superior y PHP 7.4 o superior.


== Instalación ==

1. En WordPress ve a Apariencia > Temas > Añadir nuevo > Subir tema.
2. Sube el archivo karu-esencial.zip y haz clic en "Activar".
3. Al activarse, el tema crea automáticamente la página "Inicio" con la
   landing completa, le asigna la plantilla "Landing Karü Esencial (ancho
   completo)" y la define como portada del sitio (Ajustes > Lectura).
   Si ya tenías otra página de portada configurada, se respeta: en ese caso
   asigna "Inicio" como portada manualmente en Ajustes > Lectura.


== Actualizar desde una versión anterior ==

Sube el nuevo ZIP en Apariencia > Temas > Añadir nuevo > Subir tema y elige
"Reemplazar la instalada". Al entrar al escritorio, si la página "Inicio"
nunca fue editada, su contenido se actualiza automáticamente al nuevo diseño.
Si ya la editaste, no se toca: para usar el nuevo diseño, abre la página,
borra su contenido e inserta el patrón "Landing page completa" (categoría
Karü Esencial).


== Dónde se edita el diseño ==

* Contenido de la landing: Páginas > Inicio. Todo está hecho con bloques
  nativos (Grupo, Columnas, Imagen, Encabezado, Párrafo, Botones, Lista,
  Cita, Detalles, Separador, Iconos sociales y Navegación).
* Encabezado y pie de página: Apariencia > Editor > Patrones > Partes de plantilla.
* Colores, tipografías y tamaños: Apariencia > Editor > Estilos (theme.json).
* Estilos visuales: assets/css/styles.css (organizado por secciones).
* Cada sección también está disponible como patrón en el insertador, en la
  categoría "Karü Esencial", y la landing completa aparece como patrón
  inicial al crear una página nueva.


== Qué reemplazar antes de publicar ==

* Imágenes: las ilustraciones de assets/images son marcadores de posición.
  Selecciona cada bloque Imagen y usa "Reemplazar" para subir tus fotos
  (recomendado: WebP, 1200 px de ancho para el hero y 800 px para productos).
* Testimonios: los textos son ejemplos. Reemplázalos por opiniones reales
  de tus clientes.
* Pie de página: horarios, zona de despacho y el enlace de Facebook
  (actualmente https://www.facebook.com/).
* Preguntas frecuentes: medios de pago y condiciones de despacho.


== WhatsApp ==

Todos los botones apuntan a https://wa.me/56989048914 con un mensaje
prellenado. Para cambiar el número de forma global antes de activar el
tema, edita la constante KARU_ESENCIAL_WHATSAPP en functions.php. Después de
activarlo, los enlaces de la página "Inicio" se editan desde cada botón.


== Estructura ==

style.css            Cabecera del tema (sin estilos).
theme.json           Paleta, tipografías, tamaños, espaciados y plantillas.
functions.php        Carga de estilos, patrones, estilos de botón y página inicial.
assets/css/styles.css  Todo el CSS del tema.
assets/fonts/        Fraunces (normal y cursiva) y Plus Jakarta Sans (woff2 locales, OFL).
assets/images/       Logo, íconos e ilustraciones SVG.
templates/           index, page, single, 404 y page-landing.
parts/               header y footer.
patterns/            Secciones de la landing (PHP para rutas de imágenes).


== Créditos ==

* Fraunces — SIL Open Font License 1.1 (assets/fonts/OFL-Fraunces.txt).
* Plus Jakarta Sans — SIL Open Font License 1.1 (assets/fonts/OFL-PlusJakartaSans.txt).
* Íconos e ilustraciones: creados para este tema, GPLv2 o posterior.


== Licencia ==

GNU General Public License v2 o posterior.
