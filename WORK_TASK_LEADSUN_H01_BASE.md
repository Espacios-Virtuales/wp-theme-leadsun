# WORK TASK · LEADSUN H01 · Manifestar fundación técnica del tema

## Contexto

Proyecto: **LEADSUN Chile · Nueva Plataforma Web**  
Repositorio objetivo: `Espacios-Virtuales/wp-theme-leadsum`  
Hito: **H01 · Fundación técnica y arquitectura**  
Tipo de trabajo: inicialización controlada de tema WordPress personalizado.

El repositorio objetivo se encuentra inicialmente vacío. Existe como referencia un tema fuente `wp-theme-dutreras`, inspirado en Underscores y construido con Bootstrap/SCSS/templates clásicos. Ese tema **no debe copiarse literalmente**: solo deben conservarse sus principios estructurales útiles.

## Objetivo

Inicializar el repositorio con una base limpia, instalable y versionable para LEADSUN, preparada para ACF Free, CPT de productos/proyectos y construcción posterior de la maqueta, sin intervenir producción ni adelantar la composición visual.

## Fuente de la base

Usar el paquete/folder `wp-theme-leadsun-base` suministrado con esta tarea como baseline técnico.

Antes de modificar, inspeccionar el repositorio remoto y confirmar que no exista trabajo posterior que deba preservarse.

## Restricciones

1. No modificar `leadsun.cl` ni ningún entorno productivo.
2. No incorporar contenidos confidenciales del cliente.
3. No implementar todavía la maqueta visual.
4. No crear campos ACF definitivos en esta tarea.
5. No usar Elementor.
6. No usar ACF Pro.
7. No versionar `node_modules/`.
8. No vendorizar Bootstrap dentro de `assets/scss/bootstrap/`.
9. No copiar `.git/` del tema fuente.
10. No arrastrar shortcodes, branding, librerías o experimentos personales del tema `wp-theme-dutreras`.
11. Mantener PHP compatible con PHP 8+ y APIs estándar de WordPress.
12. Mantener `leadsun_product` y `leadsun_project` como nombres internos estables si se implementan en esta tarea.

## Arquitectura esperada

```text
wp-theme-leadsun/
├── style.css
├── functions.php
├── header.php
├── footer.php
├── index.php
├── front-page.php
├── page.php
├── single.php
├── archive.php
├── 404.php
├── single-leadsun_product.php
├── archive-leadsun_product.php
├── single-leadsun_project.php
├── archive-leadsun_project.php
├── inc/
│   ├── init.php
│   ├── setup.php
│   ├── enqueue.php
│   ├── template-tags.php
│   ├── helpers/
│   │   └── fields.php
│   ├── integrations/
│   │   └── acf.php
│   └── domain/
│       ├── content-types.php
│       └── taxonomies.php
├── template-parts/
│   ├── content/
│   ├── product/
│   └── project/
├── assets/
│   ├── scss/
│   ├── css/
│   ├── js/
│   └── img/
├── acf-json/
├── languages/
├── package.json
├── .gitignore
├── LICENSE
└── README.md
```

## SCSS

Mantener la secuencia:

```text
settings/tokens
→ settings/bootstrap
→ Bootstrap desde node_modules
→ base
→ layout
→ components
→ pages
→ utilities
```

Bootstrap debe instalarse con npm. No copiar su source tree al repositorio.

## JavaScript

- Sin jQuery como dependencia estructural.
- `assets/js/app.js` como entry point.
- Navegación como módulo separado.
- No cargar Three.js, Anime.js, Tailwind, Chart.js, Lightbox ni AOS en esta fundación.
- Agregar una dependencia solo cuando una vista real la justifique.

## WordPress / dominio

Registrar inicialmente:

- CPT `leadsun_product`, archive `/productos/`.
- CPT `leadsun_project`, archive `/proyectos/`.
- Taxonomía `leadsun_line` para productos.
- Taxonomía `leadsun_sector` para proyectos.

Los registros deben estar aislados en `inc/domain/` de forma que puedan extraerse posteriormente a un plugin `leadsun-core` sin cambiar las claves públicas.

## ACF Free

Configurar `acf-json/` con filtros `acf/settings/save_json` y `acf/settings/load_json`.

No crear Repeaters ni ninguna feature Pro.

La tarea siguiente cerrará el modelo de campos de Producto y Proyecto.

## Build local

Usar Dart Sass, no `node-sass`.

Esperado:

```bash
npm install
npm run build
```

No es necesario committear `node_modules/`.

## Validaciones obligatorias

1. `php -l` sin errores en todos los PHP del theme.
2. `npm install` exitoso.
3. `npm run build` exitoso.
4. `node_modules/` ausente del commit.
5. `assets/scss/bootstrap/` ausente del commit.
6. No referencias a `blog-theme`, `David Utreras`, Metatrón, Tailwind, Three.js, Anime.js, Lightbox o shortcodes `ev-*`.
7. `style.css` contiene únicamente metadata del theme, no el normalize heredado completo.
8. CPT y taxonomías registran sin warnings.
9. El theme puede activarse sin ACF; si ACF no está activo, solo debe mostrarse un aviso administrativo y no producir fatal errors.
10. No realizar ninguna operación contra producción.

## Flujo Git sugerido

Si el repositorio sigue vacío:

1. Inicializar `main` con esta fundación.
2. Crear `develop` desde `main` después del bootstrap inicial, si la estrategia del proyecto lo requiere.
3. Para H01 posterior trabajar mediante rama feature, no directamente sobre producción.

Si el repositorio ya contiene commits, **no sobrescribir**: inspeccionar primero y adaptar la tarea al estado actual.

## Commit esperado

```text
chore: initialize LEADSUN theme foundation
```

## Entrega

Al finalizar devolver:

- rama utilizada;
- commit SHA;
- árbol principal del theme;
- resultado de PHP lint;
- resultado de npm build;
- confirmación de ausencia de `node_modules` y Bootstrap vendorizado;
- cualquier desviación respecto de esta tarea;
- recomendación para la siguiente cápsula: modelado exacto de ACF Free para Producto y Proyecto.

## Criterio de aceptación

**PASS** si el repositorio queda con una fundación WordPress limpia, instalable, compilable y preparada para el dominio LEADSUN, sin diseño final, sin contenido del cliente, sin dependencias históricas del tema fuente y sin intervención de producción.
