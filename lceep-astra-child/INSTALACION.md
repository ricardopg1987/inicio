# 📘 Guía Completa de Instalación - LCEEP Astra Child Theme

Esta guía te llevará paso a paso por todo el proceso de instalación y configuración del tema LCEEP en WordPress.

---

## 📋 Pre-requisitos

Antes de comenzar, asegúrate de tener:

- ✅ WordPress instalado en tu hosting cPanel
- ✅ Acceso al panel de administración de WordPress
- ✅ Acceso FTP o Administrador de Archivos de cPanel
- ✅ Los siguientes archivos descargados:
  - Carpeta `lceep-astra-child` (el tema)
  - Archivo `lceep.WordPress.2025-11-13.xml` (contenido)
  - Archivo `import-xml.php` (script de importación)

---

## 🚀 Paso 1: Preparar WordPress

### 1.1. Verificar Versión de WordPress

1. Accede al panel de administración de WordPress
2. Ve a **Panel → Actualizaciones**
3. Asegúrate de tener WordPress 5.8 o superior
4. Si hay actualizaciones disponibles, actualiza

### 1.2. Configurar Permalinks

1. Ve a **Ajustes → Enlaces Permanentes**
2. Selecciona **"Nombre de la entrada"**
3. Haz clic en **Guardar cambios**

### 1.3. Backup de Seguridad

**IMPORTANTE:** Antes de cualquier instalación, crea un backup:

1. En cPanel, busca **"Backups"** o **"Copias de Seguridad"**
2. Descarga una copia completa de:
   - Base de datos
   - Archivos del sitio
3. Guarda estos archivos en un lugar seguro

---

## 📦 Paso 2: Instalar Tema Padre (Astra)

### 2.1. Desde el Panel de WordPress

1. Accede a **Apariencia → Temas**
2. Haz clic en **Agregar nuevo**
3. En el buscador, escribe **"Astra"**
4. Encuentra el tema **"Astra"** de Brainstorm Force
5. Haz clic en **Instalar**
6. Una vez instalado, haz clic en **Activar**

### 2.2. Verificación

- El tema Astra debe aparecer como **activo** en Apariencia → Temas
- Tu sitio ahora debe estar usando Astra (con diseño básico)

---

## 🎨 Paso 3: Instalar Tema Hijo LCEEP

### 3.1. Preparar el Tema

1. Localiza la carpeta `lceep-astra-child` en tu computadora
2. Comprime la carpeta completa en formato `. zip`:
   - En Windows: Clic derecho → Enviar a → Carpeta comprimida
   - En Mac: Clic derecho → Comprimir "lceep-astra-child"
   - En Linux: `zip -r lceep-astra-child.zip lceep-astra-child/`

### 3.2. Subir e Instalar

**Opción A: Desde WordPress (Recomendado)**

1. Ve a **Apariencia → Temas → Agregar nuevo**
2. Haz clic en **Subir tema**
3. Haz clic en **Seleccionar archivo**
4. Selecciona `lceep-astra-child.zip`
5. Haz clic en **Instalar ahora**
6. Espera a que se complete la instalación
7. Haz clic en **Activar**

**Opción B: Por FTP**

1. Conecta a tu servidor vía FTP (FileZilla, WinSCP, etc.)
2. Navega a `/wp-content/themes/`
3. Sube la carpeta `lceep-astra-child` (descomprimida)
4. Ve a WordPress: **Apariencia → Temas**
5. Activa **"LCEEP Astra Child"**

### 3.3. Verificación

- En **Apariencia → Temas** debe aparecer **"LCEEP Astra Child"** como activo
- Debajo debe decir: **"Tema padre: Astra"**
- Tu sitio ahora tiene los colores y estilos de LCEEP

---

## 📥 Paso 4: Importar Contenido del XML

### 4.1. Subir Archivos Necesarios

Debes subir 2 archivos a la **raíz de WordPress** (donde está `wp-config.php`):

**Por FTP:**

1. Conecta a tu servidor FTP
2. Navega a la carpeta raíz (donde ves `wp-config.php`, `wp-content`, etc.)
3. Sube estos archivos:
   - `lceep.WordPress.2025-11-13.xml`
   - `import-xml.php`

**Por Administrador de Archivos de cPanel:**

1. Accede a cPanel
2. Abre **Administrador de archivos**
3. Navega a `public_html/` (o tu carpeta raíz)
4. Haz clic en **Cargar**
5. Selecciona ambos archivos y súbelos

### 4.2. Ejecutar la Importación

1. Abre tu navegador
2. Ve a: `http://tudominio.com/import-xml.php`
   - Reemplaza `tudominio.com` con tu dominio real
3. Deberías ver una pantalla titulada **"Importador LCEEP XML"**
4. Lee la información mostrada
5. Haz clic en **"Iniciar Importación"**
6. **NO CIERRES** la ventana durante el proceso
7. Espera a que termine (puede tardar 5-10 minutos)

### 4.3. Qué se Importará

Durante la importación se creará automáticamente:

- ✅ 112 Posts (Noticias, Eventos, Seminarios)
- ✅ 42 Páginas
- ✅ 739 Imágenes y archivos multimedia
- ✅ 36+ Miembros del equipo (con categorías)
- ✅ Categorías y taxonomías
- ✅ Menús de navegación

### 4.4. Verificar la Importación

1. Ve a **Entradas → Todas las entradas**
   - Deberías ver más de 100 entradas
2. Ve a **Páginas → Todas las páginas**
   - Deberías ver más de 40 páginas
3. Ve a **Equipo → Todos los Miembros**
   - Deberías ver 36+ miembros del equipo
4. Ve a **Medios → Biblioteca**
   - Deberías ver cientos de imágenes

### 4.5. IMPORTANTE: Eliminar Script de Importación

Por seguridad, **DEBES** eliminar `import-xml.php` después de la importación:

**Por FTP:**
1. Conéctate a FTP
2. Ve a la raíz
3. Elimina `import-xml.php`

**Por cPanel:**
1. Administrador de archivos
2. Selecciona `import-xml.php`
3. Eliminar

---

## ⚙️ Paso 5: Configuración Básica

### 5.1. Configurar Página de Inicio

1. Ve a **Ajustes → Lectura**
2. Selecciona **"Una página estática"**
3. En **"Página de inicio"**, selecciona una página (ej: "Inicio" o "Home")
4. En **"Página de entradas"**, selecciona "Blog" o "Noticias"
5. Haz clic en **Guardar cambios**

### 5.2. Regenerar Permalinks

1. Ve a **Ajustes → Enlaces Permanentes**
2. Simplemente haz clic en **Guardar cambios** (sin modificar nada)
3. Esto regenera las reglas de reescritura

### 5.3. Configurar Menús

1. Ve a **Apariencia → Menús**
2. Crea un nuevo menú llamado **"Principal"**
3. Agrega las páginas principales:
   - Inicio
   - Noticias
   - Eventos
   - Equipo
   - Contacto
4. En **"Configuración del menú"**, marca **"Menú Principal"**
5. Haz clic en **Guardar menú**

### 5.4. Configurar Logo

1. Ve a **Apariencia → Personalizar → Identidad del sitio**
2. Haz clic en **Seleccionar logotipo**
3. Busca en la biblioteca de medios el logo de LCEEP
4. Ajusta el tamaño si es necesario
5. Haz clic en **Publicar**

---

## 🎯 Paso 6: Personalización Avanzada

### 6.1. Configurar Colores de Astra

1. Ve a **Apariencia → Personalizar → Colores globales**
2. Configura:
   - **Color primario:** #003f7f (azul LCEEP)
   - **Color de acento:** #00a651 (verde energía)
   - **Color de texto:** #1a1a1a
   - **Color de enlaces:** #0066cc

### 6.2. Configurar Tipografía

1. Ve a **Apariencia → Personalizar → Tipografía**
2. **Familia de fuente base:** System Stack o Segoe UI
3. **Familia de fuente de encabezados:** Georgia
4. **Tamaño de fuente base:** 16px

### 6.3. Configurar Header

1. Ve a **Apariencia → Personalizar → Header Builder**
2. Arrastra y organiza los elementos:
   - Logo (izquierda)
   - Menú principal (centro/derecha)
   - Selector de idioma (derecha, si usas Polylang)
3. Configura el color de fondo: #003f7f
4. Color de texto: #ffffff

### 6.4. Configurar Footer

1. Ve a **Apariencia → Personalizar → Footer Builder**
2. Agrega 3 widgets en el footer
3. Configura color de fondo: #1a1a1a
4. Color de texto: #ffffff

---

## 👥 Paso 7: Gestionar el Equipo

### 7.1. Revisar Miembros Importados

1. Ve a **Equipo → Todos los Miembros**
2. Deberías ver todos los miembros organizados por categorías:
   - Doctorado
   - Equipo Técnico
   - Equipo Logístico
   - Alumnos
   - Ayudantes

### 7.2. Editar un Miembro

1. Haz clic en cualquier miembro
2. Puedes editar:
   - Nombre (título)
   - Biografía (contenido)
   - Foto (imagen destacada)
   - Cargo/Posición
   - Datos de contacto (email, teléfono)
   - Enlaces sociales (ORCID, ResearchGate, LinkedIn)
   - Orden de aparición
3. Haz clic en **Actualizar**

### 7.3. Agregar Nuevo Miembro

1. Ve a **Equipo → Agregar Nuevo**
2. Rellena todos los campos
3. **Imagen destacada:** Sube una foto del miembro
4. **Categoría:** Selecciona una categoría (Doctorado, Técnico, etc.)
5. **Detalles del Miembro:** Rellena cargo, email, enlaces
6. Haz clic en **Publicar**

### 7.4. Mostrar el Carrusel en una Página

1. Edita cualquier página (ej: "Inicio" o "Equipo")
2. En el editor de bloques, agrega un bloque de **Shortcode**
3. Escribe: `[lceep_team_carousel]`
4. Actualiza la página
5. Al ver la página, deberías ver el carrusel funcionando

**Filtrar por categoría:**
```
[lceep_team_carousel category="doctorado"]
```

---

## 🌐 Paso 8: Multiidioma con Polylang (Opcional)

### 8.1. Instalar Polylang

1. Ve a **Plugins → Agregar nuevo**
2. Busca **"Polylang"**
3. Instala y activa **Polylang**

### 8.2. Configurar Idiomas

1. Ve a **Idiomas → Configuración de idiomas**
2. Agrega el idioma **Español (es_CL)**
3. Agrega el idioma **English (en_US)**
4. Haz clic en **Guardar cambios**

### 8.3. Traducir Contenidos

1. Ve a **Entradas → Todas las entradas**
2. Verás columnas de idiomas (ES/EN)
3. Para traducir una entrada:
   - Haz clic en el ícono "+" del idioma que quieras
   - Escribe el contenido traducido
   - Publica
4. Repite para páginas y miembros del equipo

### 8.4. Configurar Selector de Idioma

1. Ve a **Apariencia → Widgets**
2. En el widget del header, agrega **"Language Switcher"** de Polylang
3. Configuralo para mostrar banderas o texto

---

## 🔧 Paso 9: Plugins Recomendados

### Plugins Esenciales

**Cache y Optimización:**
```
Plugin: LiteSpeed Cache (gratuito)
Instalación: Plugins → Agregar nuevo → Buscar "LiteSpeed Cache"
```

**Optimización de Imágenes:**
```
Plugin: Smush (gratuito)
Instalación: Plugins → Agregar nuevo → Buscar "Smush"
Configuración: Activa compresión automática
```

**Seguridad:**
```
Plugin: Wordfence Security (gratuito)
Instalación: Plugins → Agregar nuevo → Buscar "Wordfence"
```

**Backup:**
```
Plugin: UpdraftPlus (gratuito)
Instalación: Plugins → Agregar nuevo → Buscar "UpdraftPlus"
Configuración: Programa backups diarios automáticos
```

### Plugins NO Necesarios

❌ **NO instales:**
- Elementor, Divi Builder (el tema ya tiene todo lo necesario)
- Plugins de sliders (ya está incluido)
- Plugins de team members (ya está incluido)
- Revolution Slider, LayerSlider, etc.

---

## ✅ Paso 10: Verificación Final

### Checklist de Verificación

- [ ] El tema LCEEP Astra Child está activo
- [ ] La importación se completó exitosamente
- [ ] Las imágenes se ven correctamente
- [ ] El menú principal está configurado
- [ ] La página de inicio muestra el contenido esperado
- [ ] El carrusel de equipo funciona
- [ ] El slider de hero funciona
- [ ] Las animaciones aparecen al hacer scroll
- [ ] El sitio es responsive (prueba en móvil)
- [ ] Los enlaces permanentes funcionan correctamente
- [ ] El archivo `import-xml.php` fue eliminado

### Pruebas Recomendadas

1. **Desktop:** Abre el sitio en Chrome, Firefox y Safari
2. **Móvil:** Abre el sitio en tu teléfono
3. **Navegación:** Haz clic en todos los enlaces del menú
4. **Equipo:** Visita la página del equipo y verifica el carrusel
5. **Posts individuales:** Abre varias noticias y eventos
6. **Perfil de miembro:** Abre el perfil de un miembro del equipo

---

## 🐛 Solución de Problemas Comunes

### Problema 1: El tema hijo no aparece para instalar

**Solución:**
- Asegúrate de que estés subiendo la carpeta `lceep-astra-child` comprimida en `.zip`
- Verifica que dentro del `.zip` esté la carpeta `lceep-astra-child` con todos los archivos
- Prueba subirlo por FTP directamente a `/wp-content/themes/`

### Problema 2: Error al activar el tema hijo

**Solución:**
- Verifica que Astra (tema padre) esté instalado
- Asegúrate de que el archivo `style.css` existe y tiene la cabecera correcta
- Verifica los permisos de la carpeta (755)

### Problema 3: El script de importación muestra error 404

**Solución:**
- Verifica que `import-xml.php` esté en la raíz de WordPress
- Asegúrate de acceder a la URL correcta: `http://tudominio.com/import-xml.php`
- Verifica que el archivo tenga permisos de lectura (644)

### Problema 4: La importación se queda congelada

**Solución:**
- Aumenta el `max_execution_time` de PHP a 300 segundos (5 minutos)
- Aumenta el `memory_limit` de PHP a 512MB
- Contacta a tu proveedor de hosting para aumentar estos límites

### Problema 5: Las imágenes no se descargan

**Solución:**
- Verifica que tu servidor pueda hacer peticiones HTTP externas
- Algunas veces el firewall bloquea las descargas
- Contacta a tu hosting para habilitar `allow_url_fopen`

### Problema 6: El carrusel no funciona

**Solución:**
- Abre la consola del navegador (F12)
- Verifica que no haya errores de JavaScript
- Asegúrate de que Swiper.js se esté cargando desde el CDN
- Limpia la caché del navegador y del plugin de cache

### Problema 7: Errores 404 en páginas de equipo

**Solución:**
- Ve a **Ajustes → Enlaces Permanentes**
- Haz clic en **Guardar cambios** sin modificar nada
- Esto regenera las reglas de reescritura de WordPress

---

## 📞 Contacto y Soporte

Si después de seguir esta guía sigues teniendo problemas:

1. **Revisa la consola del navegador** (F12 → Console) para ver errores
2. **Activa el modo debug de WordPress** en `wp-config.php`:
   ```php
   define( 'WP_DEBUG', true );
   define( 'WP_DEBUG_LOG', true );
   ```
3. **Revisa el log de errores** en `/wp-content/debug.log`
4. **Contacta a tu proveedor de hosting** si los problemas son de configuración del servidor

---

## 🎉 ¡Felicitaciones!

Si llegaste hasta aquí y completaste todos los pasos, tu sitio LCEEP debería estar funcionando perfectamente con:

- ✅ Diseño profesional académico
- ✅ Carrusel de equipo interactivo
- ✅ Slider de imágenes hero
- ✅ Animaciones modernas
- ✅ Diseño responsive
- ✅ Todo el contenido importado

**¡Bienvenido a tu nuevo sitio web LCEEP!** 🚀

---

**Tiempo estimado total de instalación:** 30-60 minutos

**Nivel de dificultad:** Intermedio

**Última actualización:** Noviembre 2025
