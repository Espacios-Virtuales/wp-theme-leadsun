# EVW-LEADSUN-H03-L01-C07-R01 · Reparación del toggle móvil

## Diagnóstico

```text
NAV_IMPLEMENTATION=JavaScript nativo del theme
TOGGLE_SELECTOR=.menu-toggle
TARGET_SELECTOR=#site-navigation
BOOTSTRAP_JS_LOADED=NO
CUSTOM_NAV_JS=YES
DUPLICATE_INITIALIZATION=NO
ROOT_CAUSE=El controlador alternaba .show, pero el CSS del theme mantiene oculto .main-navigation mientras no tenga .is-open; ambos estados no coincidían.
```

Bootstrap 5 está instalado por npm (`npm ls bootstrap` informa `bootstrap@5.3.8`) y se compila su CSS local. `inc/enqueue.php` encola AOS y `assets/js/app.js`, pero no encola Bootstrap JavaScript ni otro bundle de Bootstrap. El entrypoint importa `initNavigation()` una vez. El botón controla `#site-navigation` con `aria-controls` correcto. El markup incluía además la clase `collapse`, aunque la navegación no usa Bootstrap Collapse.

## Cambio aplicado

Antes, el controlador alternaba `.show`; después usa `.is-open`, que es el estado que el CSS existente requiere. Se quitó la clase `collapse` sin uso de Bootstrap y se mantuvo `navbar-collapse` para conservar el layout desktop. `aria-expanded` y la etiqueta accesible cambian junto con la clase. La inicialización queda protegida contra listeners duplicados, Escape cierra el menú y devuelve el foco al botón, los enlaces cierran el menú en móvil y el cambio a desktop restablece el estado cerrado para el próximo ingreso a móvil.

Archivos modificados:

- `header.php`
- `assets/js/modules/navigation.js`
- `docs/EVW-LEADSUN-H03-L01-C07-R01_NAV_TOGGLE_FIX.md`

## Validación

| Comprobación | Resultado |
| --- | --- |
| `npm ls bootstrap` | PASS · `bootstrap@5.3.8`, una dependencia declarada |
| `npm run build` | PASS · advertencias deprecadas Sass/Bootstrap conocidas |
| `node --check assets/js/modules/navigation.js` | PASS |
| PHP lint de todos los archivos PHP del theme | PASS |
| `git diff --check` | PASS |
| Smoke HTTP `/`, `/solar/`, `/electrica/`, AE6, AE3C y `/cotizar-proyecto/` | BLOCKED · todos devolvieron `000`; Apache/MySQL locales no estaban activos y el entorno denegó el inicio por requerir root |
| Navegador / consola JS | BLOCKED · sin servidor WordPress local disponible |
| 320, 390, 768, 1024 y >1200 px | PENDING · requiere navegador sobre el sitio servido |
| Home, Solar, Eléctrica, single AE6, single AE3C y Cotizador | PENDING · requiere servidor WordPress local disponible |
| Teclado, redimensionado, aperturas repetidas y regresión desktop | PENDING · requiere navegador sobre el sitio servido |

No se atribuye PASS a las comprobaciones visuales o runtime que no pudieron ejecutarse. Para completar la cápsula, levantar Apache/MySQL con permisos de servicio y repetir los casos pendientes, incluido el smoke HTTP. La rama no se considera cerrada hasta que esos gates resulten PASS.

## Estado de rama

```text
BRANCH=fix/leadsun-h03-c07-mobile-nav-toggle
BASE_SHA=29991332740abb6daa4b515b424b29198041bafc
FINAL_SHA=PENDING · sin commit hasta completar QA runtime
MOBILE_NAV_TOGGLE=PENDING
DESKTOP_NAV_REGRESSION=PENDING
RESPONSIVE_QA=PENDING
JS_CONSOLE=PENDING
BUILD=PASS
PHP_LINT=PASS
JS_CHECK=PASS
DIFF_CHECK=PASS
WORKTREE=DIRTY · cambios de implementación y evidencia sin commit
EVW-LEADSUN-H03-L01-C07-R01_NAV_TOGGLE_FIX=OPEN
```
