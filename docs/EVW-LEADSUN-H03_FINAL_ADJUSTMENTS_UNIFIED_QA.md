# LEADSUN Chile · H03 · Afinación final y QA predespliegue

Fecha de ejecución: 2026-10-13. Actividad: `EVW-LEADSUN-H03`. Esta carga única conserva los IDs históricos C01–C07; no crea cápsulas nuevas. No se ejecutó despliegue.

## Resumen de decisión

Se aplicó una sola rama de cambios técnicos y se completaron QA de navegador y pruebas sintéticas del cotizador/leads/correo/WhatsApp. El gate queda **BLOCKED**: falta aprobación de copy editorial, el fotograma de video de escritorio no pudo verificarse localmente, y el smoke HTTP final no pudo correr porque Apache quedó detenido y el operador actual no tiene permisos para iniciarlo. No es una autorización de producción.

## Preflight y datos

- Rama creada desde `88a931d18f14154dcaf1eff0caf55a3de269539f`; `HEAD` coincidía exactamente y el baseline de navegación era ancestro. Worktree limpio al inicio.
- WordPress instalado y `wp db check` aprobado. `home` y `siteurl` permanecen en `http://localhost/leadsun`.
- Backup de BD anterior al cambio: `/tmp/leadsun-h03-final-adjustments-20261013T133546-0300.sql`.
- Único delta editorial de BD: página 13, “LEADSUN Style Guide”, pasó de publicada a borrador porque era contenido de demo/QA interno. Se conservaron los IDs y slugs de contenido; RHEA ID 20 continúa en la taxonomía `Eléctrica`. Proyectos demo 24–26 continúan como borradores.
- Los registros sintéticos de QA se eliminaron. No se consultaron ni modificaron leads reales.

## Cambios, causa y resultado

**Portada/video.** El overlay previo oscurecía globalmente el video (`.93` en el lado izquierdo y una cobertura oscura amplia). Se reemplazó por un gradiente direccional que concentra el contraste en la zona de copy; en móvil se usa degradado vertical localizado. Se preservaron el video, el copy, CTA y controles existentes. Se ajustaron ancho mínimo del grid, tamaño del H1 y apilado de CTA para evitar clipping en 320 px. En fotogramas móviles capturados, copy y botones son legibles y caben. En escritorio el reproductor local quedó negro durante la captura, por lo que no se declara validado el contraste sobre distintos fotogramas: `HOME_VIDEO_OVERLAY=BLOCKED`.

**Espaciados Solar/Eléctrica/Cotizador.** Las páginas de landing no tienen contenido editorial y aun así imprimían una sección vacía, generando un hueco bajo el hero. La sección sólo se renderiza con contenido; además se compactaron paddings del contenido, tarjetas y formulario mediante selectores del landing. Las capturas y la matriz responsive no mostraron colisiones ni overflow.

**Copy y contenido interno.** No se inventaron títulos ni descripciones. Solar ID 38 conserva su título actual; Eléctrica ID 39 y RHEA ID 20 conservan sus valores hasta recibir strings finales aprobados. RHEA sigue clasificada en `Eléctrica`. Se retiraron dos textos inequívocamente operativos: la nota temporal de certificaciones de maqueta y la frase de implementación pendiente del archivo de soluciones; los defaults de certificaciones no se publican si no existen etiquetas cargadas en ACF. El estado es `PARTIAL / BLOCKED_EDITORIAL_COPY` para `page:38.post_title`, `page:39.post_title`, `leadsun_solution:20.post_title` y `leadsun_solution:20.post_excerpt`. Se solicita confirmar los strings finales exactos para esos campos. El estado actual de Solar coincide con una referencia histórica, pero esa referencia no se trató como nueva aprobación.

**Tarjetas/fallback y acciones flotantes.** Se mantuvieron las tarjetas y sus campos administrables en WordPress/ACF Free. En ausencia de imagen destacada se ve el fallback institucional existente; no se sustituyeron medios del cliente ni se publicaron proyectos borrador. El navegador no encontró imágenes rotas, imágenes sin `alt` ni enlaces de tarjetas a drafts. El avatar/WhatsApp flotantes se ocultan mientras el formulario está visible o cuando su caja se superpone con contenido protegido, evitando cubrir campos y tarjetas; el CTA WhatsApp dentro del formulario se conserva.

## QA ejecutado

| Área | Evidencia/resultado |
|---|---|
| Navegador y responsive | 65 combinaciones: 13 rutas × 320, 390, 768, 1024 y 1280 px. Sin overflow horizontal, imágenes rotas, imágenes sin `alt`, errores JS ni recursos locales fallidos en la corrida. Rutas: `/`, `/solar/`, `/electrica/`, `/soluciones/`, `/tecnologias/`, `/proyectos/`, `/soluciones/ae6-ultron-black/`, `/soluciones/ae3c-split-type/`, `/soluciones/rhea-u-series/`, `/soluciones/skylights/`, `/soluciones/pbox-x4s/`, `/tecnologias/pc-ambar/`, `/cotizar-proyecto/`. |
| Navegación móvil | PASS en navegador: click abre/cierra; `aria-expanded` y `aria-label` sincronizados; Escape cierra y devuelve foco; seleccionar enlace cierra/navega; mobile→desktop limpia estado y desktop→mobile sigue usable. Usa `.is-open`; no hubo `.show`, listeners duplicados ni excepciones. |
| AOS / movimiento reducido | PASS: emulación `prefers-reduced-motion` activa; transición computada `0s` y transform `none`. |
| Cotizador y formulario general | PASS en pruebas sintéticas: nonce válido/inválido, honeypot, requeridos/labels, contexto solución ID 20 y tecnología ID 22 canónicos en servidor; contexto falsificado ignorado; contexto conflictivo y registro draft rechazados. |
| Persistencia / correo | PASS: lead privado persistido con contexto canónico. Correo interceptado en `pre_wp_mail`; se cubrieron retorno exitoso y fallo, estado `sent`/`failed` y fallo de persistencia. Si no persiste, no hubo intento de correo ni redirect. Ningún email real fue enviado. |
| WhatsApp | PASS funcional: se capturó redirect 303 con contexto e ID de lead sintético. No se abrió WhatsApp ni se usaron datos personales/teléfonos reales. |
| HTTP local | BLOCKED en smoke final: Apache estaba detenido y el intento de inicio indicó que se requieren permisos root. Los requests devolvieron `000`; esto no se atribuye a un defecto de aplicación. El operador debe iniciar XAMPP y repetir el smoke. Una corrida anterior del navegador sí cargó las 13 rutas mientras el servidor respondía. |
| Revisión pública | PENDING; no se verificó túnel ngrok ni se expuso el sitio. |

`npm run build`, `php -l` en todos los PHP excluyendo `vendor`, `node --check assets/js/app.js`, `node --check assets/js/modules/navigation.js`, `wp db check` y `git diff --check`: PASS. Build mantiene advertencias conocidas de deprecación Dart Sass/Bootstrap; no falló.

## Capturas

Capturas representativas tomadas en navegador local y versionadas junto con este informe:

- Home: [320 px](evidence/h03-final/h03-after-home-320.png), [390 px](evidence/h03-final/h03-after-home-390.png), [1280 px](evidence/h03-final/h03-after-home-1280.png).
- Solar: [390 px](evidence/h03-final/h03-after--solar--390.png). Eléctrica: [390 px](evidence/h03-final/h03-after--electrica--390.png).
- Cotizador: [390 px](evidence/h03-final/h03-after--cotizar-proyecto--390.png), [1280 px](evidence/h03-final/h03-after--cotizar-proyecto--1280.png).

## Archivos y salida

Nueve archivos de implementación/build: `assets/css/main.css`, `assets/js/app.js`, `assets/scss/components/_avatar.scss`, `assets/scss/pages/_entities.scss`, `assets/scss/pages/_home-mockup.scss`, `front-page.php`, `inc/presentation/entities.php`, `page-leadsun-landing.php`, `template-parts/archive/entity-archive.php`. Se agregan este informe y siete capturas.

```text
BRANCH=feature/leadsun-h03-final-adjustments-unified
BASE_SHA=88a931d18f14154dcaf1eff0caf55a3de269539f
FINAL_SHA=ver entrega final (commit consolidado que contiene este informe)
FILES_CHANGED=17 (9 implementación/build, 1 informe, 7 capturas)
WP_DB_BACKUP_REF=/tmp/leadsun-h03-final-adjustments-20261013T133546-0300.sql
HOME_VIDEO_OVERLAY=BLOCKED
INTERNAL_SPACING=PASS
EDITORIAL_COPY=PARTIAL
BLOCKED_EDITORIAL_FIELDS=page:38.post_title; page:39.post_title; leadsun_solution:20.post_title; leadsun_solution:20.post_excerpt
CARD_PRESENTATION=PASS
MOBILE_NAV=PASS
RESPONSIVE=PASS
COTIZADOR=PASS
LEAD_PERSISTENCE=PASS
MAIL=PASS
WHATSAPP=PASS
LOCAL_HTTP=BLOCKED
PUBLIC_REVIEW=PENDING
BUILD=PASS
PHP_LINT=PASS
JS_CHECK=PASS
DIFF_CHECK=PASS
WORKTREE=CLEAN (después del commit consolidado)
CLIENT_APPROVAL=PENDING
PRODUCTION_DEPLOYMENT=NOT_EXECUTED
H03_FINAL_PREDEPLOY_GATE=BLOCKED
GO_TO_PRODUCTION=NO
```

Para reconsiderar el gate hacen falta: aprobación de los cuatro campos editoriales listados, fotograma/video escritorio verificable, operador con Apache levantado para smoke HTTP, y QA final sin defectos críticos. Aunque el gate técnico llegue a PASS, no desplegar sin aprobación explícita de LEADSUN y procedimiento predeploy de backup, rollback, accesos y verificación.
