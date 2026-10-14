# EVW-LEADSUN-H03 · Afinación de luminosidad de videos · QA

Fecha: 2026-10-14. Rama: `fix/leadsun-h03-video-luminosity-tuning`. Base real: `ef455d986e0974d3224bd76a1445f0bc2786869a`. No hubo merge, push ni despliegue.

## Diagnóstico antes de intervenir

No se modificó SCSS, JavaScript, plantillas, parámetros de YouTube ni media. Esta es una cápsula de diagnóstico bloqueada por falta de reproducción real, para evitar aplicar brillo a ciegas sobre una pantalla negra o un stream no inspeccionable.

| Superficie | Reproductor real | Overlay/filtro encontrado | Resultado del diagnóstico |
| --- | --- | --- | --- |
| Home hero | `video-inline` + iframe `youtube-nocookie` montado por `assets/js/modules/video-inline.js` | `.home-hero__overlay`; gradiente actual `.68/.52/.12 → transparente` en desktop, gradiente vertical en móvil. Sin `filter`. | El overlay puede reducir luminosidad sólo detrás del copy, pero no se pudo verificar un fotograma para atribuirle el problema. Sin cambio. |
| Home, bloques Solución/Tecnología | `video-inline` + iframe `youtube-nocookie` | Sin overlay local ni `filter`; poster sólo antes de reproducción. | Sin fotograma reproducible; sin cambio. |
| Singles Soluciones, Tecnologías y PC Ámbar | `video-responsive` + iframe `youtube-nocookie` desde `template-parts/single/entity-media.php` | Sin overlay ni `filter` en `.video-responsive`/iframe. | La aparente opacidad puede pertenecer al stream/material. Sin evidencia no se filtró el iframe. |
| Video HTML5 | No se encontró una ruta activa para las superficies solicitadas. | N/A. | NOT_APPLICABLE. |

Los overlays de `.entity-hero` pertenecen al hero de imagen/contenido de entidades, no al iframe editorial `video-responsive`; se excluyeron del alcance. Tampoco se tocaron posters, fallbacks, carga diferida, autoplay, mute, `playsinline`, `controls`, `rel`, URLs, IDs ni `youtube-nocookie`.

## Evidencia visual y limitación

No se obtuvieron capturas antes/después. XAMPP informó Apache y MySQL detenidos; `curl http://localhost/leadsun/` devolvió `000`. En consecuencia no hubo DOM ni reproducción real para Home, AE6 ULTRON BLACK, RHEA U-Series o PC Ámbar, ni un fotograma nocturno/luminoso equivalente para comparar.

No se declara que el overlay sea la causa, que el material original esté apagado ni que el stream esté en baja resolución. Si al recuperar el runtime la opacidad persiste con un fotograma reproducible, evaluar primero el overlay de Hero únicamente; para singles, considerar sólo un filtro leve y localizado en el iframe real después de comparar escenas oscuras y luminosas. Un filtro CSS no recupera nitidez ni garantiza 1080p; `vq=hd1080`, `setPlaybackQuality` y parámetros obsoletos permanecen fuera de alcance.

## Preservación y checks

- `ORIGINAL_MEDIA_UNCHANGED=PASS`: no cambió URL, ID, iframe source, biblioteca ni archivo multimedia.
- `VIDEO_PLAYER_BEHAVIOR_UNCHANGED=PASS`: sin cambios a autoplay, mute, playsinline, controls, carga, fallback o JavaScript.
- `npm run build`: PASS; no hubo cambio SCSS y el CSS compilado permaneció sin cambios. Sólo warnings de deprecación conocidos de Dart Sass/Bootstrap.
- PHP lint de todos los PHP del theme: PASS.
- `git diff --check`: PASS.
- No hubo JS modificado; no aplica un `node --check` adicional a esta cápsula.

## Matriz pendiente al recuperar el entorno

Repetir sobre `/`, `/soluciones/ae6-ultron-black/`, `/soluciones/rhea-u-series/` y `/tecnologias/pc-ambar/` a 320, 390, 768, 1024 y 1440 px. Registrar capturas antes/después del mismo video y fotograma aproximado; incluir escena nocturna y luminosa si existen. Validar LED visibles sin clipping, detalle/color de fondo, texto/CTA/nav de Home, controles de singles, ratio 16:9, consola, overflow y layout.

## Gate

```text
VIDEO_VISUAL_DIAGNOSIS=BLOCKED
HOME_VIDEO_LUMINOSITY=BLOCKED
SOLUTION_VIDEO_LUMINOSITY=BLOCKED
TECHNOLOGY_VIDEO_LUMINOSITY=BLOCKED
LED_HIGHLIGHTS_NOT_CLIPPED=BLOCKED
ORIGINAL_MEDIA_UNCHANGED=PASS
VIDEO_PLAYER_BEHAVIOR_UNCHANGED=PASS
TEXT_AND_NAV_CONTRAST=BLOCKED
RESPONSIVE_REGRESSION=BLOCKED
BUILD_AND_STATIC_CHECKS=PASS
VIDEO_1080P_FORCED=NOT_IN_SCOPE_UNSUPPORTED
PRODUCTION_DEPLOYMENT=NO
```
