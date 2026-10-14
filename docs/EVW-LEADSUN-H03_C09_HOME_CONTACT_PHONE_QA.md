# EVW-LEADSUN-H03-C09 · Contacto Home: teléfono visible y centrado móvil

Fecha: 2026-10-14. Rama: `fix/leadsun-h03-home-contact-phone-mobile-align`. Base real: `fea9489286f50e1d0b2a1a21f148d3638e5b40c4`. No se realizó merge, push ni despliegue.

## Fuente canónica

La auditoría no encontró campo ACF para teléfono de Home. El canal se construye en `leadsun_contact_channels()` (`inc/presentation/home.php`); su valor `phone` estaba codificado como cadena vacía. La fuente operativa existente para WhatsApp es la opción WordPress `leadsun_whatsapp_number`, normalizada por `leadsun_whatsapp_number()` en `inc/forms/whatsapp.php`.

Consulta WP-CLI de sólo lectura ejecutada antes del cambio:

```bash
wp --path=/opt/lampp/htdocs/leadsun option get leadsun_whatsapp_number
```

Resultado: `56983329841`. No se modificó base de datos, opciones, ACF, destinatarios de correo ni leads; por tanto no fue necesario respaldo de BD.

## Implementación

- Se añadieron `leadsun_contact_phone_display()` y `leadsun_contact_phone_url()`, ambas derivadas exclusivamente de `leadsun_whatsapp_number()`.
- Para el número chileno configurado, el display resultante es `+56 9 8332 9841` y el destino es `tel:+56983329841`.
- `leadsun_contact_channels()` ahora provee el display de teléfono desde el helper, en vez de una cadena vacía.
- `front-page.php` imprime un único enlace de teléfono condicionado a valor y URL válidos. Se mantienen escapes `esc_url()` y `esc_html()`.
- El CTA de cierre de Home sigue siendo `mailto:ventas@leadsun.cl`; no se cambió la configuración de correo ni el canal de correo existente.
- WhatsApp continúa usando `https://wa.me/56983329841` y su mensaje configurable existente.

## Centrado móvil

El selector real del listado es `.home-contact__channels`; los pares se controlan mediante `.home-contact__channel` y `.home-contact__content`.

En `max-width: 767.98px`:

- la lista pasa a una columna con `justify-items: center`;
- cada canal usa flex vertical centrado, con separación regular entre icono y contenido;
- contenido, etiqueta, teléfono, correo y WhatsApp se centran sin afectar escritorio;
- el enlace directo de teléfono recibe el mismo color, tamaño y `overflow-wrap` que los valores existentes.

El layout de escritorio de tres columnas y sus pares icono/texto no se modifica.

## QA ejecutado

| Comprobación | Resultado |
| --- | --- |
| Helper aislado con `56983329841` | PASS: display `+56 9 8332 9841`, URL `tel:+56983329841`, WhatsApp normalizado sin cambios. |
| Revisión estática de plantilla | PASS: un único canal de teléfono, enlace condicionado y escapado. |
| CTA ventas Home | PASS estático: `mailto:ventas@leadsun.cl` permanece en `front-page.php`. |
| `npm run build` | PASS; sólo warnings de deprecación existentes de Dart Sass/Bootstrap. |
| PHP lint del theme | PASS. |
| `node --check assets/js/modules/navigation.js` | PASS; JS no fue modificado. |
| `git diff --check` | PASS. |
| HTTP Home / DOM real / teclado / visual 320, 375, 390, 768, 1024, 1440 | BLOCKED_ENVIRONMENT. Apache y MySQL estaban detenidos; `curl http://localhost/leadsun/` devolvió `000`. |

No se declara PASS visual sin navegador y runtime reales. Al restaurar XAMPP, repetir la matriz indicada y comprobar foco de `tel:`, ausencia de overflow y layout de escritorio intacto.

## Gate

```text
HOME_PHONE_VISIBLE=PASS
HOME_PHONE_TEL_LINK=PASS
HOME_CONTACT_MOBILE_CENTERING=BLOCKED
WHATSAPP_NUMBER_UNCHANGED=PASS
HOME_SALES_EMAIL_UNCHANGED=PASS
DESKTOP_REGRESSION=BLOCKED
PRODUCTION_DEPLOYMENT=NO
```
