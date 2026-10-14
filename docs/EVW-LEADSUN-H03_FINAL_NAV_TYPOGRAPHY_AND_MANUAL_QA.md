# EVW-LEADSUN-H03 · Tipografía de navegación y manual administrativo

Fecha: 2026-10-14
Rama: `fix/leadsun-h03-final-nav-font-and-manual`
Base comprobada: `da4a7b393d323a800d1e37584917bab272e92daa`

## Etapa A · Tipografía de navegación

Se modificó exclusivamente `assets/scss/layout/_navigation.scss`:

```scss
.main-navigation a {
  font-family: $leadsun-font-family-heading;
  text-decoration: none;
}
```

El token efectivo de títulos es `$leadsun-font-family-heading`, definido en
`assets/scss/settings/_tokens.scss` como `Manrope` con sus fallbacks. El mismo
token ya se aplica a `h1`–`h6` desde `assets/scss/base/_typography.scss`. Por
alcance del selector, cubre enlaces de la navegación primaria, submenús y el
CTA ancla del header, tanto en escritorio como en el menú móvil desplegado.

No se modificaron peso, tamaño, tracking, color, fondo, alturas, breakpoints,
estados de foco/hover ni JavaScript. `assets/css/main.css` fue regenerado con
la compilación normal; no se editó manualmente. `inc/enqueue.php` conserva una
única carga existente de Google Fonts que incluye Inter y Manrope; no se añadió
una importación duplicada.

Evidencia estática: el CSS compilado contiene la regla de `.main-navigation a`
con la familia Manrope y los heading continúan usando el mismo token fuente.

## Etapa B · Manual administrativo DRAFT

Se creó `docs/LEADSUN_MANUAL_ADMINISTRACION_WEB_v1.0_DRAFT.md`. Su contenido
fue contrastado con los CPT, ACF JSON, plantillas y formularios reales del tema:

- CPT: `leadsun_solution`, `leadsun_technology`, `leadsun_project` y
  `leadsun_lead`.
- ACF Free: Home, Soluciones, Tecnologías, Proyectos y Landing, con los nombres
  de campos reales y sus formatos por línea (`Nombre | Valor` cuando aplica).
- Navegación registrada: primaria, tres segmentos de footer y redes sociales.
- Cotizador: intereses publicados de solución, tecnología o proyecto; lead
  interno, intento de correo y redirección opcional a WhatsApp.
- Datos de contacto tratados como referencia de revisión, no como una promesa
  de configuración en producción: teléfono/WhatsApp `+56 9 8332 9841` y CTA
  Home `ventas@leadsun.cl`.
- Límites explícitos sobre demo, material técnico, videos YouTube adaptativos y
  operaciones que requieren soporte técnico.

No se inventaron funciones administrativas, comandos WP-CLI ni capturas. El
manual conserva estado DRAFT hasta contrastarlo con la instancia entregada.

## Checks y bloqueos

- `npm run build`: correcto; sólo advertencias de deprecación Sass/Bootstrap
  ya conocidas.
- `node --check assets/js/modules/navigation.js`: correcto.
- `find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l`:
  correcto para 67 archivos PHP.
- `git diff --check`: correcto.

No hubo navegador ni servidor local operativo para inspeccionar estilo
computado, abrir el hamburguesa, probar Escape/`aria-expanded` o hacer la
matriz 320/375/390/768/1024/1440 px. `curl` a
`http://localhost/leadsun/` devolvió HTTP `000` (conexión rechazada). No se
declara QA visual ni HTTP como PASS.

## Gates

```text
NAV_FONT_MATCHES_HEADINGS=PASS
DESKTOP_NAV_REGRESSION=BLOCKED
MOBILE_NAV_REGRESSION=BLOCKED
BUILD_AND_LINT=PASS
USER_MANUAL_DRAFT=COMPLETE
USER_MANUAL_VERIFIED_AGAINST_CODE=PASS
MANUAL_CLIENT_RELEASE=PENDING
PRODUCTION_DEPLOYMENT=NO
```

El SHA final y estado limpio del worktree se registran al entregar el único
commit local. No hubo merge, push ni despliegue.
