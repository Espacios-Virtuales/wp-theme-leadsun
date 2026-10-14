# LEADSUN Chile · WordPress Theme

Tema corporativo de LEADSUN Chile para presentar soluciones de iluminación solar y eléctrica, tecnologías aplicables y proyectos, y canalizar consultas y solicitudes de cotización.

> **Estado de referencia: 14-10-2026 · H03 / predespliegue.** Desarrollo y ajustes funcionales versionados; **despliegue productivo no autorizado**. La última corrección reportada para el menú corresponde al commit local `ed2b2620910333a89c8c6600e40d24628c543116` (rama `fix/leadsun-h03-nav-extrabold`). El build y los análisis estáticos pasaron; la verificación final en navegador/HTTP de esa corrección continúa pendiente porque el entorno local devolvió `000`. Esta referencia no implica que el commit esté integrado en la rama principal ni publicado en producción.

## 1. Propósito y criterios

La base deriva conceptualmente de Underscores (`_s`) y utiliza **plantillas clásicas de WordPress**, semántica HTML, accesibilidad y separación de responsabilidades. El theme implementa la experiencia web y comercial sin trasladar branding ni dependencias del proyecto de origen.

Principios:

- **WordPress nativo**: título, extracto, editor, imagen destacada, estado editorial y revisiones.
- **ACF Free**: datos estructurados y opcionales; definiciones versionadas en `acf-json/`.
- **CPT y taxonomía**: entidades y clasificación propias del negocio.
- **Theme**: composición visual, navegación, integración multimedia y formularios.
- **Contenido verificable**: no atribuir a LEADSUN proyectos ficticios, especificaciones no confirmadas, certificaciones inexistentes ni medios generados para aparentar instalaciones reales.

## 2. Stack

| Componente | Implementación |
|---|---|
| CMS | WordPress clásico |
| Backend | PHP 8+ |
| Estilos | SCSS / Dart Sass + Bootstrap 5 instalado mediante npm |
| Interacción | JavaScript nativo modular; Bootstrap Icons y AOS en los componentes que los usan |
| Campos editoriales | Advanced Custom Fields **Free** + Local JSON |
| Persistencia | Base de datos WordPress / MySQL-MariaDB |
| Formularios | Validación de servidor, `wp_mail`, registro interno de leads para cotizaciones y derivación a WhatsApp |
| Multimedia | Medios WordPress y reproductor YouTube embebido mediante `youtube-nocookie` |

No requiere Elementor, ACF Pro, WooCommerce, CRM externo ni chatbot de IA.

## 3. Modelo de contenido canónico

Los términos «productos» y «fichas de producto» se utilizan en la comunicación comercial, pero **en WordPress se administran como Soluciones**.

| Tipo | Identificador | Ruta | Función |
|---|---|---|---|
| **Soluciones** | `leadsun_solution` | `/soluciones/` | Luminarias y soluciones comerciales |
| **Tecnologías** | `leadsun_technology` | `/tecnologias/` | Principios y tecnologías aplicables a soluciones |
| **Proyectos** | `leadsun_project` | `/proyectos/` | Obras/casos documentados y su contexto |
| **Leads** | `leadsun_lead` | Sin ruta pública | Solicitudes de cotización registradas para gestión administrativa |

**Taxonomía de soluciones:** `leadsun_solution_line`, con líneas **Solar** y **Eléctrica**. Las landings `/solar/` y `/electrica/` consumen la clasificación correspondiente.

**No crear** `leadsun_product`, `leadsun_line`, `/productos/` ni un catálogo paralelo. Los CPT se mantienen modularizados en `inc/domain/` para una posible extracción futura a `leadsun-core`, sin alterar sus identificadores públicos.

### 3.1 Soluciones

Fuente nativa: título, descripción breve (`post_excerpt`), descripción principal (`post_content`), imagen destacada y estado de publicación.

Campos y bloques implementados o integrados en el flujo editorial:

- Línea Solar/Eléctrica.
- Video (`solution_youtube_url`), imágenes secundarias/galería hasta tres fotografías reales y PDF (`solution_datasheet`) cuando exista.
- Características/beneficios (`solution_benefits`), especificaciones (`solution_specifications`: `Atributo | Valor`), aplicaciones (`solution_applications`) y notas técnicas (`solution_note`).
- Bloque destacado opcional según la solución, relaciones con contenido relacionado y **un solo CTA contextual** al cotizador: `/cotizar-proyecto/?solucion=<ID>`.

Las fichas se componen mediante `single-leadsun_solution.php` y parciales reutilizables. Secciones sin contenido válido se omiten. Un archivo PDF o una certificación no deben mostrarse como disponibles si no han sido entregados y validados.

### 3.2 Tecnologías

Las tecnologías **no son productos**. Describen el funcionamiento, propiedades, escenarios de aplicación e integración con soluciones compatibles.

Además de título, extracto, editor e imagen destacada, el modelo incorpora nueve campos ACF opcionales:

| Campo | Uso |
|---|---|
| `technology_technical_name` | Denominación técnica |
| `technology_category_label` | Categoría o familia tecnológica |
| `technology_principle_title` | Título del principio de funcionamiento |
| `technology_principle_text` | Explicación técnica |
| `technology_features` | Características, una por línea |
| `technology_specifications` | Atributos, formato `Atributo | Valor` |
| `technology_applications` | Aplicaciones, una por línea |
| `technology_compatibility_note` | Alcance/compatibilidad con soluciones |
| `technology_note` | Consideraciones técnicas |

El video e imágenes ya existentes se conservan mediante sus campos multimedia originales (`technology_youtube_url` cuando corresponda, imagen destacada y recursos secundarios). El CTA de tecnología usa el contexto `/cotizar-proyecto/?tecnologia=<ID>`.

La relación inversa con soluciones se presenta **solo cuando existe vinculación confirmada**, utilizando el modelo de relaciones real. No se infiere compatibilidad por coincidencia de nombres o aplicaciones.

### 3.3 Proyectos

Cada proyecto utiliza título, extracto, descripción, imagen destacada y campos como:

- `project_location`: ubicación.
- `project_year`: año, si está verificado.
- `project_secondary_image` y `project_youtube_url`: medios reales disponibles.
- `project_solution`: solución vinculada.
- `project_technology`: tecnología relacionada, cuando corresponda.

El contenido puede vincularse a una solución y, opcionalmente, a una tecnología. Las relaciones se almacenan desde el proyecto y se validan antes de mostrarlas.

**Regla editorial:** conservar los registros demostrativos como borradores. Solo publicar obras reales con datos e imágenes entregados o aprobados por LEADSUN. Se ha preparado una cápsula para un CTA de «Cotizar un proyecto similar»; confirmar su implementación y contrato de contexto en el HEAD efectivo antes de declararlo operativo.

## 4. Estructura y presentación

Rutas principales:

```text
/                              Portada corporativa
/solar/                        Soluciones de línea solar
/electrica/                    Soluciones de línea eléctrica
/soluciones/                   Archivo de soluciones
/soluciones/<slug>/            Ficha individual de solución
/tecnologias/                  Archivo de tecnologías
/tecnologias/<slug>/           Ficha individual de tecnología
/proyectos/                    Archivo de proyectos
/proyectos/<slug>/             Ficha individual de proyecto
/cotizar-proyecto/             Cotizador
```

Archivos y directorios relevantes del theme:

```text
wp-theme-leadsum/
├── functions.php
├── front-page.php
├── header.php
├── footer.php
├── page-leadsun-landing.php
├── single-leadsun_solution.php
├── single-leadsun_technology.php
├── single-leadsun_project.php
├── archive-leadsun_solution.php
├── archive-leadsun_technology.php
├── archive-leadsun_project.php
├── template-parts/
│   ├── components/
│   ├── single/
│   ├── forms/
│   └── project/
├── inc/
│   ├── domain/               CPT, taxonomías y relaciones
│   ├── integrations/         Integración ACF
│   ├── media/                Helpers multimedia
│   ├── forms/                Formularios, lead, correo, WhatsApp
│   └── presentation/         Datos de presentación
├── acf-json/                 Esquemas ACF versionados
├── assets/
│   ├── scss/                 Fuente de estilos
│   ├── css/                  CSS compilado
│   └── js/                   Módulos y recursos
└── docs/                     QA y manual de administración
```

La estructura anterior es un mapa operativo de los componentes documentados; consultar los archivos del commit activo antes de modificar una plantilla.

### Identidad visual

- **Manrope**: encabezados y navegación principal. La última afinación establece **`font-weight: 800`** en enlaces `.navbar-nav`; el botón «Cotizar proyecto» mantiene estilo propio.
- **Inter**: lectura y textos generales según los estilos actuales.
- Paleta oscura con acento rojo LEADSUN y superficies de contraste alto. Valores de la **fundación técnica inicial**: `--ls-red: #e21b23`, `--ls-red-hover: #c9181f`, `--ls-bg: #070a0d`, `--ls-surface: #0d1217`, `--ls-text: #f4f6f8` y `--ls-text-muted: #aab2ba`. **Verificar estos valores contra `assets/scss/` del HEAD vigente; no representan por sí solos un manual de marca oficial aprobado.**
- Responsive: controles, navegación, acciones y secciones editoriales adaptadas a móvil; mantener tablas técnicas y formularios legibles, aunque no todo su texto se centre.

## 5. Flujo comercial vigente

```text
Home / Landing / Ficha de solución o tecnología
                      ↓
         CTA «Cotizar proyecto»
                      ↓
          /cotizar-proyecto/
     (contexto de solución/tecnología)
                      ↓
          Validación del formulario
                      ↓
      Registro interno leadsun_lead
                      ↓
   Notificación operativa por wp_mail
                      ↓
      Derivación contextual a WhatsApp
```

- El cotizador permite seleccionar intereses y antecedentes del proyecto; valida campos y adjuntos según contrato implementado.
- Cada envío de cotización válido se registra como lead interno antes de intentar entregar el correo. Si el transporte de correo falla, el lead no se elimina.
- Los correos operativos se configuran separadamente del HTML de las plantillas. Dirección comercial visible en el CTA de contacto de Home: `ventas@leadsun.cl`.
- WhatsApp de referencia: `+56 9 8332 9841` (`56983329841` en el enlace `wa.me`).
- **No equivale a CRM, facturación, reserva de stock o automatización de ventas.**
- Una prueba con correo interceptado verifica la lógica de emisión, **no** la recepción real en un buzón de producción.

## 6. Multimedia y políticas de calidad

- Portada: video decorativo con autoplay, silencioso y sin controles visibles cuando corresponda; overlays/localización de degradado para dar legibilidad al texto.
- Fichas de soluciones y tecnologías: video principal si existe; si no, imagen destacada y fallback institucional; galería de hasta tres imágenes reales sin duplicar la destacada.
- Videos YouTube: `youtube-nocookie`, relación responsive y controles de reproducción en los singles editoriales para selección manual de calidad cuando YouTube la ofrezca.
- **1080p no puede forzarse por iframe**: YouTube decide calidad de forma adaptativa. La resolución aparente debe diagnosticarse distinguiendo fuente, stream y estilos; no aplicar filtros de brillo/contraste a ciegas.
- `prefers-reduced-motion`, accesibilidad, mobile y contraste se revisan como parte de QA.

## 7. Flujo editorial desde WordPress

1. Ingresar a `/wp-admin/` con un usuario autorizado.
2. Elegir **Soluciones**, **Tecnologías** o **Proyectos** según la entidad real; para una landing o la portada, editar la página/campos específicos disponibles.
3. Completar nombre, descripción breve, cuerpo e imagen destacada; llenar únicamente los campos ACF aplicables a ese tipo.
4. Registrar video, PDF, aplicaciones y especificaciones con material confirmado. Usar `Atributo | Valor` para tablas y una línea por elemento para listas editoriales.
5. Asociar línea Solar/Eléctrica o relaciones entre entidades **solo cuando estén confirmadas**.
6. **Guardar borrador → Vista previa → revisión editorial/técnica LEADSUN → Publicar.**
7. Comprobar en desktop y móvil que imágenes, video, contenido y CTA funcionan y no muestran secciones vacías.

No cambiar un proyecto demo a publicación definitiva ni habilitar una ficha técnica incompleta solo para que aparezca en los archivos públicos. Para una revisión externa temporal, usar un entorno controlado y eliminar/restaurar contenido de demostración antes de desplegar.

Manual del cliente: `docs/LEADSUN_MANUAL_ADMINISTRACION_WEB_v1.0_DRAFT.md` (borrador técnico referenciado en el repo) y versión entregable revisable por separado. La exactitud de pantallas y menú debe verificarse contra WordPress instalado.

## 8. Instalación y desarrollo local

### Requisitos

- PHP 8+ y WordPress con base de datos configurada.
- Node.js/npm.
- Plugin **Advanced Custom Fields (Free)** instalado y activo.
- Ambiente local documentado en Linux/XAMPP: `/opt/lampp/htdocs/leadsun`.

```bash
# Raíz del tema
cd /opt/lampp/htdocs/leadsun/wp-content/themes/wp-theme-leadsum
npm install
npm run build

# Durante desarrollo
npm run watch
```

`node_modules/` y el árbol fuente de Bootstrap son dependencias locales, no archivos fuente versionados del tema. Compilar después de editar SCSS; no parchear únicamente el CSS generado.

### Arranque y diagnóstico

```bash
cd /opt/lampp/htdocs/leadsun
sudo /opt/lampp/lampp start
sudo /opt/lampp/lampp status

wp core is-installed
wp db check
wp option get home
wp option get siteurl

BASE_URL='http://localhost/leadsun'
for path in '/' '/solar/' '/electrica/' '/soluciones/' '/tecnologias/' '/proyectos/' '/cotizar-proyecto/'; do
  printf '%-42s ' "$path"
  curl -sS -o /dev/null -w '%{http_code}\n' "${BASE_URL}${path}"
done
```

**Esperado:** WordPress y base de datos disponibles, URLs locales correctas y HTTP 200 en rutas públicas válidas. Si aparece `HTTP 000`, revisar Apache/red antes de atribuirlo al theme. No modificar `home` o `siteurl` para igualarlos a una URL efímera de ngrok.

### Validación técnica del theme

```bash
cd /opt/lampp/htdocs/leadsun/wp-content/themes/wp-theme-leadsum

npm run build
node --check assets/js/modules/navigation.js
find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l
git diff --check
git status --short
```

Las advertencias deprecadas conocidas de Sass/Bootstrap no deben confundirse con un error de compilación. El lint, la compilación y un `curl 200` **no reemplazan** QA visual/funcional en navegador.

## 9. Validación, respaldo y despliegue

Antes de promover a producción:

1. Confirmar rama, SHA, worktree limpio y cambios realmente integrados; no asumir que una rama de corrección local ya está fusionada.
2. Ejecutar QA visual real en desktop y móvil: navegación, Manrope 800, opacidad del hero, calidad disponible de video, fichas, imágenes, footer y CTA.
3. Validar cotizador, persistencia de lead, correo **con transporte real** y WhatsApp, protegiendo datos de prueba.
4. Revisar aprobación editorial de soluciones, tecnologías, proyectos, certificados y medios.
5. Obtener **aprobación expresa de LEADSUN Chile** antes de migrar o publicar.
6. Generar backup verificable de base de datos y archivos del WordPress destino; definir restauración/rollback.
7. Desplegar en hosting autorizado y ejecutar smoke/QA postdespliegue.

```bash
# Respaldo de BD LOCAL antes de una mutación de datos con WP-CLI
cd /opt/lampp/htdocs/leadsun
wp db export "/tmp/leadsun-prechange-$(date +%Y%m%d-%H%M%S).sql"
```

> **Estado del proyecto:** los informes recientes registran `BUILD_AND_LINT=PASS`, pero la última verificación visual/HTTP de Manrope ExtraBold quedó bloqueada por el entorno. `CLIENT_APPROVAL=PENDING` y `PRODUCTION_DEPLOYMENT=NO`. No declarar `FINAL_QA_PASS` ni dar por terminada la migración sin nueva evidencia.

## 10. Límites de alcance y evolución

No forman parte del flujo actual: ecommerce, stock, pagos, CRM externo, IA conversacional, hosting de video 1080p garantizado, nuevas secciones estructurales ni automatizaciones ajenas al alcance aprobado. Requerimientos adicionales deben evaluarse y presupuestarse por separado.

La separación modular permite evolucionar el sistema sin reescribir contenido ni cambiar los slugs públicos, respetando las entidades reales y las relaciones ya existentes.
