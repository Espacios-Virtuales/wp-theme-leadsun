# EVW-LEADSUN-H03 · CTA contextual en fichas de proyectos

Fecha: 2026-10-14
Rama: `fix/leadsun-h03-project-contextual-cta`
Base comprobada: `9f224acd9684588b48845517ff39326cfc55b371`

## Alcance y ubicación

El CTA se carga una única vez desde
`template-parts/single/entity-content.php`, al final del contenido de un
`leadsun_project`, después de media, detalles y relaciones, y antes del footer.
Se reutiliza `template-parts/components/entity-quote-cta.php`; no se añadió a
tarjetas del archivo `/proyectos/`, por lo que éstas mantienen su acción de
navegación.

La variante de proyecto presenta exactamente:

- `¿Necesitas una solución similar?`
- `Conversemos sobre los requerimientos de tu proyecto y las alternativas que LEADSUN puede desarrollar.`
- `Cotizar un proyecto similar`

El copy y botón se agrupan en `entity-single__cta-copy`. En móvil, las reglas
existentes del CTA apilan el bloque y el botón y la nueva regla localizada centra
el copy; no se aplicó centrado global.

## Contrato de contexto

El cotizador ya tenía un contrato genérico de interés
(`interest_type`, `interest_id`, `interest_name`) usado por validación, envío de
correo y persistencia del lead. Se amplió ese contrato existente, sin crear
metas, formularios ni rutas adicionales:

- CTA de proyecto publicado: `/cotizar-proyecto/?proyecto=<ID>`.
- `leadsun_quote_interest_from_query()` acepta exactamente uno entre
  `solucion`, `tecnologia` y `proyecto`; parámetros simultáneos se descartan.
- `leadsun_quote_interest_from_entity()` acepta `project` sólo cuando el ID es
  un `leadsun_project` publicado. Valores no numéricos, negativos, inexistentes,
  de otro CPT o borradores devuelven contexto vacío.
- El formulario muestra `Proyecto de referencia` y usa los campos de interés
  ya existentes. Correo y listado administrativo del lead reutilizan el mismo
  interés validado.

Para un proyecto no publicado, incluido un posible preview del demo ID 24, el
componente conserva el CTA editorial pero enlaza a `/cotizar-proyecto/` sin
`proyecto=<ID>`. La validación pública también rechaza directamente
`?proyecto=24` si sigue en borrador. No se publicó ni se modificó contenido,
ACF, estado editorial o datos de ningún proyecto.

Las relaciones ACF existentes se inspeccionaron y no se reutilizaron como
sustituto del origen: `project_solution` y `project_technology` son campos
`post_object` unidireccionales, opcionales, con retorno ID, hacia soluciones y
tecnologías respectivamente.

## Archivos modificados

- `template-parts/single/entity-content.php`
- `template-parts/components/entity-quote-cta.php`
- `assets/scss/pages/_entities.scss`
- `assets/css/main.css` (artefacto de `npm run build`)
- `inc/forms/forms.php`
- `template-parts/forms/quote-form.php`
- `inc/forms/mail.php`
- `inc/forms/leads.php`

No se modificaron destinatarios de correo, handlers de entrega, anti-spam,
WhatsApp, videos, imágenes, galerías, ACF ni base de datos.

## Evidencia y checks

- Harness de `leadsun_quote_interest_from_query()`:
  `?proyecto=42` publicado produce `project`, ID `42`; un borrador ID `24` y una
  combinación `proyecto` + `solucion` producen interés vacío.
- Harness del componente CTA:
  proyecto publicado muestra el copy solicitado y `proyecto=42`; proyecto no
  publicado usa la URL canónica sin query string.
- Harness de `quote-form.php`: conserva `interest_type=project`,
  `interest_id=42` y muestra `Proyecto de referencia` con el título canónico.
- Harness de CTA de solución: conserva `Cotiza tu proyecto` y `solucion=8`, sin
  introducir el copy de proyecto ni duplicar su render.
- `npm run build`: correcto; sólo advertencias de deprecación Sass/Bootstrap ya
  conocidas.
- `find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l`:
  correcto para 67 archivos PHP.
- `git diff --check`: correcto.

La consulta read-only de WP-CLI para ID 24 y los proyectos publicados falló con
`Error establishing a database connection`. Por ello no se afirma una consulta
en vivo del estado del demo ni se realizaron cambios de BD.

## QA pendiente de entorno

No fue posible realizar HTTP/browser ni capturas en `/proyectos/`, un single
publicado, el preview autorizado del demo, `/cotizar-proyecto/`, AE6, Home o PC
Ámbar: la base de datos local no estaba disponible y `curl` a
`http://localhost/leadsun/proyectos/` devolvió HTTP `000` (conexión rechazada).
La validación visual de 320/390/768/1024/1440 px queda explícitamente
bloqueada; no se simularon rutas 200 ni resultados visuales.

## Gates

```text
PROJECT_SINGLE_CTA_COUNT=ONE
PROJECT_CTA_LABEL=PASS
PROJECT_QUOTE_LINK=PASS
PROJECT_CONTEXT=PASS
DEMO_PROJECT_REMAINS_DRAFT=BLOCKED
SOLUTION_SINGLE_CTA_REGRESSION=PASS
MOBILE_CENTERING=BLOCKED
BUILD_LINT_DIFF=PASS
BROWSER_HTTP_QA=BLOCKED_ENVIRONMENT
PRODUCTION_DEPLOYMENT=NO
```

El SHA final de entrega se informa con el commit local; no hubo merge, push ni
despliegue.
