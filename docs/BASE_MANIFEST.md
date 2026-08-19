# LEADSUN · Manifestación de base técnica

## Origen

Base conceptual: `wp-theme-dutreras`, inspirado en Underscores, Bootstrap, SCSS y templates clásicos de WordPress.

## Se conserva como principio

- Esqueleto clásico de WordPress.
- `header.php`, `footer.php`, `page.php`, `single.php`, `archive.php`, `404.php`.
- `template-parts/`.
- Modularización en `inc/`.
- SCSS como fuente de estilos.
- Bootstrap personalizado desde variables previas a la importación.
- JavaScript modular.
- Control de versión de ACF mediante `acf-json/`.

## Se elimina del origen

- `.git/` del paquete fuente.
- `node_modules/`.
- Bootstrap vendorizado dentro de `assets/scss/`.
- Shortcodes personales y experimentales.
- Metatrón, Three.js, Anime.js, Tailwind, Chart.js y Lightbox heredados.
- Bloques React/Gutenberg experimentales.
- Branding, redes, WhatsApp, correos y textos personales hardcodeados.
- Footer/widgets específicos del tema anterior.
- `page-sobre-mi.php` y templates personales.
- Doble sistema de navegación JS.
- `style.css` como hoja visual completa; queda solo como cabecera del theme.
- `node-sass`; se reemplaza por Dart Sass.

## Dependencias locales

No se versionan:

- `node_modules/`
- source code de Bootstrap

Se reconstruyen con:

```bash
npm install
npm run build
```

## Dominio inicial

### CPT

- `leadsun_product` → `/productos/`
- `leadsun_project` → `/proyectos/`

### Taxonomías

- `leadsun_line` → líneas de producto
- `leadsun_sector` → sectores de proyecto

## ACF Free

La base configura Local JSON pero **no fija aún los grupos de campos**. La siguiente tarea debe cerrar el modelo exacto y exportar/versionar los JSON generados.

No usar funcionalidades ACF Pro como Repeater, Flexible Content, Gallery, Clone, Options Pages o ACF Blocks.

## Frontera de esta manifestación

Incluido:

- Theme bootstrap instalable.
- Enqueue limpio.
- SCSS modular.
- Bootstrap por npm.
- JS sin jQuery.
- CPT y taxonomías iniciales.
- Templates single/archive estructurales.
- Integración base ACF Free.

No incluido:

- Branding visual LEADSUN.
- Maqueta de portada.
- Composición de productos/proyectos.
- Campos ACF definitivos.
- Carga de contenidos.
- Formularios comerciales.
- Analytics/SEO específicos.
- Migración/staging.
