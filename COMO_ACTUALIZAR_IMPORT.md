# Cómo Obtener el import-xml.php Actualizado

El archivo `import-xml.php` ha sido actualizado con todas las correcciones necesarias. Aquí tienes **3 opciones** para obtener la versión actualizada:

---

## ✅ Opción 1: Descargar desde GitHub (RECOMENDADO)

### Descarga directa del archivo actualizado:

**Archivo preparado para descarga:**
```
https://raw.githubusercontent.com/ricardopg1987/inicio/claude/lceep-static-site-migration-011CV5uwMnemo9gknjM3WPMJ/import-xml-ACTUALIZADO.php
```

**O descarga el archivo original:**
```
https://raw.githubusercontent.com/ricardopg1987/inicio/claude/lceep-static-site-migration-011CV5uwMnemo9gknjM3WPMJ/lceep-astra-child/import-xml.php
```

### Pasos:
1. Abre cualquiera de las URLs arriba en tu navegador
2. Guarda el archivo como `import-xml.php`
3. Sube el archivo a `/home/marcoriv/public_html/lceep.cl/`
4. Reemplaza el archivo anterior
5. Intenta de nuevo: `http://lceep.cl/import-xml.php`

---

## ✅ Opción 2: Usar Git Pull en tu servidor

Si tienes acceso SSH a tu servidor y el repositorio clonado:

```bash
cd /ruta/al/repositorio
git fetch origin
git checkout claude/lceep-static-site-migration-011CV5uwMnemo9gknjM3WPMJ
git pull origin claude/lceep-static-site-migration-011CV5uwMnemo9gknjM3WPMJ
cp lceep-astra-child/import-xml.php /home/marcoriv/public_html/lceep.cl/
```

---

## ✅ Opción 3: Ver desde GitHub Web

1. Ve a: https://github.com/ricardopg1987/inicio
2. Cambia al branch: `claude/lceep-static-site-migration-011CV5uwMnemo9gknjM3WPMJ`
3. Navega a: `lceep-astra-child/import-xml.php`
4. Copia el contenido completo
5. Pega en tu servidor usando cPanel File Manager o FTP

---

## 📋 Resumen de Cambios (v1.3.0)

El archivo actualizado incluye las siguientes correcciones:

### 1. ✅ Compatibilidad FastCGI/CGI (líneas 36-39)
```php
// Solo usar apache_setenv si está disponible (Apache module)
if ( function_exists( 'apache_setenv' ) ) {
    @apache_setenv('no-gzip', 1);
}
```

### 2. ✅ Carga completa de WordPress Importer (líneas 327-354)
```php
// 1. Cargar la clase base WP_Importer de WordPress core
if ( ! class_exists( 'WP_Importer' ) ) {
    $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
    if ( file_exists( $class_wp_importer ) ) {
        require_once $class_wp_importer;
        log_message( '✅ WP_Importer base cargada', 'success' );
    }
}

// 2. Cargar el archivo principal del plugin
require_once WP_PLUGIN_DIR . '/wordpress-importer/wordpress-importer.php';

// 3. Cargar los parsers XML (requeridos para WP_Import)
$parsers_file = WP_PLUGIN_DIR . '/wordpress-importer/parsers.php';
if ( file_exists( $parsers_file ) ) {
    require_once $parsers_file;
    log_message( '✅ Parsers XML cargados', 'success' );
}

// 4. Cargar la clase WP_Import explícitamente
if ( ! class_exists( 'WP_Import' ) ) {
    $class_wp_import = WP_PLUGIN_DIR . '/wordpress-importer/class-wp-import.php';
    if ( file_exists( $class_wp_import ) ) {
        require_once $class_wp_import;
    }
}
```

### 3. ✅ Detección de WordPress Importer existente (líneas 289-297)
```php
if ( file_exists( WP_PLUGIN_DIR . '/wordpress-importer/wordpress-importer.php' ) ) {
    // El plugin existe, solo activarlo si no está activo
    if ( ! is_plugin_active( 'wordpress-importer/wordpress-importer.php' ) ) {
        activate_plugin( 'wordpress-importer/wordpress-importer.php' );
        log_message( '✅ WordPress Importer activado', 'success' );
    } else {
        log_message( '✅ WordPress Importer ya está activo', 'success' );
    }
    $importer_installed = true;
}
```

### 4. ✅ Información de debugging mejorada (líneas 522-532)
```php
$plugin_dir = WP_PLUGIN_DIR . '/wordpress-importer';
$main_file = $plugin_dir . '/wordpress-importer.php';
$class_file = $plugin_dir . '/class-wp-import.php';
$parsers_file = $plugin_dir . '/parsers.php';

echo '<div class="log-item error">📁 Ruta del plugin: ' . $plugin_dir . '</div>';
echo '<div class="log-item ' . (file_exists($main_file) ? 'success' : 'error') . '">📄 wordpress-importer.php: ' . (file_exists($main_file) ? '✅ Existe' : '❌ No existe') . '</div>';
echo '<div class="log-item ' . (file_exists($class_file) ? 'success' : 'error') . '">📄 class-wp-import.php: ' . (file_exists($class_file) ? '✅ Existe' : '❌ No existe') . '</div>';
echo '<div class="log-item ' . (file_exists($parsers_file) ? 'success' : 'error') . '">📄 parsers.php: ' . (file_exists($parsers_file) ? '✅ Existe' : '❌ No existe') . '</div>';
echo '<div class="log-item info">🔍 Clases: ' . (class_exists('WP_Importer') ? 'WP_Importer ✅' : 'WP_Importer ❌') . ' | ' . (class_exists('WP_Import') ? 'WP_Import ✅' : 'WP_Import ❌') . ' | ' . (class_exists('WXR_Parser') ? 'WXR_Parser ✅' : 'WXR_Parser ❌') . '</div>';
```

### 5. ✅ Barra de progreso en tiempo real (líneas 256-273)
```php
function update_progress( $percent, $message = '' ) {
    echo '<script>
        var bar = document.getElementById("progressBar");
        if (bar) {
            bar.style.width = "' . $percent . '%";
            bar.textContent = "' . $percent . '%";
        }
    </script>';

    if ( $message ) {
        echo '<div class="log-item">' . $message . '</div>';
    }

    flush();
    if ( ob_get_level() > 0 ) {
        ob_flush();
    }
}
```

---

## 🐛 Errores Solucionados

✅ **Fatal error: Call to undefined function apache_setenv()**
- Solución: Verificación `function_exists()`

✅ **Fatal error: Class "WP_Import" not found**
- Solución: Carga explícita de `class-wp-import.php`

✅ **Fatal error: Class "WXR_Parser" not found**
- Solución: Carga de `parsers.php` antes de `class-wp-import.php`

✅ **Barra de progreso no avanza**
- Solución: `flush()` y `ob_flush()` después de cada actualización

✅ **WordPress Importer se reinstala innecesariamente**
- Solución: Verificación de existencia con `file_exists()`

---

## 🔍 Verificar la Versión del Archivo

Para verificar que tienes la versión correcta, busca estas líneas en tu archivo:

**Línea ~16:**
```php
 * @version 1.1.0
```

**Líneas ~37-39:**
```php
if ( function_exists( 'apache_setenv' ) ) {
    @apache_setenv('no-gzip', 1);
}
```

**Líneas ~341-346:**
```php
// 3. Cargar los parsers XML (requeridos para WP_Import)
$parsers_file = WP_PLUGIN_DIR . '/wordpress-importer/parsers.php';
if ( file_exists( $parsers_file ) ) {
    require_once $parsers_file;
    log_message( '✅ Parsers XML cargados', 'success' );
}
```

Si ves estas líneas, tienes la versión correcta! ✅

---

## 📞 ¿Problemas?

Si después de actualizar el archivo sigues teniendo problemas, revisa el mensaje de debugging que aparece en pantalla. Te mostrará:

- ✅/❌ Si los archivos del plugin existen
- ✅/❌ Si las clases están cargadas
- 📁 La ruta del plugin

Esto te ayudará a identificar el problema exacto.

---

**Última actualización:** 2025-11-13
**Versión del script:** 1.3.0
**Commits aplicados:**
- 84b6a2f - Agregar carga de parsers.php para WXR_Parser class
- a235259 - Corregir carga de clase WP_Import
- c3bc4c5 - Corregir compatibilidad FastCGI/CGI
