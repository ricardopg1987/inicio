# Brief sitio web LCEEP

## 1. Información general del proyecto

- **Nombre del sitio:** LCEEP  
- **URL actual:** https://lceep.cl  
- **Plataforma de origen:** WordPress 6.8.3 (export WXR)  
- **Fecha del export:** 13-11-2025  
- **Idiomas:** Español (es-CL) y English (en) mediante taxonomías de idioma (Polylang u otro sistema similar).  

## 2. Objetivo del sitio

El sitio LCEEP es la presencia web de un centro/grupo de investigación en energía (particularmente energía eólica y energías renovables).  
Sus objetivos principales son:

- Difundir noticias y actividades (seminarios, charlas, eventos).  
- Publicar información del programa ENER / W-ENER y otras iniciativas asociadas.  
- Servir como repositorio público de eventos, seminarios y noticias, en español e inglés.

## 3. Público objetivo

- Académicos e investigadores en energías renovables.  
- Estudiantes de pre y postgrado interesados en energía eólica y sistemas energéticos.  
- Tomadores de decisión y público general interesado en noticias y actividades del LCEEP.  

## 4. Arquitectura de información (secciones principales)

Basado en las categorías y términos del XML:

- **Home / Inicio**
  - Presentación del LCEEP.
  - Acceso rápido a noticias recientes y próximos eventos.

- **Noticias / News**
  - Categorías:
    - `Noticias` (es)
    - `News` (en)
  - Listado de noticias con fecha, título, extracto y enlace a detalle.

- **Eventos / Events**
  - Categorías:
    - `Eventos` (es)
    - `Events` (en)
  - Registro de eventos, congresos y actividades generales.

- **Seminarios LCEEP**
  - Categoría específica: `Seminarios LCEEP`.
  - Archivo de seminarios (título, expositor, fecha, resumen, material descargable si existe).

- **Charlas Energía Eólica / Talk on Wind Energy**
  - Categorías:
    - `Charlas Energía Eólica`
    - `Talk on Wind Energy`
  - Sección especializada para charlas de energía eólica.

- **Programas ENER / W-ENER / Program of SERC**
  - Categorías relacionadas:
    - `ENER`, `ENER 2023`, `ENERs`
    - `W-ENER`, `W-ENER 2022`
    - `Programa de SERC`, `Program of SERC`
  - Páginas informativas por programa (objetivos, equipos, actividades, documentos).

- **Sin categoría / uncategorized**
  - `Sin categoría` (es) y `Sin categoría en` (en).
  - Contenidos que deberán ser revisados y reubicados en secciones adecuadas.

## 5. Contenidos y tipos de contenido

- **Tipo de contenido principal:** Entradas (posts) y páginas (pages).  
- **Taxonomías relevantes:**
  - `category` (Noticias, Eventos, Seminarios LCEEP, etc.).
  - Idiomas: términos específicos para `language` y `term_language` (es/en).
  - Términos relacionados con layouts (`layout_pack`, `layout_category`, `layout_type`, `scope`) que indican uso de un constructor de páginas para diseños predefinidos.

## 6. Requerimientos de diseño

- Mantener una estética académica/profesional, asociada a un centro de investigación.
- Destacar visualmente:
  - Noticias recientes.
  - Próximos seminarios y eventos.
  - Programas clave (ENER, W-ENER, Programa de SERC).
- Soporte para **bilingüismo (es/en)**:
  - Selector de idioma en el encabezado.
  - URLs y menús consistentes por idioma.
- Diseño responsive (desktop, tablet, móvil).

## 7. Requerimientos técnicos

- **Hosting de destino:** servidor con cPanel (PHP + MySQL).
- Opciones de implementación:
  - (a) Nuevo WordPress importando el XML.
  - (b) Sitio estático (HTML/CSS/JS) generado a partir del contenido exportado.
- Estructura esperada para subir vía cPanel:
  - Carpeta `public_html` (o equivalente) con:
    - `index.html` (home)
    - Subcarpetas: `/news`, `/events`, `/seminars`, `/programas`, etc.
- Mantener redirecciones o estructura de URLs lo más cercana posible a la actual, si es factible.

## 8. Navegación propuesta (menú principal)

- Inicio
- Noticias / News
- Eventos / Events
- Seminarios LCEEP
- Charlas Energía Eólica
- Programas (ENER / W-ENER / Programa de SERC)
- Sobre LCEEP (acerca de, misión, equipo, contacto)

## 9. SEO y contenido

- Mantener títulos (H1), fechas y categorías de las entradas.
- Usar meta títulos y descripciones basados en:
  - Título del post.
  - Extracto (si existe) o primeras líneas del contenido.
- Idiomas:
  - Etiquetar correctamente páginas/estructuras en español e inglés.
  - Evitar duplicar contenido sin referencia de idioma.

## 10. Entregables esperados

1. **Maquetación del nuevo sitio** basada en este brief (wireframes o mockups opcionales).  
2. **Versión funcional** (WordPress o sitio estático) lista para subir a cPanel.  
3. **Estructura de carpetas** clara, con HTML/CSS/JS y assets (imágenes, PDFs, etc.).  
4. Documentación mínima:
   - Cómo actualizar noticias, eventos y seminarios.
   - Cómo manejar versiones en español/inglés.

