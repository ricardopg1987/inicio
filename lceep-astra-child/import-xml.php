<?php
/**
 * LCEEP XML Importer Script - Versión Mejorada
 *
 * Este script importa TODO el contenido del XML de WordPress exportado
 * incluyendo posts, páginas, imágenes, miembros del equipo, etc.
 *
 * IMPORTANTE:
 * 1. Sube este archivo a la raíz de WordPress (junto a wp-config.php)
 * 2. Sube el archivo XML a la misma ubicación
 * 3. Accede a: http://tudominio.com/import-xml.php
 * 4. Sigue las instrucciones en pantalla
 * 5. ELIMINA este archivo después de la importación
 *
 * @package LCEEP_Astra_Child
 * @version 1.1.0
 */

// Cargar WordPress
require_once( dirname( __FILE__ ) . '/wp-load.php' );

// Verificar que el usuario esté autorizado
if ( ! current_user_can( 'manage_options' ) ) {
    wp_die( 'No tienes permisos para acceder a esta página.' );
}

// Configuración para importación pesada
set_time_limit( 0 );
ini_set( 'memory_limit', '512M' );
@ini_set( 'max_execution_time', '0' );

// Desactivar output buffering para que el progreso se vea en tiempo real
if ( ob_get_level() ) {
    ob_end_clean();
}
// Solo usar apache_setenv si está disponible (Apache module)
if ( function_exists( 'apache_setenv' ) ) {
    @apache_setenv('no-gzip', 1);
}
@ini_set('zlib.output_compression', 0);
@ini_set('implicit_flush', 1);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importador LCEEP XML</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 {
            color: #003f7f;
            border-bottom: 4px solid #00a651;
            padding-bottom: 15px;
            margin-bottom: 30px;
            font-size: 2rem;
        }
        h2 {
            color: #003f7f;
            margin-top: 30px;
            margin-bottom: 15px;
        }
        .button {
            background: linear-gradient(135deg, #003f7f 0%, #0066cc 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,63,127,0.3);
        }
        .button:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        .success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 5px solid #28a745;
        }
        .error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 5px solid #dc3545;
        }
        .info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            color: #0c5460;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 5px solid #17a2b8;
        }
        .warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 5px solid #ffc107;
        }
        .progress-container {
            background: #e9ecef;
            border-radius: 10px;
            height: 40px;
            margin: 30px 0;
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        }
        .progress-bar {
            background: linear-gradient(90deg, #00a651 0%, #00d66e 100%);
            height: 100%;
            line-height: 40px;
            color: white;
            text-align: center;
            transition: width 0.5s ease;
            font-weight: 600;
            font-size: 16px;
            width: 0%;
        }
        .log {
            background: #f8f9fa;
            border: 2px solid #dee2e6;
            padding: 20px;
            border-radius: 8px;
            max-height: 500px;
            overflow-y: auto;
            font-family: 'Monaco', 'Courier New', monospace;
            font-size: 13px;
            margin: 20px 0;
        }
        .log-item {
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
            animation: fadeIn 0.3s ease;
        }
        .log-item:last-child {
            border-bottom: none;
        }
        .log-item.success { color: #28a745; }
        .log-item.error { color: #dc3545; }
        .log-item.info { color: #17a2b8; }
        .log-item.warning { color: #ffc107; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .loading {
            animation: pulse 1.5s ease-in-out infinite;
        }

        ul {
            margin-left: 25px;
            margin-top: 10px;
        }
        ul li {
            margin: 8px 0;
        }
        code {
            background: #f8f9fa;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Monaco', 'Courier New', monospace;
            color: #e83e8c;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .stat-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Importador LCEEP XML</h1>

        <?php
        $xml_file = dirname( __FILE__ ) . '/lceep.WordPress.2025-11-13.xml';

        if ( ! file_exists( $xml_file ) ) {
            echo '<div class="error"><strong>❌ ERROR:</strong> No se encuentra el archivo XML. Por favor sube <code>lceep.WordPress.2025-11-13.xml</code> a la raíz de WordPress.</div>';
            echo '<p><a href="' . admin_url() . '" class="button">Volver al Admin</a></p>';
            exit;
        }

        // Si se envía el formulario, realizar la importación
        if ( isset( $_POST['start_import'] ) && check_admin_referer( 'lceep_import' ) ) {

            echo '<div class="info"><strong>⏳ Iniciando importación...</strong> Este proceso puede tardar varios minutos. Por favor no cierres esta ventana.</div>';
            echo '<div class="progress-container"><div class="progress-bar" id="progressBar">0%</div></div>';
            echo '<div class="log" id="importLog">';

            flush();

            // Función helper para actualizar progreso
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

            // Función helper para log
            function log_message( $message, $type = 'info' ) {
                echo '<div class="log-item ' . $type . '">' . $message . '</div>';
                flush();
                if ( ob_get_level() > 0 ) {
                    ob_flush();
                }
            }

            update_progress( 5, '🔍 Verificando WordPress Importer...' );

            // Verificar si WordPress Importer ya está instalado
            $importer_installed = false;

            if ( file_exists( WP_PLUGIN_DIR . '/wordpress-importer/wordpress-importer.php' ) ) {
                // El plugin existe, solo activarlo si no está activo
                if ( ! is_plugin_active( 'wordpress-importer/wordpress-importer.php' ) ) {
                    activate_plugin( 'wordpress-importer/wordpress-importer.php' );
                    log_message( '✅ WordPress Importer activado', 'success' );
                } else {
                    log_message( '✅ WordPress Importer ya está activo', 'success' );
                }
                $importer_installed = true;
            } else {
                // Instalar el plugin
                log_message( '📦 Instalando WordPress Importer...', 'info' );

                require_once ABSPATH . 'wp-admin/includes/file.php';
                require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
                require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                require_once ABSPATH . 'wp-admin/includes/plugin.php';

                WP_Filesystem();

                $plugin_slug = 'wordpress-importer';
                $plugin_zip = 'https://downloads.wordpress.org/plugin/wordpress-importer.latest-stable.zip';

                // Usar Plugin_Upgrader
                $upgrader = new Plugin_Upgrader( new WP_Upgrader_Skin() );
                $installed = $upgrader->install( $plugin_zip );

                if ( ! is_wp_error( $installed ) && $installed ) {
                    activate_plugin( 'wordpress-importer/wordpress-importer.php' );
                    log_message( '✅ WordPress Importer instalado y activado', 'success' );
                    $importer_installed = true;
                } else {
                    log_message( '❌ Error al instalar WordPress Importer', 'error' );
                }
            }

            update_progress( 10 );

            // Cargar el importador
            if ( $importer_installed ) {
                require_once WP_PLUGIN_DIR . '/wordpress-importer/wordpress-importer.php';

                if ( class_exists( 'WP_Import' ) ) {
                    log_message( '✅ WordPress Importer cargado correctamente', 'success' );
                    update_progress( 15 );

                    // Crear instancia del importador
                    $wp_import = new WP_Import();
                    $wp_import->fetch_attachments = true;

                    update_progress( 20, '📥 Importando contenido del XML...' );

                    // Capturar y suprimir la salida del importador
                    ob_start();
                    $wp_import->import( $xml_file );
                    $import_output = ob_get_clean();

                    update_progress( 50, '✅ Contenido del XML importado' );

                    // Ahora importar miembros del equipo
                    log_message( '👥 Creando miembros del equipo...', 'info' );
                    update_progress( 55 );

                    $team_data = array(
                        'doctorado' => array(
                            array('name' => 'José Riveros', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/jose-riveros-e1649723794178.jpg'),
                            array('name' => 'Yamisleydi Salgueiro', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/Yamisleydi-Salgueiro-e1603243733788.jpg'),
                            array('name' => 'Sergio Toledo', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/sergio-toledo.jpg'),
                            array('name' => 'Maryam Sarebanzadeh', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/Docotrado-Maryam-Sarebanzadeh.jpeg'),
                            array('name' => 'Mohammad Ali Hosseinzadeh', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/Doctorado-Mohammad-Ali-Hosseinzadeh-500x500-1.jpg'),
                            array('name' => 'Alejandro Olloqui', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/alejandro-olloqui.jpg'),
                            array('name' => 'Ricardo Pérez Guzmán', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/Doctorado-Ricardo-Perez-Guzman-442x500-1.jpg'),
                            array('name' => 'Carlos Muñoz', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/carlosmunnoz1.jpg'),
                        ),
                        'tecnico' => array(
                            array('name' => 'Alejandra Cabrera', 'image' => 'https://lceep.cl/wp-content/uploads/2018/09/Alejandra-Cabrera-Equipo-tecnico-500x500-1.jpg'),
                            array('name' => 'Evelyn Arellano', 'image' => 'https://lceep.cl/wp-content/uploads/2018/09/Diseno-Evelyn-Arellano-500x500-1.jpg', 'position' => 'Diseño'),
                            array('name' => 'Shirley Valdés Sazo', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/shirley-valdes-sazo.jpg'),
                        ),
                        'logistico' => array(
                            array('name' => 'Melany Campos', 'image' => 'https://lceep.cl/wp-content/uploads/2018/08/Logitico-Melany-Campos-500x500-1.jpg'),
                            array('name' => 'Fabiola Fuentes', 'image' => 'https://lceep.cl/wp-content/uploads/2018/08/Fabiola-Fuentes-500x500-1.jpg'),
                            array('name' => 'Masly Rivera', 'image' => 'https://lceep.cl/wp-content/uploads/2018/08/Logistico-Masly-Rivera-500x500-1.jpg'),
                            array('name' => 'María Jesús Padilla', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/Logistico-Maria-Jesus-Padilla-1-260x300-1.jpg'),
                            array('name' => 'Felipe Herrera', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/felipe_herrera.jpg'),
                        ),
                        'alumnos' => array(
                            array('name' => 'Nicolás Vicencio', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/Alumnos-Nicolas-Vicencio-e1603243796524.png'),
                            array('name' => 'Javier Saavedra', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/Alumnos-Javier-Saavedra-500x500-1.jpg'),
                            array('name' => 'Gerardo Castro', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/gerardo-castro.jpg'),
                            array('name' => 'Consuelo Rodríguez', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/Alumnos-Consuelo-Rodriguez-500x500-1.jpg'),
                            array('name' => 'Pablo López', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/Alumno-Pablo-Lopez-500x500-1.jpg'),
                            array('name' => 'Fernando Díaz', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/Alumnos-Fernando-Diaz-500x500-1.jpg'),
                            array('name' => 'Daniel Faúndez', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/daniel-faundez.jpg'),
                            array('name' => 'Richard Arancibia', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/Alumno-Richard-Arancibia-480x500-1.jpg'),
                            array('name' => 'Sebastián Villagra', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/Alumnos-Sebastian-Villagra-500x500-1.jpeg'),
                            array('name' => 'Jorge Moyano', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/jorge-moyano.jpg'),
                            array('name' => 'Ramón Gutiérrez', 'image' => 'https://lceep.cl/wp-content/uploads/2018/10/Ramon-Gutierrez-500x500-1.jpg'),
                            array('name' => 'Víctor Olea', 'image' => 'https://lceep.cl/wp-content/uploads/2018/10/Victor-Olea-500x500-1.jpg'),
                        ),
                        'ayudantes' => array(
                            array('name' => 'Esteban Bravo', 'image' => 'https://lceep.cl/wp-content/uploads/2018/08/Ayudantes-Esteban-Bravo-500x500-1.jpg'),
                            array('name' => 'Cristian Carrera', 'image' => 'https://lceep.cl/wp-content/uploads/2018/08/Ayudantes-Cristian-Carrera-300x300-1.png'),
                            array('name' => 'Marco Rivera', 'image' => 'https://lceep.cl/wp-content/uploads/2018/06/MarcoRivera.jpg'),
                        ),
                    );

                    $total_members = 0;
                    foreach ( $team_data as $members ) {
                        $total_members += count( $members );
                    }

                    $created_count = 0;
                    $current_progress = 60;
                    $progress_step = 35 / $total_members; // Distribuir el 35% restante entre los miembros

                    foreach ( $team_data as $category_slug => $members ) {
                        // Crear o obtener la categoría
                        $term = term_exists( $category_slug, 'team_category' );
                        if ( ! $term ) {
                            $category_names = array(
                                'doctorado' => 'Doctorado',
                                'tecnico' => 'Equipo Técnico',
                                'logistico' => 'Equipo Logístico',
                                'alumnos' => 'Alumnos',
                                'ayudantes' => 'Ayudantes',
                            );
                            $term = wp_insert_term( $category_names[$category_slug], 'team_category', array( 'slug' => $category_slug ) );
                        }
                        $term_id = is_array( $term ) ? $term['term_id'] : $term;

                        foreach ( $members as $index => $member ) {
                            // Verificar si ya existe
                            $existing = get_posts( array(
                                'post_type' => 'team_member',
                                'title' => $member['name'],
                                'post_status' => 'any',
                                'numberposts' => 1,
                            ));

                            if ( empty( $existing ) ) {
                                // Crear miembro del equipo
                                $post_id = wp_insert_post( array(
                                    'post_title' => $member['name'],
                                    'post_type' => 'team_member',
                                    'post_status' => 'publish',
                                    'post_content' => 'Miembro del equipo LCEEP.',
                                ));

                                if ( $post_id && ! is_wp_error( $post_id ) ) {
                                    // Asignar categoría
                                    wp_set_object_terms( $post_id, $term_id, 'team_category' );

                                    // Guardar meta datos
                                    if ( isset( $member['position'] ) ) {
                                        update_post_meta( $post_id, '_lceep_position', $member['position'] );
                                    }
                                    update_post_meta( $post_id, '_lceep_order', $index );

                                    // Descargar y asignar imagen destacada
                                    require_once( ABSPATH . 'wp-admin/includes/media.php' );
                                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                                    require_once( ABSPATH . 'wp-admin/includes/image.php' );

                                    $image_id = media_sideload_image( $member['image'], $post_id, $member['name'], 'id' );

                                    if ( ! is_wp_error( $image_id ) ) {
                                        set_post_thumbnail( $post_id, $image_id );
                                        log_message( '✅ Creado: ' . $member['name'], 'success' );
                                    } else {
                                        log_message( '⚠️ Creado sin imagen: ' . $member['name'], 'warning' );
                                    }

                                    $created_count++;
                                }
                            } else {
                                log_message( '⏭️ Ya existe: ' . $member['name'], 'info' );
                            }

                            // Actualizar progreso
                            $current_progress += $progress_step;
                            update_progress( round( $current_progress ) );
                        }
                    }

                    update_progress( 95, '✅ Se procesaron ' . $created_count . ' miembros del equipo' );

                    // Finalizar
                    update_progress( 100, '🎉 <strong>¡Importación completada exitosamente!</strong>' );

                    echo '</div>'; // Cerrar log

                    // Contar resultados
                    $posts_count = wp_count_posts( 'post' )->publish;
                    $pages_count = wp_count_posts( 'page' )->publish;
                    $team_count = wp_count_posts( 'team_member' )->publish;
                    $media_count = wp_count_posts( 'attachment' )->inherit;

                    echo '<div class="success">
                        <h2>✅ Importación Completada</h2>
                        <p>El contenido ha sido importado correctamente.</p>
                    </div>';

                    echo '<div class="stats">
                        <div class="stat-box">
                            <div class="stat-number">' . $posts_count . '</div>
                            <div class="stat-label">Posts</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-number">' . $pages_count . '</div>
                            <div class="stat-label">Páginas</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-number">' . $team_count . '</div>
                            <div class="stat-label">Equipo</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-number">' . $media_count . '</div>
                            <div class="stat-label">Medios</div>
                        </div>
                    </div>';

                    echo '<div class="warning">
                        <h3>⚠️ IMPORTANTE - Seguridad</h3>
                        <p><strong>Por favor, elimina este archivo (<code>import-xml.php</code>) del servidor inmediatamente.</strong></p>
                        <p>Puedes eliminarlo vía FTP o desde el Administrador de Archivos de cPanel.</p>
                    </div>';

                    echo '<p style="text-align: center; margin-top: 30px;">
                        <a href="' . admin_url() . '" class="button">📊 Ir al Panel de Administración</a>
                        <a href="' . home_url() . '" class="button" style="background: linear-gradient(135deg, #00a651 0%, #00d66e 100%);">🌐 Ver Sitio Web</a>
                    </p>';

                } else {
                    log_message( '❌ No se pudo cargar la clase WP_Import', 'error' );
                    echo '</div>';
                    echo '<div class="error">No se pudo cargar el importador de WordPress. Por favor, intenta instalar el plugin "WordPress Importer" manualmente.</div>';
                }
            } else {
                log_message( '❌ WordPress Importer no está disponible', 'error' );
                echo '</div>';
                echo '<div class="error">No se pudo instalar o activar WordPress Importer. Por favor, instálalo manualmente desde Plugins → Agregar nuevo.</div>';
            }

        } else {
            // Mostrar formulario de importación
            ?>
            <div class="info">
                <h3>📋 Información del archivo XML</h3>
                <p><strong>Archivo encontrado:</strong> <code><?php echo basename( $xml_file ); ?></code></p>
                <p><strong>Tamaño:</strong> <?php echo size_format( filesize( $xml_file ) ); ?></p>
                <p><strong>Última modificación:</strong> <?php echo date( 'd/m/Y H:i:s', filemtime( $xml_file ) ); ?></p>
            </div>

            <div class="warning">
                <h3>⚠️ Antes de Importar</h3>
                <ul>
                    <li><strong>Backup:</strong> Asegúrate de tener una copia de seguridad de tu base de datos</li>
                    <li><strong>Tiempo:</strong> La importación puede tardar 5-15 minutos</li>
                    <li><strong>Imágenes:</strong> Se descargarán automáticamente todas las imágenes</li>
                    <li><strong>No cerrar:</strong> No cierres esta ventana durante el proceso</li>
                </ul>
            </div>

            <div class="info">
                <h3>📝 Qué se importará:</h3>
                <div class="stats">
                    <div class="stat-box">
                        <div class="stat-number">112</div>
                        <div class="stat-label">Posts</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">42</div>
                        <div class="stat-label">Páginas</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">739</div>
                        <div class="stat-label">Imágenes</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">36+</div>
                        <div class="stat-label">Equipo</div>
                    </div>
                </div>
                <ul>
                    <li>Noticias, Eventos, Seminarios y Charlas</li>
                    <li>Miembros del equipo con fotos (Doctorado, Técnico, Logístico, Alumnos, Ayudantes)</li>
                    <li>Categorías y taxonomías</li>
                    <li>Menús de navegación</li>
                </ul>
            </div>

            <form method="post" action="" id="importForm">
                <?php wp_nonce_field( 'lceep_import' ); ?>
                <div style="text-align: center;">
                    <button type="submit" name="start_import" class="button" id="startButton">
                        🚀 Iniciar Importación
                    </button>
                </div>
            </form>

            <script>
                document.getElementById('importForm').addEventListener('submit', function() {
                    document.getElementById('startButton').disabled = true;
                    document.getElementById('startButton').textContent = '⏳ Importando...';
                });
            </script>
            <?php
        }
        ?>
    </div>

    <script>
        // Auto-scroll del log
        const log = document.getElementById('importLog');
        if (log) {
            setInterval(function() {
                log.scrollTop = log.scrollHeight;
            }, 500);
        }
    </script>
</body>
</html>
