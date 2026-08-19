# LEADSUN Chile · WordPress Theme

Fundación técnica del tema corporativo de LEADSUN Chile.

## Propósito

Esta base deriva conceptualmente de Underscores (`_s`) y conserva sus principios útiles: templates clásicos de WordPress, semántica, accesibilidad y separación de responsabilidades. No arrastra el branding, shortcodes, experimentos ni dependencias históricas del tema de origen.

## Stack

- WordPress clásico
- PHP 8+
- SCSS
- Bootstrap 5 instalado localmente mediante npm
- JavaScript nativo
- ACF Free + Local JSON
- CPT `leadsun_product`
- CPT `leadsun_project`

## Instalación local

```bash
npm install
npm run build
```

Para desarrollo:

```bash
npm run watch
```

`node_modules/` y el source tree de Bootstrap no forman parte del repositorio.

## Dependencia WordPress

Instalar y activar **Advanced Custom Fields (Free)**. La base configura `acf-json/`, pero los grupos de campos definitivos se manifestarán en la siguiente tarea de modelado de contenido.

## Regla arquitectónica

- WordPress nativo: título, editor, extracto, imagen destacada, revisiones.
- ACF Free: atributos estructurados del producto/proyecto.
- CPT: entidades repetibles reales.
- Theme: presentación y composición.

Los CPT están aislados temporalmente en `inc/domain/` para poder extraerlos a un plugin `leadsun-core` en el futuro sin renombrar los modelos públicos.

## Estado

Esta fundación **no implementa la maqueta visual del cliente** ni crea los grupos ACF definitivos. Su objetivo es dejar el tema instalable, versionable y preparado para H01.
