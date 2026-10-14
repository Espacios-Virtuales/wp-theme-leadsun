# EVW-LEADSUN-H03 · Technology fields and presentation QA

## Identificación

- `EXECUTION_ID=LEADSUN-H03-TECHNOLOGY-FIELDS-PRESENTATION-01`
- `BASE_SHA=a0f7349612e1aaab6cbe9f9175ff2c104c2214e6`
- `BRANCH=feature/leadsun-h03-technology-fields-presentation`
- `FINAL_SHA=SELF` — corresponde al único commit que contiene este documento; el SHA concreto se reporta en el handoff porque un commit no puede contener su propio hash.
- `WORKTREE=CLEAN_AFTER_COMMIT`
- `CPT=leadsun_technology`
- `KNOWN_TECHNOLOGY_ID=22`
- `KNOWN_TECHNOLOGY_SLUG=pc-ambar`

## Auditoría previa

El CPT efectivo se registra en `inc/domain/content-types.php` y soporta título, editor, extracto, imagen destacada y revisiones. ACF Free 6.8.8 está activo. El grupo `group_leadsun_technology` se carga en runtime desde `acf-json/group_leadsun_technology.json` mediante los filtros de `inc/integrations/acf.php`; su ubicación se limita a `post_type == leadsun_technology`.

`ACF_FIELDS_EXISTING`:

| Field key | Field name | Tipo |
| --- | --- | --- |
| `field_leadsun_technology_secondary_image` | `technology_secondary_image` | image |
| `field_leadsun_technology_secondary_image_2` | `technology_secondary_image_2` | image |
| `field_leadsun_technology_secondary_image_3` | `technology_secondary_image_3` | image |
| `field_leadsun_technology_youtube_url` | `technology_youtube_url` | url |
| `field_leadsun_technology_document` | `technology_document` | file |

La galería usa los tres campos `technology_secondary_image*`, elimina IDs duplicados y excluye la imagen destacada. El video usa el campo real `technology_youtube_url` y el reproductor compartido `video-responsive`, con `youtube-nocookie`, `autoplay=1`, `mute=1` y `playsinline=1`.

La relación existente es unidireccional desde `leadsun_project`: `project_solution` y `project_technology`. La ficha tecnológica obtiene soluciones compatibles únicamente cuando un proyecto publicado vincula explícitamente ambas entidades. No se agregó metadato inverso ni una relación paralela.

## Campos agregados

Todos son opcionales, compatibles con ACF Free y exclusivos del editor de `leadsun_technology`.

| Field key | Field name | Tipo |
| --- | --- | --- |
| `field_leadsun_technology_technical_name` | `technology_technical_name` | text |
| `field_leadsun_technology_category_label` | `technology_category_label` | text |
| `field_leadsun_technology_principle_title` | `technology_principle_title` | text |
| `field_leadsun_technology_principle_text` | `technology_principle_text` | textarea |
| `field_leadsun_technology_features` | `technology_features` | textarea, un ítem por línea |
| `field_leadsun_technology_specifications` | `technology_specifications` | textarea, `Nombre | Valor` o tabulación |
| `field_leadsun_technology_applications` | `technology_applications` | textarea, un ítem por línea |
| `field_leadsun_technology_compatibility_note` | `technology_compatibility_note` | textarea |
| `field_leadsun_technology_note` | `technology_note` | textarea |

`ACF_FIELD_KEYS=STABLE_EXISTING_5_PLUS_NEW_9`

La prueba con fixture confirmó guardado y reapertura sin pérdida para texto, especificaciones multilínea, imágenes, URL de video y relaciones. Los fixtures IDs 162–165 se eliminaron al terminar.

## Presentación

`TEMPLATE_COMPONENTS_REUSED`:

- `entity-hero.php`
- `entity-media.php`
- `video-responsive.php`
- `entity-gallery.php`
- `entity-text-list.php`
- `entity-specifications.php`, ahora parametrizable y compartido con soluciones
- `entity-relations.php`
- `entity-quote-cta.php`

`TEMPLATE_COMPONENTS_NEW`:

- `technology-principle.php`
- `technology-notes.php`

Orden verificado: identidad, multimedia, descripción técnica, principio, características, atributos, aplicaciones, soluciones compatibles confirmadas, notas y CTA. Todas las secciones editoriales se omiten cuando están vacías. El CTA usa `/cotizar-proyecto/?tecnologia=<ID>` y el texto “Consultar aplicación”.

El parser de atributos acepta tubería o tabulación, exige nombre y valor, omite líneas inválidas y escapa ambas celdas. Las listas descartan líneas vacías y escapan caracteres especiales. El contenido enriquecido de principio y notas pasa por `wp_kses_post`.

## Preservación de PC Ámbar

`PC_AMBAR_VIDEO_BEFORE_AND_AFTER`:

- Campo: `technology_youtube_url`
- Antes: `https://www.youtube.com/watch?v=ioe2Z_wJo74`
- Después: `https://www.youtube.com/watch?v=ioe2Z_wJo74`

`PC_AMBAR_IMAGES_BEFORE_AND_AFTER`:

- Imagen destacada antes/después: ID 158
- URL observada: `http://localhost/leadsun/wp-content/uploads/2026/08/ChatGPT-Image-Jun-12-2025-09_34_38-AM.png`
- Galería antes/después: los tres campos secundarios vacíos
- Documento antes/después: vacío

`PC_AMBAR_POST_STATUS_BEFORE_AND_AFTER=publish -> publish`

El snapshot de título, extracto, contenido, estado y metadatos multimedia produjo el mismo SHA-256 antes y después: `b0dc23ca0768e9b6ab81b26e5184b8756e4eefb120b577788c6274af62ffa002`.

- `SOLUTION_RELATIONS_MODIFIED=NO`
- `DB_EDITORIAL_MUTATIONS=NONE`
- `PC_AMBAR_EDITORIAL_CONTENT=UNCHANGED`
- `PC_AMBAR_EXISTING_MEDIA=PRESERVED`

## QA ejecutado

### Render y fixtures reversibles

Resultado: 17/17 verificaciones PASS.

- Ficha completa: secciones presentes en el orden editorial definido.
- Ficha parcial: no crea descripciones, listas, tablas, relaciones ni notas vacías.
- PC Ámbar con campos nuevos vacíos: conserva video y CTA; no crea secciones vacías.
- Tabla: dos filas válidas; filas sin separador o valor se omiten sin warnings.
- Listas y tabla: caracteres `&`, `<` y `>` escapados.
- Texto enriquecido: etiquetas no permitidas eliminadas.
- Video: host `youtube-nocookie`, `mute=1` y `playsinline=1`.
- Galería: imagen destacada excluida y medios únicos.
- Sin video/featured en fixture parcial: fallback institucional renderizado.
- Relación: sólo solución publicada vinculada por proyecto publicado.
- Cotizador: `tecnologia=22` resuelve `technology`, ID 22, nombre `PC Ámbar`.
- Regresión de templates de solución y proyecto: PASS.

### Navegador y responsive

Chrome headless validó 30 combinaciones: 6 rutas por 5 anchos (`320`, `390`, `768`, `1024`, `1440`). Rutas: PC Ámbar, fixtures completo y parcial, Skylights, proyecto relacionado y cotizador con `tecnologia=22`.

- `RESPONSIVE_QA=PASS`
- Sin overflow horizontal.
- Sin errores JavaScript.
- Sin respuestas HTTP locales fallidas.
- Sin imágenes rotas o imágenes sin atributo `alt`.
- Sin IDs HTML duplicados o encabezados vacíos.
- Navegación móvil: `.is-open` y `aria-expanded` abren y cierran correctamente.
- `prefers-reduced-motion`: AOS desactivado y sin transformación residual.
- Revisión visual manual de las capturas completas a 390 y 1440 px: PASS.

### Smoke HTTP

El smoke completo respondió 200 en un servidor PHP local temporal conectado a la misma instalación y base de datos:

| Ruta | Estado |
| --- | --- |
| `/tecnologias/` | 200 |
| `/tecnologias/pc-ambar/` | 200 |
| `/soluciones/` | 200 |
| `/soluciones/skylights/` | 200 |
| `/cotizar-proyecto/?tecnologia=22` | 200 |

`TECHNOLOGY_SINGLE_SMOKE=PASS_TEMPORARY_LOCAL_RUNTIME`

`BLOCKED_ENVIRONMENT`: Apache/XAMPP en el puerto 80 dejó de ejecutarse durante el QA. Los intentos `/opt/lampp/lampp startapache` y `sudo -n /opt/lampp/lampp startapache` no pudieron elevar privilegios; el segundo requiere contraseña. Por ello, el comando exacto contra `http://localhost/leadsun` queda pendiente de repetición por el operador. Esta limitación no afectó las pruebas interactivas, ejecutadas contra `127.0.0.1:8765` sin cambiar opciones de WordPress ni datos editoriales.

### Comprobaciones técnicas

- `PHP_LINT=PASS` — todos los PHP del theme.
- `JS_CHECK=N/A` — no se modificó JavaScript.
- `BUILD=PASS` — sólo warnings deprecados ya conocidos de Sass/Bootstrap.
- `DIFF_CHECK=PASS`
- `TECHNOLOGY_ACF_MODEL=PASS`
- `TECHNOLOGY_PRESENTATION=PASS`
- `SOLUTION_CPT_REGRESSION=PASS`
- `PROJECT_CPT_REGRESSION=PASS`
- `QUOTE_CONTEXT=PASS`

## Dependencias de contenido abiertas

`OPEN_CONTENT_DEPENDENCIES`:

- Los nueve campos nuevos de PC Ámbar permanecen vacíos hasta la carga posterior aprobada.
- Las compatibilidades deben registrarse mediante un proyecto publicado que seleccione explícitamente una solución y una tecnología. El proyecto que actualmente referencia PC Ámbar (ID 25) está en borrador y por eso no publica compatibilidades.
- No se cargaron relaciones nuevas, descripción, valores técnicos, PDF ni medios.
- El operador debe repetir el smoke prescrito en puerto 80 después de iniciar Apache/XAMPP.

## Gate

- `OVERALL_QA=PARTIAL_BLOCKED_ENVIRONMENT`
- `TECHNOLOGY_ACF_MODEL=PASS`
- `TECHNOLOGY_PRESENTATION=PASS`
- `PC_AMBAR_EXISTING_MEDIA=PRESERVED`
- `PC_AMBAR_EDITORIAL_CONTENT=UNCHANGED`
- `PC_AMBAR_POST_STATUS=UNCHANGED`
- `SOLUTION_CPT_REGRESSION=PASS`
- `PROJECT_CPT_REGRESSION=PASS`
- `QUOTE_CONTEXT=PASS`
- `RESPONSIVE_QA=PASS`
- `WORKTREE=CLEAN_AFTER_COMMIT`
- `TECHNOLOGY_FIELDS_READY_FOR_CONTENT=YES`
- `PRODUCTION_DEPLOYMENT=NO`

No se declara PASS global mientras el smoke obligatorio de Apache/XAMPP en puerto 80 permanezca pendiente.
