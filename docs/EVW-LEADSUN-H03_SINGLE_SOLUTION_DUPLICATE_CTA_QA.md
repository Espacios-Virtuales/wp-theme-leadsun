# EVW-LEADSUN-H03 · CTA de cotización duplicado en fichas de soluciones

Fecha: 2026-10-14
Rama: `fix/leadsun-h03-single-solution-duplicate-cta`
Base comprobada: `50d04a637248f96635a86bef5f843c2358e10d7e` (`fix/leadsun-h03-video-luminosity-tuning`)

## Diagnóstico y decisión

Las fichas `leadsun_solution` cargaban dos renderizados independientes de una
acción de cotización:

1. `template-parts/components/solution-actions.php` emitía `Cotizar proyecto`
   junto a la ficha técnica/certificaciones. Su destino era
   `leadsun_quote_page_url()` con `solucion=<ID>`.
2. `template-parts/single/entity-content.php` carga al final
   `template-parts/components/entity-quote-cta.php` para soluciones y
   tecnologías. Para una solución, este componente emite `Cotiza tu proyecto`
   hacia `/cotizar-proyecto/?solucion=<ID>`.

Ambos renderizados son independientes de los breakpoints: no son una misma
acción reubicada para móvil. La duplicación, por tanto, existía tanto en móvil
como en escritorio cuando se renderizaba la ficha.

Se conserva el CTA dedicado `entity-quote-cta`, ya que es la llamada principal
de cierre de la ficha y mantiene el contexto de la solución. Se retiró sólo el
enlace de cotización de `solution-actions.php`. Ese componente continúa
mostrando acciones distintas (ficha técnica y certificaciones) y ahora no
renderiza una sección vacía si ninguna de ellas existe. No se modificó el
componente compartido de tecnologías.

## Archivos modificados

- `template-parts/components/solution-actions.php`
  - eliminado el enlace duplicado `Cotizar proyecto`;
  - retorno temprano cuando no hay ficha técnica ni certificaciones.

No hubo cambios en URLs de multimedia, ACF, CPT, formularios, WhatsApp, leads,
correo, JavaScript ni SCSS.

## Evidencia y comprobaciones

Comprobaciones estáticas y de componentes:

- `rg -n -i 'cotizar|quote-cta' template-parts/components/solution-actions.php template-parts/components/entity-quote-cta.php template-parts/single/entity-content.php`
  confirma que el enlace de cotización de las soluciones queda únicamente en
  `entity-quote-cta.php`, invocado desde `entity-content.php`.
- Harness PHP aislado para `solution-actions.php`: conserva `Descargar ficha
  técnica` y no contiene `Cotizar proyecto`.
- Harness PHP aislado para `entity-quote-cta.php`, contexto `solucion` e ID
  `20`: contiene una sola instancia de `solucion=20` y el texto `Cotiza tu
  proyecto`.
- Harness PHP sin documento ni certificaciones: `solution-actions.php` no
  genera marcado vacío.
- `git diff --check`: correcto.
- `npm run build`: correcto; sólo las advertencias de deprecación Sass/Bootstrap
  ya conocidas.
- `find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l`:
  correcto para 67 archivos PHP.

## QA de navegador y HTTP

Se intentó verificar las rutas publicadas requeridas (`ae6-ultron-black`,
`ae3c-split-type`, `rhea-u-series`, `skylights` y `pbox-x4s`) y la portada.
Apache local respondió una vez para la portada durante el diagnóstico, pero la
sesión dejó de aceptar conexiones antes de cargar las fichas; los intentos
posteriores devolvieron HTTP `000`. No se simuló una respuesta 200 ni una
captura visual.

Por esa limitación de entorno quedan bloqueadas las verificaciones visuales de
320/390/1024/1440 px, foco de teclado en navegador y revisión de regresión del
header, WhatsApp, PDF y controles de vídeo. La estructura PHP sí garantiza que
las dos rutas de renderizado anteriores ya no producen dos CTAs de cotización
en una ficha de solución.

## Gates

```text
SOLUTION_QUOTE_CTA_COUNT=ONE_PER_SINGLE
SOLUTION_QUOTE_CONTEXT=PASS
SOLUTION_ACTIONS_REGRESSION=PASS
RESPONSIVE_QA=BLOCKED
BUILD_AND_LINT=PASS
PRODUCTION_DEPLOYMENT=NO
```

Estado del worktree antes del commit: modificaciones acotadas a este componente
y a este informe. Sin merge, push ni despliegue.
