# LEADSUN H03 · Hero, contacto y controles de video · QA

Fecha: 2026-10-14. Rama: `fix/leadsun-h03-hero-contact-video-controls`. Base real: `694834bb6fcd5e49a51dfeac8877e85a04833d9d`. No se ejecutó merge ni despliegue.

## Cambios

### Visibilidad del hero y legibilidad del header

El selector efectivo es `.home-hero__overlay` en `assets/scss/pages/_home-mockup.scss`. Se redujo exclusivamente la opacidad de los colores del gradiente: escritorio pasó de `.76/.62/.20` a `.68/.52/.12`; móvil pasó de `.18/.72/.86` a `.12/.62/.76`. No se aplicó `opacity` a `.home-hero`, al video, al contenido ni a un contenedor padre.

El gradiente sigue concentrado detrás del copy y se vuelve transparente en la zona abierta del video. El fondo de `.site-header` no se cambió: conserva `rgba(5, 6, 7, .94)`, el borde y el contraste del logo, navegación, CTA y toggler.

La hoja compilada `assets/css/main.css` fue regenerada. La verificación visual sobre fotogramas reales y los cinco anchos queda bloqueada porque Apache y MySQL estaban detenidos y XAMPP exige privilegios root que esta sesión no posee.

### CTA de contacto de Home

La auditoría encontró que el CTA “Evaluar mi proyecto” no tiene meta key ACF ni opción propia. Los únicos campos ACF del cierre son `home_contact_title` y `home_contact_text`; la URL era una asignación de plantilla a `leadsun_quote_page_url()`.

Se cambió esa fuente canónica de plantilla en `front-page.php` a `mailto:ventas@leadsun.cl`. No se modificó `leadsun_contact_channels()`, `admin_email`, `leadsun_forms_primary_recipient`, los headers de correo, la persistencia de leads ni los destinatarios de formularios.

### Controles de videos editoriales

Los singles de entidades montan `template-parts/components/video-responsive.php` desde `template-parts/single/entity-media.php`. Ese embed ahora usa `controls=1` y conserva `autoplay=1`, `mute=1`, `playsinline=1`, `rel=0`, `allowfullscreen` y el `embed_url` validado de `www.youtube-nocookie.com`.

El hero decorativo usa un componente distinto (`video-inline`); `assets/js/modules/video-inline.js` conserva `controls=0`. No se alteraron URLs editoriales ni IDs de videos.

## Diagnóstico de resolución

YouTube decide la calidad de reproducción de forma adaptativa. Ignora `setPlaybackQuality`, `suggestedQuality`, `vq=hd1080` y parámetros obsoletos; un iframe no puede garantizar 1080p. `controls=1` permite abrir el selector manual de calidad cuando YouTube lo ofrece en ese dispositivo y contexto, pero no fuerza una resolución.

El único original identificable sin acceso a la base fue el video documentado de PC Ámbar, ID `ioe2Z_wJo74`. Una consulta de formatos con yt-dlp 2026.08.19 confirmó variantes 1920×1080 a 30 fps en AVC y AV1, además de 720p y resoluciones inferiores. Por tanto, PC Ámbar sí ofrece 1080p en origen.

El reproductor editorial conserva relación 16:9 y vive dentro de `.leadsun-container`, cuyo máximo es 1320 px. En la matriz solicitada hasta 1440 px, el player de ancho completo alcanza como máximo 1320×742.5 px; no escala el original 1920×1080 por encima de su resolución. Cuando hay galería, la columna de video es aún menor. No hay evidencia CSS de sobreescalado en esos anchos.

No fue posible enumerar las demás URLs originales de soluciones/tecnologías porque MySQL no inició. En consecuencia, la disponibilidad global de 1080p queda `NOT_VERIFIED`, aunque PC Ámbar está verificado como disponible. Si se exige 1080p garantizado, se necesita hosting y entrega de video propios, con infraestructura y presupuesto separados.

## QA

- `npm run build`: PASS. Sólo emitió warnings de deprecación ya existentes de Dart Sass/Bootstrap.
- PHP lint de todos los PHP del theme, excluyendo dependencias: PASS.
- `node --check` de todos los JS propios: PASS.
- `git diff --check`: PASS.
- Auditoría estática del CTA: PASS; `front-page.php` contiene el `mailto` solicitado y los archivos de formularios permanecen sin cambios.
- Auditoría estática de video: PASS; singles editoriales con `controls=1`, hero con `controls=0`, y preservación de autoplay/mute/playsinline/youtube-nocookie.
- Fuente PC Ámbar: PASS para 1080p; formatos 1920×1080 confirmados.
- Rutas Home / Solar / Eléctrica / AE6 / RHEA / PC Ámbar / Cotizador y anchos 320 / 390 / 768 / 1024 / 1440: BLOCKED. Apache y MySQL no estaban ejecutándose; `/opt/lampp/lampp startapache` y `startmysql` respondieron “You need to be root to perform this action”. No se declara QA de navegador, contraste por fotograma, toggler, autoplay, consola JS ni HTTP 200 sin un runtime real.

## Gate

```text
HERO_VIDEO_VISIBILITY=BLOCKED
HEADER_READABILITY=BLOCKED
HOME_CONTACT_EMAIL=PASS
CONTENT_VIDEO_CONTROLS=PASS
VIDEO_1080P_FORCED=UNSUPPORTED_YOUTUBE_API
VIDEO_1080P_AVAILABLE=NOT_VERIFIED
REGRESSION_QA=BLOCKED
PRODUCTION_DEPLOYMENT=NO
```

Detalle de `VIDEO_1080P_AVAILABLE`: `PC_AMBAR=PASS`; resto de originales editoriales `NOT_VERIFIED` por indisponibilidad de la base de datos. Para cerrar los gates bloqueados, un operador debe iniciar XAMPP y repetir la matriz de navegador en las siete rutas y cinco anchos, comprobando fotogramas claros/oscuros, navegación/toggler, selector de calidad cuando YouTube lo ofrezca, autoplay silenciado, consola y respuestas HTTP.
