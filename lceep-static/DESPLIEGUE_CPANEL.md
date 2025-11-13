# Guía de Despliegue del Sitio Estático LCEEP en cPanel

## 📋 Descripción

Este documento describe cómo desplegar el sitio estático LCEEP en un hosting compartido con cPanel.

El sitio es **100% estático** (HTML/CSS/JS) y no requiere ningún backend, base de datos, PHP, Node.js, ni Docker.

---

## 📁 Estructura del Sitio

```
lceep-static/
├── index.html                          # Página de inicio (español)
├── en/
│   └── index.html                      # Página de inicio (inglés)
├── assets/
│   ├── css/
│   │   └── main.css                   # Estilos principales
│   ├── js/
│   │   └── main.js                    # JavaScript funcional
│   └── images/                        # Imágenes (agregar según necesidad)
├── noticias/
│   ├── index.html                     # Listado de noticias (español)
│   ├── destacado-doctor-ingenieria-electronica.html
│   └── cuarto-simposio-energias-renovables.html
├── news/
│   └── index.html                     # Listado de noticias (inglés)
├── eventos/
│   └── index.html                     # Listado de eventos (español)
├── events/
│   └── index.html                     # Listado de eventos (inglés)
├── seminarios-lceep/
│   └── index.html                     # Listado de seminarios (español)
├── lceep-seminar/
│   └── index.html                     # Listado de seminarios (inglés)
├── charlas-energia-eolica/
│   └── index.html                     # Listado de charlas (español)
├── talk-on-wind-energy/
│   └── index.html                     # Listado de charlas (inglés)
├── programas/
│   ├── index.html                     # Índice de programas (español)
│   ├── ener.html                      # Programa ENER
│   ├── w-ener.html                    # Programa W-ENER
│   └── serc.html                      # Programa SERC
└── programs/
    ├── index.html                     # Índice de programas (inglés)
    ├── ener.html                      # Programa ENER (inglés)
    ├── w-ener.html                    # Programa W-ENER (inglés)
    └── serc.html                      # Programa SERC (inglés)
```

---

## 🚀 Pasos para el Despliegue en cPanel

### Opción 1: Usando el Administrador de Archivos de cPanel

1. **Accede a cPanel**
   - Ingresa a tu panel de control de cPanel
   - Usuario y contraseña proporcionados por tu proveedor de hosting

2. **Abre el Administrador de Archivos**
   - Busca el ícono "Administrador de archivos" o "File Manager"
   - Navega a la carpeta `public_html` (o `www`, `htdocs` según tu hosting)

3. **Limpia la carpeta de destino (opcional)**
   - Si hay archivos anteriores de WordPress u otro sitio, elimínalos o respalda en otra carpeta
   - **IMPORTANTE:** Asegúrate de hacer backup de cualquier contenido existente antes de eliminar

4. **Sube los archivos del sitio estático**
   - Opción A: **Subir archivos comprimidos** (recomendado para muchos archivos)
     - Comprime la carpeta `lceep-static` en un archivo `.zip`
     - Haz clic en "Cargar" o "Upload" en el Administrador de Archivos
     - Selecciona el archivo `.zip` y súbelo
     - Una vez subido, selecciona el archivo `.zip`, haz clic derecho y selecciona "Extraer" o "Extract"
     - Mueve el contenido de la carpeta `lceep-static` directamente a `public_html`

   - Opción B: **Subir archivos directamente**
     - Sube todos los archivos y carpetas desde `lceep-static/` a `public_html/`
     - Mantén la estructura de carpetas exactamente como está

5. **Verificar la estructura**
   - Asegúrate de que `index.html` esté en la raíz de `public_html/`
   - Verifica que las carpetas `assets/`, `noticias/`, `eventos/`, etc. estén en el nivel correcto

6. **Establecer permisos (si es necesario)**
   - Archivos HTML: permisos `644` (lectura para todos, escritura solo para propietario)
   - Carpetas: permisos `755` (lectura y ejecución para todos, escritura solo para propietario)
   - Generalmente cPanel establece estos permisos automáticamente

### Opción 2: Usando FTP/SFTP

1. **Conecta con un cliente FTP**
   - Usa un cliente como FileZilla, WinSCP, o Cyberduck
   - Datos de conexión (proporcionados por tu hosting):
     - **Host/Servidor:** ftp.tudominio.com o IP del servidor
     - **Usuario:** tu usuario de cPanel
     - **Contraseña:** tu contraseña de cPanel
     - **Puerto:** 21 (FTP) o 22 (SFTP)

2. **Navega a la carpeta de destino**
   - En el lado remoto (servidor), navega a `public_html/`
   - En el lado local, navega a la carpeta `lceep-static/`

3. **Sube los archivos**
   - Selecciona **todo el contenido** dentro de `lceep-static/`
   - Arrastra o sube a la carpeta `public_html/`
   - Espera a que se complete la transferencia

4. **Verifica la subida**
   - Comprueba que todos los archivos y carpetas se hayan subido correctamente
   - Verifica el tamaño de los archivos para asegurar que no se corrompieron

---

## 🌐 Estructura de URLs

Una vez desplegado, las URLs serán:

### Español
- **Home:** `https://tudominio.com/` o `https://tudominio.com/index.html`
- **Noticias:** `https://tudominio.com/noticias/`
- **Eventos:** `https://tudominio.com/eventos/`
- **Seminarios:** `https://tudominio.com/seminarios-lceep/`
- **Charlas:** `https://tudominio.com/charlas-energia-eolica/`
- **Programas:** `https://tudominio.com/programas/`

### Inglés
- **Home:** `https://tudominio.com/en/`
- **News:** `https://tudominio.com/news/`
- **Events:** `https://tudominio.com/events/`
- **Seminars:** `https://tudominio.com/lceep-seminar/`
- **Talks:** `https://tudominio.com/talk-on-wind-energy/`
- **Programs:** `https://tudominio.com/programs/`

### Posts individuales
- **Noticia:** `https://tudominio.com/noticias/destacado-doctor-ingenieria-electronica.html`
- **Programa:** `https://tudominio.com/programas/ener.html`

---

## ✅ Verificación del Despliegue

Después de subir los archivos, verifica que todo funcione correctamente:

1. **Página de inicio**
   - Visita `https://tudominio.com/`
   - Verifica que el diseño se muestre correctamente
   - Comprueba que el menú de navegación funcione

2. **Navegación entre páginas**
   - Haz clic en cada enlace del menú
   - Verifica que todas las páginas carguen correctamente

3. **Cambio de idioma**
   - Haz clic en el selector de idioma (ES/EN)
   - Verifica que cambie entre versiones español/inglés

4. **Responsive design**
   - Abre el sitio en diferentes dispositivos:
     - Desktop/Laptop
     - Tablet
     - Móvil
   - Verifica que el diseño se adapte correctamente

5. **Menú móvil**
   - En un dispositivo móvil o reduciendo el tamaño de la ventana
   - Verifica que aparezca el botón de menú hamburguesa (☰)
   - Comprueba que el menú se despliegue al hacer clic

---

## 📝 Actualización de Contenidos

### Agregar una nueva noticia

1. **Crea un nuevo archivo HTML**
   - Copia un post existente como plantilla (ej. `destacado-doctor-ingenieria-electronica.html`)
   - Renómbralo según el título de la noticia (usa guiones, sin espacios ni caracteres especiales)
   - Ejemplo: `nueva-noticia-investigacion.html`

2. **Edita el contenido**
   - Actualiza el `<title>`, meta descripción
   - Modifica el `<h1>` con el título de la noticia
   - Actualiza la fecha en `article-meta`
   - Reemplaza el contenido en `article-content`

3. **Actualiza el listado de noticias**
   - Abre `noticias/index.html`
   - Agrega una nueva tarjeta (`<article class="card">`) con:
     - Título de la noticia
     - Fecha
     - Extracto
     - Enlace al archivo HTML creado

4. **Versión en inglés**
   - Repite los pasos anteriores para la versión en inglés
   - Archivo en: `news/nueva-noticia-investigacion.html`
   - Actualiza: `news/index.html`

5. **Sube los archivos**
   - Sube el nuevo HTML a `public_html/noticias/`
   - Sube el `index.html` actualizado
   - Repite para la versión en inglés

### Actualizar estilos o JavaScript

1. **Edita localmente**
   - Modifica `assets/css/main.css` o `assets/js/main.js`

2. **Sube los archivos actualizados**
   - Sube el archivo modificado a `public_html/assets/css/` o `public_html/assets/js/`
   - Los cambios se aplicarán a todo el sitio automáticamente

3. **Limpia la caché**
   - Puede ser necesario limpiar la caché del navegador para ver los cambios
   - Ctrl+F5 (Windows/Linux) o Cmd+Shift+R (Mac)

### Agregar imágenes

1. **Prepara las imágenes**
   - Optimiza las imágenes (compresión, tamaño adecuado)
   - Formatos recomendados: JPG, PNG, WebP
   - Nombres descriptivos sin espacios ni caracteres especiales

2. **Sube a la carpeta de imágenes**
   - Sube a `public_html/assets/images/`
   - O crea subcarpetas si necesitas organización (ej. `assets/images/noticias/`)

3. **Usa en el HTML**
   ```html
   <img src="../assets/images/nombre-imagen.jpg" alt="Descripción de la imagen">
   ```

---

## 🔧 Configuraciones Opcionales en cPanel

### Configurar redirecciones (opcional)

Si quieres que `www.tudominio.com` redirija a `tudominio.com` (o viceversa):

1. En cPanel, busca "Redirecciones" o "Redirects"
2. Configura una redirección 301 permanente
3. Desde: `www.tudominio.com`
4. Hacia: `tudominio.com`

### Habilitar HTTPS/SSL

La mayoría de los hostings modernos ofrecen certificados SSL gratuitos (Let's Encrypt):

1. En cPanel, busca "SSL/TLS" o "Let's Encrypt"
2. Activa el certificado SSL para tu dominio
3. Habilita la redirección automática de HTTP a HTTPS

### Configurar archivos de error personalizados (opcional)

Para páginas de error 404 personalizadas:

1. Crea un archivo `404.html` en `public_html/`
2. En cPanel, busca "Páginas de error" o "Error Pages"
3. Configura el error 404 para que use tu archivo personalizado

### Optimización de velocidad

1. **Habilitar compresión Gzip**
   - En cPanel, busca "Optimizar sitio web" o "Optimize Website"
   - Activa la compresión para HTML, CSS y JavaScript

2. **Caché del navegador**
   - Configura el archivo `.htaccess` para establecer tiempos de caché
   - Ejemplo:
   ```apache
   <IfModule mod_expires.c>
     ExpiresActive On
     ExpiresByType text/css "access plus 1 year"
     ExpiresByType application/javascript "access plus 1 year"
     ExpiresByType image/jpeg "access plus 1 year"
     ExpiresByType image/png "access plus 1 year"
   </IfModule>
   ```

---

## 🐛 Solución de Problemas

### Problema: Las páginas muestran error 404

**Solución:**
- Verifica que los archivos estén en la ubicación correcta
- Comprueba que los nombres de archivos coincidan exactamente (mayúsculas/minúsculas)
- Verifica que los archivos tengan extensión `.html`

### Problema: Los estilos CSS no se cargan

**Solución:**
- Verifica que `assets/css/main.css` exista en el servidor
- Comprueba las rutas en los archivos HTML (deben ser relativas: `../assets/css/main.css`)
- Limpia la caché del navegador (Ctrl+F5)

### Problema: El menú móvil no funciona

**Solución:**
- Verifica que `assets/js/main.js` esté en el servidor
- Comprueba que el archivo JavaScript se cargue correctamente en el navegador (F12 → Console)
- Asegúrate de que no haya errores de JavaScript en la consola

### Problema: Las imágenes no se muestran

**Solución:**
- Verifica que las imágenes estén subidas a `assets/images/`
- Comprueba las rutas en las etiquetas `<img>`
- Verifica que los nombres de archivo coincidan exactamente

---

## 📊 Mantenimiento del Sitio

### Backup regular

1. **Desde cPanel:**
   - Usa la herramienta "Copia de seguridad" o "Backup"
   - Descarga una copia completa del sitio periódicamente

2. **Mediante FTP:**
   - Descarga todos los archivos de `public_html/` a tu computadora local

### Monitoreo

- **Google Analytics:** Puedes agregar el código de seguimiento en el `<head>` de todas las páginas
- **Google Search Console:** Registra tu sitio para monitorear el rendimiento en búsquedas

### Actualizaciones de contenido

- Mantén un calendario editorial para publicar noticias, eventos y seminarios regularmente
- Revisa y actualiza la información de los programas periódicamente
- Elimina contenido obsoleto o archiva en una sección separada

---

## 📞 Soporte

Si encuentras problemas durante el despliegue:

1. Consulta la documentación de tu proveedor de hosting
2. Contacta al soporte técnico de tu hosting (generalmente disponible 24/7)
3. Verifica los foros de la comunidad de tu proveedor de hosting

---

## ✨ Características del Sitio

- ✅ **100% estático** - No requiere backend
- ✅ **Responsive** - Se adapta a móviles, tablets y desktops
- ✅ **Bilingüe** - Español e Inglés
- ✅ **SEO friendly** - Meta tags, estructura semántica
- ✅ **Accesible** - Skip links, ARIA labels
- ✅ **Rápido** - Sin base de datos, carga instantánea
- ✅ **Fácil de actualizar** - Solo HTML, CSS y JS

---

## 📄 Licencia

Este sitio fue desarrollado para LCEEP (Laboratorio de Conversión de Energía y Electrónica de Potencia).

---

**¡Tu sitio estático LCEEP está listo para desplegarse en cPanel!**

Si tienes alguna pregunta, consulta esta documentación o contacta al administrador del sitio.
