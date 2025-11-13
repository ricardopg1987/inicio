# LCEEP - Sitio Web Estático

> Laboratorio de Conversión de Energía y Electrónica de Potencia

## 📖 Descripción

Sitio web estático del LCEEP (Laboratorio de Conversión de Energía y Electrónica de Potencia), centro de investigación en energías renovables, energía eólica y sistemas energéticos sostenibles.

Este sitio fue migrado desde WordPress a HTML/CSS/JavaScript estático para facilitar el despliegue en hosting compartido con cPanel.

## 🎯 Características

- ✅ **Completamente estático** - HTML, CSS y JavaScript puro
- ✅ **Bilingüe** - Español e Inglés
- ✅ **Responsive** - Diseño adaptable a todos los dispositivos
- ✅ **Sin dependencias** - No requiere Docker, Node.js, PHP ni base de datos
- ✅ **Listo para cPanel** - Subir y usar directamente
- ✅ **SEO optimizado** - Meta tags, estructura semántica
- ✅ **Accesible** - WCAG 2.1 compatible

## 📁 Estructura del Proyecto

```
lceep-static/
├── index.html                    # Página de inicio (español)
├── en/index.html                 # Página de inicio (inglés)
├── assets/                       # Recursos del sitio
│   ├── css/main.css             # Estilos principales
│   ├── js/main.js               # Funcionalidades JavaScript
│   └── images/                  # Imágenes del sitio
├── noticias/                     # Sección noticias (español)
├── news/                         # Sección noticias (inglés)
├── eventos/                      # Sección eventos (español)
├── events/                       # Sección eventos (inglés)
├── seminarios-lceep/            # Sección seminarios (español)
├── lceep-seminar/               # Sección seminarios (inglés)
├── charlas-energia-eolica/      # Sección charlas (español)
├── talk-on-wind-energy/         # Sección charlas (inglés)
├── programas/                    # Sección programas (español)
│   ├── ener.html
│   ├── w-ener.html
│   └── serc.html
├── programs/                     # Sección programas (inglés)
│   ├── ener.html
│   ├── w-ener.html
│   └── serc.html
├── DESPLIEGUE_CPANEL.md         # Guía de despliegue
└── README.md                     # Este archivo
```

## 🚀 Despliegue

### Requisitos
- Hosting con cPanel
- Acceso FTP o Administrador de Archivos de cPanel

### Pasos de Instalación

1. **Descarga o clona este repositorio**
2. **Sube el contenido de `lceep-static/` a `public_html/` en tu cPanel**
3. **Verifica que `index.html` esté en la raíz de `public_html/`**
4. **Accede a tu dominio para ver el sitio funcionando**

Para instrucciones detalladas, consulta [DESPLIEGUE_CPANEL.md](DESPLIEGUE_CPANEL.md)

## 🎨 Tecnologías Utilizadas

- **HTML5** - Estructura semántica
- **CSS3** - Estilos y diseño responsive
- **JavaScript (Vanilla)** - Funcionalidades interactivas
- **Google Fonts** (opcional) - Tipografías

## 📝 Secciones del Sitio

### Español
- **Inicio** (`/`)
- **Noticias** (`/noticias/`)
- **Eventos** (`/eventos/`)
- **Seminarios LCEEP** (`/seminarios-lceep/`)
- **Charlas Energía Eólica** (`/charlas-energia-eolica/`)
- **Programas** (`/programas/`)
  - ENER - Congreso de Energía Sostenible del Maule
  - W-ENER - Online Meetings of the Worldwide Energy Network
  - Programa de SERC - Conferencias Distinguidas

### Inglés
- **Home** (`/en/`)
- **News** (`/news/`)
- **Events** (`/events/`)
- **LCEEP Seminar** (`/lceep-seminar/`)
- **Talk on Wind Energy** (`/talk-on-wind-energy/`)
- **Programs** (`/programs/`)
  - ENER - Maule Sustainable Energy Congress
  - W-ENER - Online Meetings of the Worldwide Energy Network
  - SERC Program - Distinguished Lectures

## ✏️ Actualización de Contenidos

### Agregar una nueva noticia

1. Crea un nuevo archivo HTML en `/noticias/` usando una plantilla existente
2. Actualiza el listado en `/noticias/index.html`
3. Repite para la versión en inglés en `/news/`

### Modificar estilos

Edita `assets/css/main.css` y sube el archivo actualizado.

### Agregar funcionalidades

Edita `assets/js/main.js` y sube el archivo actualizado.

## 🔧 Personalización

### Colores

Los colores principales están definidos como variables CSS en `assets/css/main.css`:

```css
:root {
    --primary-color: #003f7f;     /* Azul académico */
    --secondary-color: #0066cc;   /* Azul claro */
    --accent-color: #00a651;      /* Verde energía */
}
```

### Tipografía

La tipografía se puede cambiar modificando las variables:

```css
:root {
    --font-primary: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    --font-heading: 'Georgia', serif;
}
```

## 📱 Responsive Design

El sitio está optimizado para:
- **Desktop** (1200px+)
- **Tablet** (768px - 1199px)
- **Móvil** (hasta 767px)

Los breakpoints están definidos en `assets/css/main.css`.

## ♿ Accesibilidad

- Skip links para navegación por teclado
- ARIA labels en elementos interactivos
- Contraste de color adecuado
- Estructura semántica HTML5
- Imágenes con atributos `alt`

## 🌐 SEO

- Meta tags en todas las páginas
- Estructura semántica (H1, H2, H3)
- URLs amigables
- Breadcrumbs de navegación
- Sitemap (se puede generar manualmente o con herramientas)

## 📊 Analítica (Opcional)

Para agregar Google Analytics:

1. Obtén tu código de seguimiento de Google Analytics
2. Agrega el script antes del cierre de `</head>` en todas las páginas:

```html
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=TU-ID-AQUI"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'TU-ID-AQUI');
</script>
```

## 🐛 Reporte de Errores

Si encuentras algún problema:
1. Verifica la consola del navegador (F12 → Console)
2. Revisa la documentación de despliegue
3. Contacta al administrador del sitio

## 📄 Licencia

© 2025 LCEEP - Laboratorio de Conversión de Energía y Electrónica de Potencia
Universidad de Talca, Chile

---

## 📞 Contacto

**LCEEP**
Laboratorio de Conversión de Energía y Electrónica de Potencia
Universidad de Talca
Curicó, Chile

- **Email:** info@lceep.cl
- **Web:** https://lceep.cl

---

**Desarrollado para LCEEP** - Migración de WordPress a sitio estático HTML/CSS/JS
