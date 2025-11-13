# LCEEP Astra Child Theme

> Tema hijo de Astra personalizado para el Laboratorio de Conversión de Energía y Electrónica de Potencia (LCEEP)

## 📖 Descripción

Tema WordPress profesional basado en Astra, diseñado específicamente para el LCEEP con funcionalidades avanzadas incluyendo carrusel de equipo, slider de imágenes, animaciones y diseño responsive.

## ✨ Características

- ✅ **Custom Post Type: Team Members** - Gestión completa del equipo de trabajo
- ✅ **Carrusel Interactivo** - Swiper.js para mostrar miembros del equipo
- ✅ **Hero Slider** - Slider automático en la página de inicio
- ✅ **Animaciones AOS** - Efectos al hacer scroll
- ✅ **Diseño Responsive** - Optimizado para móvil, tablet y desktop
- ✅ **Bilingüe** - Preparado para Polylang (Español/Inglés)
- ✅ **SEO Optimizado** - Estructura semántica y meta tags
- ✅ **Accesible** - WCAG 2.1 compatible
- ✅ **Importador XML** - Script para importar todo el contenido automáticamente

## 📋 Requisitos

- WordPress 5.8 o superior
- PHP 7.4 o superior
- Tema Astra (gratuito) instalado
- Memoria PHP: mínimo 256MB (recomendado 512MB)

## 📦 Instalación

### Paso 1: Instalar Astra (tema padre)

1. Ve a **Apariencia → Temas → Agregar nuevo**
2. Busca **"Astra"**
3. Instala y activa el tema Astra

### Paso 2: Instalar el Tema Hijo LCEEP

1. Descarga la carpeta `lceep-astra-child`
2. Comprime la carpeta en formato `.zip`
3. Ve a **Apariencia → Temas → Agregar nuevo → Subir tema**
4. Selecciona el archivo `.zip` y haz clic en **Instalar ahora**
5. Una vez instalado, haz clic en **Activar**

### Paso 3: Importar el Contenido

1. Sube el archivo `lceep.WordPress.2025-11-13.xml` a la raíz de WordPress (junto a `wp-config.php`)
2. Sube el archivo `import-xml.php` a la misma ubicación
3. Accede a: `http://tudominio.com/import-xml.php`
4. Haz clic en **"Iniciar Importación"**
5. Espera a que termine el proceso (puede tardar 5-10 minutos)
6. **IMPORTANTE:** Elimina `import-xml.php` después de la importación por seguridad

### Paso 4: Configurar Permalinks

1. Ve a **Ajustes → Enlaces Permanentes**
2. Selecciona **"Nombre de la entrada"**
3. Guarda los cambios

### Paso 5: Configurar la Página de Inicio

1. Ve a **Ajustes → Lectura**
2. Selecciona **"Una página estática"**
3. En **"Página de inicio"** selecciona la página que desees como home
4. Guarda los cambios

## 🎨 Personalización

### Colores del Tema

Edita las variables CSS en `style.css` (líneas 14-20):

```css
:root {
    --lceep-primary: #003f7f;       /* Azul académico */
    --lceep-secondary: #0066cc;     /* Azul claro */
    --lceep-accent: #00a651;        /* Verde energía */
}
```

### Logo

1. Ve a **Apariencia → Personalizar → Identidad del sitio**
2. Sube tu logo
3. Ajusta el tamaño según necesites

### Menús

1. Ve a **Apariencia → Menús**
2. Crea un nuevo menú llamado **"Principal"**
3. Agrega las páginas que desees
4. Asigna a la ubicación **"Menú Principal"**

### Slider Principal

Edita las imágenes del slider en `functions.php` (línea 365):

```php
$slides = array(
    array(
        'image' => 'URL_DE_TU_IMAGEN',
        'title' => 'Título del slide',
        'subtitle' => 'Subtítulo del slide',
    ),
);
```

## 👥 Gestión del Equipo

### Agregar un Nuevo Miembro

1. Ve a **Equipo → Agregar Nuevo**
2. Rellena los campos:
   - **Título:** Nombre completo
   - **Contenido:** Biografía
   - **Imagen destacada:** Foto del perfil
   - **Cargo/Posición:** Posición en el equipo
   - **Categoría:** Doctorado, Técnico, Logístico, Alumnos, Ayudantes
   - **Contacto:** Email, teléfono, ORCID, ResearchGate, LinkedIn
3. Publica

### Mostrar el Carrusel de Equipo

Usa el shortcode en cualquier página o post:

```
[lceep_team_carousel]
```

**Con filtro por categoría:**

```
[lceep_team_carousel category="doctorado"]
```

**Opciones disponibles:**
- `category` - Slug de la categoría (doctorado, tecnico, logistico, alumnos, ayudantes)
- `limit` - Número de miembros a mostrar (por defecto: todos)

### Mostrar Hero Slider

```
[lceep_hero_slider]
```

## 📱 Páginas y Plantillas

### Plantillas Incluidas

- `front-page.php` - Página de inicio con secciones especiales
- `single-team_member.php` - Perfil individual de miembro del equipo
- `archive-team_member.php` - Archivo completo del equipo con filtros
- `template-parts/content-team.php` - Parte reutilizable para mostrar miembros

### Usar la Plantilla de Inicio

1. Ve a **Páginas → Todas las páginas**
2. Selecciona tu página de inicio
3. En **Atributos de página → Plantilla**, selecciona **"Front Page"** (si está disponible)
4. Actualiza la página

## 🎯 Shortcodes Disponibles

### Carrusel de Equipo

```
[lceep_team_carousel]
[lceep_team_carousel category="doctorado" limit="6"]
```

### Hero Slider

```
[lceep_hero_slider]
```

## 🔧 Configuración Recomendada de Astra

1. Ve a **Apariencia → Personalizar → Astra Settings**
2. Configura:
   - **Header Builder:** Habilita el nuevo header
   - **Colors:** Usa los colores del tema LCEEP (#003f7f, #00a651)
   - **Typography:** Selecciona fuentes profesionales
   - **Button:** Estilo redondeado con colores del tema
   - **Footer Builder:** Personaliza el footer

## 🌐 Multiidioma (Polylang)

### Instalar Polylang

1. Ve a **Plugins → Agregar nuevo**
2. Busca **"Polylang"**
3. Instala y activa

### Configurar Idiomas

1. Ve a **Idiomas → Configuración de idiomas**
2. Agrega **Español** (es-CL) como idioma principal
3. Agrega **Inglés** (en-US) como idioma secundario
4. Traduce tus páginas, posts y miembros del equipo

## 📊 Widgets y Sidebars

El tema incluye 3 áreas de widgets en el footer:

1. **Footer 1** - Columna izquierda
2. **Footer 2** - Columna central
3. **Footer 3** - Columna derecha

Configúralos en **Apariencia → Widgets**

## 🚀 Optimización y Performance

### Plugins Recomendados

- **LiteSpeed Cache** - Cache y optimización
- **Smush** - Optimización de imágenes
- **WP Rocket** - Cache avanzado (premium)
- **Polylang** - Multiidioma

### Plugins NO Necesarios

El tema ya incluye funcionalidades avanzadas, NO necesitas:
- ❌ Page builders (Elementor, Divi, etc.)
- ❌ Plugins de sliders
- ❌ Plugins de team members
- ❌ Plugins de animaciones

## 📝 Actualizaciones

Para actualizar el tema hijo:

1. Descarga la nueva versión
2. Desactiva el tema actual
3. Elimina la carpeta `lceep-astra-child` del servidor
4. Sube la nueva versión
5. Activa el tema

**IMPORTANTE:** Las personalizaciones en `style.css` y `functions.php` se perderán. Guarda backups antes de actualizar.

## 🐛 Solución de Problemas

### El carrusel no funciona

- Verifica que jQuery esté cargado
- Revisa la consola del navegador (F12) para errores
- Asegúrate de que Swiper.js se esté cargando desde el CDN

### Las animaciones no aparecen

- Verifica que AOS.js se esté cargando
- Limpia la caché del navegador
- Revisa que las clases `data-aos` estén en los elementos

### Las imágenes del equipo no se muestran

- Verifica que las imágenes destacadas estén configuradas
- Revisa los permisos de la carpeta `wp-content/uploads/`
- Asegúrate de que la importación se completó correctamente

### Errores 404 en páginas del equipo

- Ve a **Ajustes → Enlaces Permanentes**
- Haz clic en **Guardar cambios** (sin modificar nada)
- Esto regenerará las reglas de reescritura

## 📞 Soporte

Para reportar bugs o solicitar características:

1. Revisa la documentación completa
2. Verifica la consola del navegador para errores JavaScript
3. Contacta al desarrollador del tema

## 📄 Licencia

Este tema es propiedad de LCEEP y está basado en Astra (GPL v2 o posterior).

- **Astra:** https://wpastra.com/
- **LCEEP:** https://lceep.cl/

## 🙏 Créditos

- **Tema Base:** Astra by Brainstorm Force
- **Carrusel:** Swiper.js
- **Animaciones:** AOS (Animate On Scroll)
- **Iconos:** Unicode Emoji
- **Desarrollo:** Equipo LCEEP

---

**Versión:** 1.0.0
**Última actualización:** Noviembre 2025
**WordPress mínimo:** 5.8
**PHP mínimo:** 7.4
**Astra mínimo:** 3.0

---

## 📚 Recursos Adicionales

- [Documentación de Astra](https://wpastra.com/docs/)
- [Documentación de Swiper](https://swiperjs.com/get-started)
- [Documentación de AOS](https://michalsnik.github.io/aos/)
- [WordPress Codex](https://codex.wordpress.org/)

---

**¡Gracias por usar LCEEP Astra Child Theme!** 🎉
