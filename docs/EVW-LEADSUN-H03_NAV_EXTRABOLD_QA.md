# EVW-LEADSUN-H03 · Peso ExtraBold del menú principal

Fecha: 2026-10-14
Rama: `fix/leadsun-h03-nav-extrabold`
Base comprobada: `8065f756ad94f5933cd9c6cac1984ff5df883458`

## Diagnóstico

`header.php` genera los enlaces de menú en un `ul.navbar-nav`; el CTA
`Cotizar proyecto` es un ancla independiente con la clase
`leadsun-header__cta`. La regla anterior `.main-navigation a` cubría ambos, por
lo que no era apropiada para aplicar el nuevo peso exclusivamente al menú.

Bootstrap no aporta un peso específico a estos enlaces en el tema. La fuente de
headings se define como `$leadsun-font-family-heading` en
`assets/scss/settings/_tokens.scss` y los `h1`–`h6` ya usan ese token.

`inc/enqueue.php` conserva una única hoja existente de Google Fonts:

```text
family=Manrope:wght@600;700;800
```

Por lo tanto, Manrope 800 se solicita sin crear una segunda familia ni una
carga duplicada.

## Cambio aplicado

En `assets/scss/layout/_navigation.scss` se sustituyó el selector amplio por:

```scss
.main-navigation .navbar-nav a {
  font-family: $leadsun-font-family-heading;
  font-weight: 800;
  text-decoration: none;
}
```

El selector cubre los enlaces primarios, submenús y menú móvil porque todos
pertenecen a `ul.navbar-nav`; excluye el CTA del header, que queda fuera de ese
`ul` y conserva el peso/estilos de `.btn-leadsun`. Hover, foco y estados activos
no cambian el peso, evitando saltos por métrica. No se modificaron tamaños,
tracking, gaps, header, toggler, JavaScript, CTA, formularios ni contenido.

`assets/css/main.css` fue regenerado mediante `npm run build`. La salida
compilada contiene:

```css
.main-navigation .navbar-nav a {
  font-family: "Manrope", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
  font-weight: 800;
}
```

## Validaciones realizadas

- `npm run build`: correcto; sólo advertencias de deprecación Sass/Bootstrap
  ya conocidas.
- `node --check assets/js/modules/navigation.js`: correcto, sin cambios JS.
- `find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l`:
  correcto para 67 archivos PHP.
- `git diff --check`: correcto.
- Inspección estática del CSS compilado: selector, familia y peso 800 presentes.
- Inspección de `inc/enqueue.php`: Manrope 800 incluido en la única solicitud
  de fuente existente.

## Bloqueo de QA runtime

No fue posible abrir DevTools, revisar estilo computado/Network ni tomar las
capturas antes/después en 320/375/390/768/1024/1280/1440/1820 px. El servidor
local no estaba disponible; `curl http://localhost/leadsun/` devolvió HTTP
`000` por conexión rechazada. En consecuencia, no se simula la comprobación de
pixels, la carga efectiva de la fuente ni el comportamiento real del menú
hamburguesa/Escape/`aria-expanded`.

## Gates

```text
NAV_FONT_FAMILY_MANROPE=BLOCKED
NAV_FONT_WEIGHT_800_COMPUTED=BLOCKED
NAV_VISUAL_DIFFERENCE=BLOCKED
MOBILE_NAV_REGRESSION=BLOCKED
DESKTOP_NAV_REGRESSION=BLOCKED
BUILD_AND_LINT=PASS
PRODUCTION_DEPLOYMENT=NO
```

El SHA final y estado del worktree se informan con el único commit local. Sin
merge, push ni despliegue.
