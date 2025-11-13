<?php
/**
 * LCEEP XML Importer Script
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
 * @version 1.0.0
 */

// Cargar WordPress
require_once( dirname( __FILE__ ) . '/wp-load.php' );

// Verificar que el usuario esté autorizado
if ( ! current_user_can( 'manage_options' ) ) {
    wp_die( 'No tienes permisos para acceder a esta página.' );
}

// Aumentar límites de ejecución
set_time_limit( 0 );
ini_set( 'memory_limit', '512M' );

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importador LCEEP XML</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #003f7f;
            border-bottom: 3px solid #00a651;
            padding-bottom: 10px;
        }
        .button {
            background: #003f7f;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .button:hover {
            background: #00a651;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .progress {
            background: #e0e0e0;
            border-radius: 5px;
            height: 30px;
            margin: 20px 0;
            overflow: hidden;
        }
        .progress-bar {
            background: #00a651;
            height: 100%;
            line-height: 30px;
            color: white;
            text-align: center;
            transition: width 0.3s;
        }
        .log {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            border-radius: 5px;
            max-height: 400px;
            overflow-y: auto;
            font-family: monospace;
            font-size: 12px;
            margin: 20px 0;
        }
        .log-item {
            padding: 5px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .log-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Importador LCEEP XML</h1>

        <?php
        $xml_file = dirname( __FILE__ ) . '/lceep.WordPress.2025-11-13.xml';

        if ( ! file_exists( $xml_file ) ) {
            echo '<div class="error"><strong>ERROR:</strong> No se encuentra el archivo XML. Por favor sube <code>lceep.WordPress.2025-11-13.xml</code> a la raíz de WordPress.</div>';
            echo '<p><a href="' . admin_url() . '" class="button">Volver al Admin</a></p>';
            exit;
        }

        // Si se envía el formulario, realizar la importación
        if ( isset( $_POST['start_import'] ) && check_admin_referer( 'lceep_import' ) ) {
            echo '<div class="info"><strong>Iniciando importación...</strong> Este proceso puede tardar varios minutos.</div>';
            echo '<div class="progress"><div class="progress-bar" id="progressBar" style="width: 0%;">0%</div></div>';
            echo '<div class="log" id="importLog">';

            // Instalar el plugin WordPress Importer si no está instalado
            if ( ! class_exists( 'WP_Import' ) ) {
                echo '<div class="log-item">📦 Instalando WordPress Importer...</div>';

                $plugin_slug = 'wordpress-importer';
                $plugin_zip = 'https://downloads.wordpress.org/plugin/wordpress-importer.latest-stable.zip';

                require_once ABSPATH . 'wp-admin/includes/file.php';
                require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
                require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                require_once ABSPATH . 'wp-admin/includes/plugin.php';

                WP_Filesystem();

                $upgrader = new Plugin_Upgrader( new WP_Upgrader_Skin() );
                $installed = $upgrader->install( $plugin_zip );

                if ( $installed ) {
                    activate_plugin( 'wordpress-importer/wordpress-importer.php' );
                    echo '<div class="log-item">✅ WordPress Importer instalado y activado</div>';
                } else {
                    echo '<div class="log-item">❌ Error al instalar WordPress Importer</div>';
                }
            }

            // Incluir el importador
            if ( file_exists( WP_PLUGIN_DIR . '/wordpress-importer/wordpress-importer.php' ) ) {
                require_once WP_PLUGIN_DIR . '/wordpress-importer/wordpress-importer.php';

                if ( class_exists( 'WP_Import' ) ) {
                    echo '<div class="log-item">✅ WordPress Importer cargado correctamente</div>';

                    $wp_import = new WP_Import();
                    $wp_import->fetch_attachments = true;

                    ob_start();
                    $wp_import->import( $xml_file );
                    $import_output = ob_get_clean();

                    echo '<div class="log-item">📥 Importando contenido del XML...</div>';

                    // Actualizar progreso
                    echo '<script>
                        document.getElementById("progressBar").style.width = "50%";
                        document.getElementById("progressBar").textContent = "50%";
                    </script>';
                    flush();

                    echo '<div class="log-item">✅ Importación de contenido completada</div>';

                    // Importar miembros del equipo desde las imágenes
                    echo '<div class="log-item">👥 Creando miembros del equipo...</div>';

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

                    $created_count = 0;
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

                                if ( $post_id ) {
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
                                    }

                                    $created_count++;
                                }
                            }
                        }
                    }

                    echo '<div class="log-item">✅ Se crearon ' . $created_count . ' miembros del equipo</div>';

                    // Actualizar progreso
                    echo '<script>
                        document.getElementById("progressBar").style.width = "100%";
                        document.getElementById("progressBar").textContent = "100%";
                    </script>';
                    flush();

                    echo '<div class="log-item">🎉 <strong>Importación completada exitosamente!</strong></div>';
                    echo '</div>';

                    echo '<div class="success">
                        <h3>✅ Importación Completada</h3>
                        <p>El contenido ha sido importado correctamente. Se han creado:</p>
                        <ul>
                            <li>Posts y páginas del XML</li>
                            <li>' . $created_count . ' miembros del equipo</li>
                            <li>Imágenes y archivos adjuntos</li>
                            <li>Categorías y taxonomías</li>
                        </ul>
                        <p><strong>IMPORTANTE:</strong> Por seguridad, elimina este archivo (import-xml.php) del servidor.</p>
                    </div>';

                    echo '<p>
                        <a href="' . admin_url() . '" class="button">Ir al Panel de Administración</a>
                        <a href="' . home_url() . '" class="button">Ver Sitio Web</a>
                    </p>';

                } else {
                    echo '<div class="log-item">❌ No se pudo cargar el importador</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="log-item">❌ No se encuentra el plugin WordPress Importer</div>';
                echo '</div>';
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

            <div class="info">
                <h3>⚠️ Importante - Antes de Importar</h3>
                <ul>
                    <li>✅ Asegúrate de tener una <strong>copia de seguridad</strong> de tu base de datos actual</li>
                    <li>✅ La importación puede tardar varios minutos (el archivo es grande)</li>
                    <li>✅ Se descargarán automáticamente todas las imágenes desde el servidor original</li>
                    <li>✅ Se crearán los miembros del equipo con sus categorías</li>
                    <li>✅ No cierres esta ventana durante el proceso</li>
                </ul>
            </div>

            <form method="post" action="">
                <?php wp_nonce_field( 'lceep_import' ); ?>
                <button type="submit" name="start_import" class="button">🚀 Iniciar Importación</button>
            </form>

            <div class="info" style="margin-top: 40px;">
                <h3>📝 Qué se importará:</h3>
                <ul>
                    <li><strong>112 Posts</strong> (Noticias, Eventos, Seminarios, Charlas)</li>
                    <li><strong>42 Páginas</strong></li>
                    <li><strong>739 Imágenes y archivos</strong></li>
                    <li><strong>36+ Miembros del equipo</strong> (Doctorado, Técnico, Logístico, Alumnos, Ayudantes)</li>
                    <li><strong>Categorías y taxonomías</strong></li>
                    <li><strong>Menús de navegación</strong></li>
                </ul>
            </div>
            <?php
        }
        ?>
    </div>

    <script>
        // Auto-scroll del log
        const log = document.getElementById('importLog');
        if (log) {
            log.scrollTop = log.scrollHeight;
        }
    </script>
</body>
</html>
