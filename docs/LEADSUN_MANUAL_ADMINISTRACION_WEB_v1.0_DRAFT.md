# LEADSUN Chile · Manual de administración web v1.0 — DRAFT

Estado: borrador operativo, validado contra el código del tema. Debe revisarse
contra la instancia que se entregue al cliente antes de declararlo manual final
o de producción.

## 1. Acceso y responsabilidades

Entre a WordPress mediante la URL institucional que entregue LEADSUN y use su
cuenta personal. No incluya contraseñas en documentos, correos ni planillas. Si
no puede entrar, use el mecanismo institucional de recuperación o solicite a un
administrador que restablezca el acceso.

El sitio cuenta con los contenidos **Soluciones**, **Tecnologías**, **Proyectos**
y **Leads**. Edite sólo los contenidos para los que tenga permiso. La pantalla
**Ajustes > LEADSUN Formularios** requiere la capacidad administrativa
`manage_options`; no corresponde a la operación editorial diaria.

Trabaje siempre en borrador y use **Vista previa** antes de publicar. Para una
corrección menor, actualice el contenido y vuelva a comprobar la página en
móvil y escritorio.

## 2. Inicio / Portada

La portada se administra desde la página configurada como inicio. Con ACF Free
aparecen grupos con estos nombres:

- **LEADSUN · Home · 01 Hero**: `Título Hero`, `Texto Hero`, `Imagen Hero` y
  `URL YouTube Hero`.
- **02 Soluciones**, **03 Condiciones extremas**, **04 Tecnología**, **05
  Proyectos** y **06 Iluminación responsable**: selecciones de contenidos
  publicados que se muestran en sus secciones respectivas.
- **07 Certificaciones**: hasta cinco pares de nombre e imagen.
- **08 Contacto / cierre**: `Título` y `Texto` del cierre de portada.

Use contenido, imágenes y videos aprobados. El Hero muestra la imagen como
respaldo si no hay una URL de YouTube válida. Los botones principales del Hero,
el CTA de contacto y la composición de las secciones pertenecen a la plantilla:
no se editan desde esos campos y requieren soporte técnico si se desea cambiar
el destino, copy o estructura.

## 3. Soluciones

En **Soluciones > Añadir nueva**, complete primero el título, extracto,
contenido y la imagen destacada nativa de WordPress. El extracto se usa como
introducción; el contenido es la descripción ampliada.

Asigne la taxonomía **Líneas de solución** sólo a la línea aprobada (por
ejemplo, Solar o Eléctrica). Las páginas de línea usan esas asignaciones para
mostrar soluciones publicadas.

El grupo ACF **LEADSUN · Solución** permite administrar:

- tres imágenes secundarias para la galería y `URL de YouTube`;
- `Ficha técnica` en filas `Nombre | Valor` (una por línea); por ejemplo,
  `Protección | IP66`;
- `Beneficios`, `Aplicaciones` y `Certificaciones`: un elemento por línea;
- `Ficha técnica PDF`: sólo PDF aprobado;
- `Título destacado`, `Texto destacado`, `Sello destacado`, `Bajada del sello`
  y `Nota editorial`.

No publique especificaciones, certificaciones ni PDF sin respaldo técnico. El
CTA de cotización de una ficha publicada es contextual y se genera por la
plantilla; no agregue otro botón igual dentro del contenido. Las relaciones con
proyectos se gestionan desde el proyecto, no creando metadatos manuales en la
solución.

## 4. Tecnologías

Una **Tecnología** explica un principio, integración o capacidad; no es un
producto ni debe presentar parámetros propios de una luminaria salvo que estén
respaldados y correspondan al alcance editorial.

Además de título, extracto, contenido e imagen destacada, el grupo **LEADSUN ·
Tecnología** tiene tres imágenes secundarias, `URL de YouTube` y `Documento
técnico` (PDF), más estos nueve campos técnicos opcionales:

1. `Nombre técnico`.
2. `Categoría o familia tecnológica`.
3. `Título del principio o funcionamiento`.
4. `Principio o funcionamiento`.
5. `Características de la tecnología` (una por línea).
6. `Atributos técnicos de la tecnología` (`Nombre | Valor` por línea).
7. `Aplicaciones` (una por línea).
8. `Nota de integración o compatibilidad`.
9. `Nota técnica o criterio de alcance`.

Registre únicamente compatibilidades verificadas. La relación visible con
soluciones proviene de proyectos publicados que vinculan ambas entidades; no
afirme compatibilidad si ese respaldo no existe. El CTA de consulta se genera
automáticamente en la ficha.

## 5. Proyectos

En **Proyectos > Añadir nuevo**, complete título, extracto, contenido, imagen
destacada y el grupo **LEADSUN · Proyecto**:

- `Ubicación` (requerido), `Año`, `Aplicación`, `Cantidad`, `Configuración` y
  `Condición del proyecto`.
- tres imágenes secundarias y `URL de YouTube`.
- `Solución relacionada` y `Tecnología relacionada`, ambos selectores de
  contenido existente.

Use fotografías reales con autorización y no complete campos técnicos por
suposición. Los proyectos demo deben mantenerse como **Borrador** y deben
identificarse como DEMO en la revisión interna: no son obras ejecutadas por
LEADSUN.

Cada ficha de proyecto muestra un solo CTA: **Cotizar un proyecto similar**.
Si el proyecto está publicado, el cotizador recibe su contexto; para un
borrador o vista previa, el enlace es genérico y no expone el ID del proyecto.

## 6. Cotizador y Leads

El recorrido actual es:

1. La persona abre `/cotizar-proyecto/`, directamente o desde una solución,
   tecnología o proyecto publicado.
2. Cuando el origen es válido, el formulario muestra el interés contextual.
3. Al enviar una cotización válida, el sitio registra un **Lead** interno y
   realiza el intento de correo.
4. Si está configurado un número de WhatsApp válido, el navegador puede
   redirigir a WhatsApp con el resumen del lead.

En **Leads** revise el nombre, contacto, interés y estado del correo. No edite
manualmente los metadatos del lead ni intente corregir una entrega alterando
PHP. Una prueba sintética debe ser autorizada y usar datos de prueba; no debe
presentarse como una solicitud comercial real ni reemplaza la verificación de
entrega a correo/WhatsApp.

Los campos de destinatarios, copia, número de WhatsApp, mensaje inicial y
video comercial se encuentran en **Ajustes > LEADSUN Formularios** y son tarea
de un administrador autorizado. Cambiarlos afecta comunicaciones reales.

## 7. Videos y multimedia

Ingrese una URL segura y real de YouTube en los campos `URL de YouTube` de
Home, soluciones, tecnologías o proyectos. Use imagen destacada e imágenes
secundarias como respaldo visual y compruebe la reproducción en móvil.

YouTube decide la calidad de forma adaptativa. Un iframe no puede garantizar
1080p ni forzar una resolución mediante parámetros antiguos. Si falta detalle,
revise primero el archivo/origen publicado en YouTube y solicite evaluación
técnica antes de prometer una calidad concreta.

## 8. Publicación y revisión

Use este flujo para contenidos nuevos o cambios sensibles:

1. Guardar como **Borrador**.
2. Completar campos ACF y medios aprobados.
3. Abrir **Vista previa** y comprobar títulos, extracto, galería, enlace,
   video y CTA.
4. Solicitar revisión editorial/técnica de LEADSUN.
5. Publicar sólo con aprobación.

No publique material técnico sin validar, certificados no recibidos, proyectos
ficticios ni contenido DEMO presentado como obra real.

## 9. Navegación, menús y contacto

Los menús registrados son **Navegación principal**, **Footer · Soluciones**,
**Footer · Navegación**, **Footer · Contacto** y **Redes sociales**. Si la
instalación muestra la administración clásica de menús, edítelos desde
**Apariencia > Menús** y asigne cada menú a su ubicación correspondiente. Los
ítems llamados Solar y Eléctrica mantienen su destino hacia las páginas de
línea administrables; compruebe esos enlaces después de renombrar un ítem.

El botón de cotización del header y la estructura móvil del menú provienen de
la plantilla, por lo que cambios de diseño, comportamiento o accesibilidad
requieren soporte técnico.

Datos de referencia actuales para revisión, sujetos a confirmación en la
configuración de la instancia:

- Teléfono/WhatsApp: `+56 9 8332 9841`.
- Correo comercial visible en el CTA de Home: `ventas@leadsun.cl`.

El número visible de teléfono se deriva de la configuración de WhatsApp. El
destinatario de formularios se configura por separado en **LEADSUN Formularios**;
no suponga que cambiar el CTA de Home cambia el receptor de leads.

## 10. Mantenimiento y respaldo

- Conserve una copia aprobada de textos, imágenes, PDF y enlaces antes de
  reemplazarlos.
- Mantenga originales de fotografías y documentación técnica fuera de la
  biblioteca de medios.
- No edite PHP, SCSS, CSS compilado, archivos ACF JSON ni registros de la base
  de datos desde el panel para resolver una necesidad editorial.
- Solicite por separado soporte para cambios estructurales, integraciones,
  formularios, permisos, performance o diseño.

## 11. Checklist antes de publicar

- [ ] Título, extracto y contenido están aprobados y sin afirmaciones no
      verificadas.
- [ ] Imagen destacada, galería, PDF y video son los correctos y tienen origen
      autorizado.
- [ ] Especificaciones `Nombre | Valor`, listas y certificaciones están
      respaldadas.
- [ ] Enlaces, CTA contextual, correo y teléfono apuntan al destino esperado.
- [ ] El contenido se revisó en móvil y escritorio cuando el entorno esté
      disponible.
- [ ] No se publica un demo como proyecto real ni un borrador por error.
- [ ] La revisión LEADSUN autorizó la publicación.

## 12. Limitaciones y pendientes

Este documento describe funciones presentes en el tema y no sustituye un QA en
producción. El estado de servidor, correo, WhatsApp, permisos reales, menús
asignados, contenido cargado y despliegue deben verificarse en la instancia de
entrega.

No existen instrucciones operativas para forzar calidad 1080p, modificar la
lógica de leads, crear relaciones paralelas ni publicar contenido de demo. Las
capturas no se incluyen: deberán tomarse desde la instancia real cuando esté
disponible.

## Anexo técnico interno

No se incluyen comandos WP-CLI en el flujo del operador. La base de datos local
no estaba disponible durante la preparación de este borrador, por lo que los
comandos de mantenimiento o inventario deben ser verificados por soporte en el
entorno autorizado antes de incorporarlos a una versión posterior.
