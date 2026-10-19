# Catálogo de productos Karu Esencial

- `Catalogo-Karu-Esencial-octubre-2026.pdf`: catálogo listo (A4, 5 páginas) para enviar por WhatsApp, imprimir o importar en Canva.
- `catalogo.html`: diseño fuente (colores, fuentes Nunito y Figtree, precios y textos).

Para regenerar el PDF después de cambiar precios o textos:

```
node catalogo/pdf.mjs "$PWD/catalogo/catalogo.html" "$PWD/catalogo/Catalogo-Karu-Esencial-octubre-2026.pdf"
```
