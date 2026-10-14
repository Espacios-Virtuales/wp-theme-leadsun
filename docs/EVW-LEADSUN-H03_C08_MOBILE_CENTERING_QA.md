# LEADSUN H03 / C08 · Centrado de presentación móvil · QA

Fecha: 2026-10-14. Rama: `fix/leadsun-h03-mobile-centering`. Base real: `049afe266606e96fa084b26648017877c1183695`. No se realizó merge, push ni despliegue.

## Alcance y cambios

El cambio es exclusivamente SCSS/CSS compilado; no se modificaron CPT, ACF, datos, multimedia, URLs, formularios, cotizador, PHP ni JavaScript.

### Navegación móvil (`max-width: 991.98px`)

El breakpoint es el existente de Bootstrap/tema, confirmado en `assets/scss/layout/_navigation.scss` y `assets/js/modules/navigation.js`.

- `.main-navigation > div > ul` y `.main-navigation > ul`: grid, `justify-items: center`, gap regular, sin padding inicial y texto centrado.
- `.main-navigation .menu-item`: ancho disponible para que cada enlace quede centrado dentro del menú desplegado.
- `.main-navigation .sub-menu`: ancho máximo de `20rem`, centrado y con espaciado compacto.
- El CTA de cabecera conserva la regla existente de ancho disponible y `justify-content: center` en móvil.

El logo y el toggler no recibieron cambios. La lógica existente conserva `aria-expanded`, Escape, cierre al activar enlace, cleanup desktop y la clase `is-open`; no se reintrodujo `.show`.

### Acciones, CTA y copy editorial

En `max-width: 767.98px` se centran de forma localizada el contenido y acciones de Home (`.home-hero__content`, `.home-feature__content`, `.home-hero__actions`, `.home-section__heading`), los CTA de fichas (`.entity-single__cta`, `.solution-actions`), cabeceras y extractos editoriales de entidades/landings, y los títulos/alternativa visible de formularios. Los CTAs de ficha se limitan a `min(100%, 22rem)`; el submit del cotizador conserva su ancho completo deliberado y accesible.

En `max-width: 575.98px` se centran los heroes de entidad y el cuerpo de las tarjetas de una columna. Los párrafos editoriales centrados se acotan a `42rem` y `line-height: 1.65`.

No se aplicaron reglas globales a `body`, `main *`, ni `!important`. Permanecen explícitamente fuera del alcance: `.entity-single__content`, `.entity-specifications`, tablas, listas de características, `.entity-project-details`, controles/labels/errores de `.leadsun-form`, mensajes legales y contenido técnico de lectura lineal.

### Footer (`max-width: 767.98px`)

El footer ya pasaba a una columna en ese breakpoint. Se añadieron alineación centrada de brand, segmentos y copyright; logo centrado mediante el enlace existente; listas y redes centradas; y `overflow-wrap: anywhere` para copyright/strings largos. El grid multicolumna y la alineación de tablet/escritorio no cambian.

### Regresiones funcionales preservadas

No hay cambios en `front-page.php`, `header.php`, `footer.php`, `template-parts/`, `inc/` ni `assets/js/`. Por ello se preservan el CTA `mailto:ventas@leadsun.cl`, WhatsApp, avatar/modal, ocultamiento de acciones flotantes sobre formularios, overlay/video de hero y `controls=1` en videos editoriales.

## QA ejecutado

| Comprobación | Resultado |
| --- | --- |
| `npm run build` | PASS; sólo warnings de deprecación existentes de Dart Sass/Bootstrap. |
| `node --check assets/js/modules/navigation.js` | PASS. |
| PHP lint de todo el theme (sin `vendor`) | PASS. |
| `git diff --check` | PASS. |
| Revisión de diff | PASS; sólo SCSS/CSS y este informe. |
| Revisión de exclusiones técnicas | PASS estático; sin reglas globales ni selectores de tabla/formulario/validación en el cambio. |
| HTTP local | BLOCKED_ENVIRONMENT; Apache y MySQL detenidos, `curl http://localhost/leadsun/` devolvió `000`. |

## Evidencia visual pendiente

No se generaron capturas antes/después ni pruebas de navegador en 320, 375, 390, 768, 1024 y 1440 px. El runtime WordPress no está disponible: XAMPP reportó Apache y MySQL detenidos, y la sesión no posee privilegios root para iniciarlos. No se infiere un PASS visual a partir de revisión estática.

Al recuperar el runtime, ejecutar la matriz solicitada sobre `/`, `/solar/`, `/electrica/`, `/cotizar-proyecto/`, `/soluciones/ae6-ultron-black/`, `/soluciones/rhea-u-series/`, `/tecnologias/pc-ambar/` y un proyecto publicado, con capturas a 390px de Home, menú abierto, footer, Solar/Eléctrica, solución, tecnología y cotizador. Confirmar además foco, toggler, `aria-expanded`, Escape, ausencia de scroll horizontal, tablas/formularios alineados a la izquierda y desktop intacto.

## Gate

```text
MOBILE_NAV_CENTERING=BLOCKED
MOBILE_ACTIONS_CENTERING=BLOCKED
MOBILE_EDITORIAL_CENTERING=BLOCKED
MOBILE_FOOTER_CENTERING=BLOCKED
TECHNICAL_READABILITY=PASS
DESKTOP_REGRESSION=BLOCKED
MOBILE_VISUAL_QA=BLOCKED
HTTP_SMOKE=BLOCKED_ENVIRONMENT
PRODUCTION_DEPLOYMENT=NO
```

Los cuatro primeros gates están bloqueados únicamente por falta de navegador/rutas reales y capturas. La implementación CSS y las validaciones estáticas están completas; el bloqueante no se atribuye al código.
