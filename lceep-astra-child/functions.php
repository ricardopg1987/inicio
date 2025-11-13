<?php
/**
 * LCEEP Astra Child Theme Functions
 *
 * @package LCEEP_Astra_Child
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'LCEEP_CHILD_THEME_VERSION', '1.0.0' );
define( 'LCEEP_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'LCEEP_CHILD_THEME_URI', get_stylesheet_directory_uri() );

/**
 * Enqueue Parent and Child Theme Styles
 */
function lceep_enqueue_styles() {
    // Enqueue parent theme stylesheet
    wp_enqueue_style( 'astra-parent-theme', get_template_directory_uri() . '/style.css', array(), '1.0.0' );

    // Enqueue child theme stylesheet
    wp_enqueue_style( 'lceep-child-theme', get_stylesheet_uri(), array( 'astra-parent-theme' ), LCEEP_CHILD_THEME_VERSION );

    // Enqueue custom CSS
    wp_enqueue_style( 'lceep-custom-css', LCEEP_CHILD_THEME_URI . '/css/custom.css', array(), LCEEP_CHILD_THEME_VERSION );
}
add_action( 'wp_enqueue_scripts', 'lceep_enqueue_styles' );

/**
 * Enqueue Custom Scripts
 */
function lceep_enqueue_scripts() {
    // Enqueue Swiper.js for carousel
    wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css', array(), '10.0.0' );
    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), '10.0.0', true );

    // Enqueue AOS (Animate On Scroll)
    wp_enqueue_style( 'aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array(), '2.3.1' );
    wp_enqueue_script( 'aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), '2.3.1', true );

    // Enqueue custom JavaScript
    wp_enqueue_script( 'lceep-main-js', LCEEP_CHILD_THEME_URI . '/js/main.js', array( 'jquery', 'swiper-js', 'aos-js' ), LCEEP_CHILD_THEME_VERSION, true );

    // Localize script for AJAX
    wp_localize_script( 'lceep-main-js', 'lceepData', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'lceep_nonce' ),
        'themeUri' => LCEEP_CHILD_THEME_URI,
    ));
}
add_action( 'wp_enqueue_scripts', 'lceep_enqueue_scripts' );

/**
 * Register Custom Post Type: Team Member
 */
function lceep_register_team_member_post_type() {
    $labels = array(
        'name'                  => _x( 'Team Members', 'Post Type General Name', 'lceep-astra-child' ),
        'singular_name'         => _x( 'Team Member', 'Post Type Singular Name', 'lceep-astra-child' ),
        'menu_name'             => __( 'Equipo', 'lceep-astra-child' ),
        'name_admin_bar'        => __( 'Miembro del Equipo', 'lceep-astra-child' ),
        'archives'              => __( 'Archivo de Equipo', 'lceep-astra-child' ),
        'attributes'            => __( 'Atributos', 'lceep-astra-child' ),
        'parent_item_colon'     => __( 'Padre:', 'lceep-astra-child' ),
        'all_items'             => __( 'Todos los Miembros', 'lceep-astra-child' ),
        'add_new_item'          => __( 'Agregar Nuevo Miembro', 'lceep-astra-child' ),
        'add_new'               => __( 'Agregar Nuevo', 'lceep-astra-child' ),
        'new_item'              => __( 'Nuevo Miembro', 'lceep-astra-child' ),
        'edit_item'             => __( 'Editar Miembro', 'lceep-astra-child' ),
        'update_item'           => __( 'Actualizar Miembro', 'lceep-astra-child' ),
        'view_item'             => __( 'Ver Miembro', 'lceep-astra-child' ),
        'view_items'            => __( 'Ver Miembros', 'lceep-astra-child' ),
        'search_items'          => __( 'Buscar Miembro', 'lceep-astra-child' ),
        'not_found'             => __( 'No encontrado', 'lceep-astra-child' ),
        'not_found_in_trash'    => __( 'No encontrado en papelera', 'lceep-astra-child' ),
    );

    $args = array(
        'label'                 => __( 'Team Member', 'lceep-astra-child' ),
        'description'           => __( 'Miembros del equipo LCEEP', 'lceep-astra-child' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'taxonomies'            => array( 'team_category' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-groups',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type( 'team_member', $args );
}
add_action( 'init', 'lceep_register_team_member_post_type', 0 );

/**
 * Register Custom Taxonomy: Team Category
 */
function lceep_register_team_category_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Team Categories', 'Taxonomy General Name', 'lceep-astra-child' ),
        'singular_name'              => _x( 'Team Category', 'Taxonomy Singular Name', 'lceep-astra-child' ),
        'menu_name'                  => __( 'Categorías', 'lceep-astra-child' ),
        'all_items'                  => __( 'Todas las Categorías', 'lceep-astra-child' ),
        'parent_item'                => __( 'Categoría Padre', 'lceep-astra-child' ),
        'parent_item_colon'          => __( 'Categoría Padre:', 'lceep-astra-child' ),
        'new_item_name'              => __( 'Nueva Categoría', 'lceep-astra-child' ),
        'add_new_item'               => __( 'Agregar Nueva Categoría', 'lceep-astra-child' ),
        'edit_item'                  => __( 'Editar Categoría', 'lceep-astra-child' ),
        'update_item'                => __( 'Actualizar Categoría', 'lceep-astra-child' ),
        'view_item'                  => __( 'Ver Categoría', 'lceep-astra-child' ),
        'separate_items_with_commas' => __( 'Separar con comas', 'lceep-astra-child' ),
        'add_or_remove_items'        => __( 'Agregar o eliminar', 'lceep-astra-child' ),
        'choose_from_most_used'      => __( 'Más usadas', 'lceep-astra-child' ),
        'popular_items'              => __( 'Populares', 'lceep-astra-child' ),
        'search_items'               => __( 'Buscar Categorías', 'lceep-astra-child' ),
        'not_found'                  => __( 'No encontrado', 'lceep-astra-child' ),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
    );

    register_taxonomy( 'team_category', array( 'team_member' ), $args );
}
add_action( 'init', 'lceep_register_team_category_taxonomy', 0 );

/**
 * Add custom meta boxes for team members
 */
function lceep_add_team_meta_boxes() {
    add_meta_box(
        'lceep_team_details',
        __( 'Detalles del Miembro', 'lceep-astra-child' ),
        'lceep_team_details_callback',
        'team_member',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'lceep_add_team_meta_boxes' );

/**
 * Meta box callback function
 */
function lceep_team_details_callback( $post ) {
    wp_nonce_field( 'lceep_save_team_details', 'lceep_team_details_nonce' );

    $position = get_post_meta( $post->ID, '_lceep_position', true );
    $email = get_post_meta( $post->ID, '_lceep_email', true );
    $phone = get_post_meta( $post->ID, '_lceep_phone', true );
    $orcid = get_post_meta( $post->ID, '_lceep_orcid', true );
    $researchgate = get_post_meta( $post->ID, '_lceep_researchgate', true );
    $linkedin = get_post_meta( $post->ID, '_lceep_linkedin', true );
    $order = get_post_meta( $post->ID, '_lceep_order', true );

    ?>
    <table class="form-table">
        <tr>
            <th><label for="lceep_position"><?php _e( 'Cargo/Posición', 'lceep-astra-child' ); ?></label></th>
            <td><input type="text" id="lceep_position" name="lceep_position" value="<?php echo esc_attr( $position ); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="lceep_email"><?php _e( 'Email', 'lceep-astra-child' ); ?></label></th>
            <td><input type="email" id="lceep_email" name="lceep_email" value="<?php echo esc_attr( $email ); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="lceep_phone"><?php _e( 'Teléfono', 'lceep-astra-child' ); ?></label></th>
            <td><input type="text" id="lceep_phone" name="lceep_phone" value="<?php echo esc_attr( $phone ); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="lceep_orcid"><?php _e( 'ORCID', 'lceep-astra-child' ); ?></label></th>
            <td><input type="url" id="lceep_orcid" name="lceep_orcid" value="<?php echo esc_attr( $orcid ); ?>" class="regular-text" placeholder="https://orcid.org/..." /></td>
        </tr>
        <tr>
            <th><label for="lceep_researchgate"><?php _e( 'ResearchGate', 'lceep-astra-child' ); ?></label></th>
            <td><input type="url" id="lceep_researchgate" name="lceep_researchgate" value="<?php echo esc_attr( $researchgate ); ?>" class="regular-text" placeholder="https://www.researchgate.net/..." /></td>
        </tr>
        <tr>
            <th><label for="lceep_linkedin"><?php _e( 'LinkedIn', 'lceep-astra-child' ); ?></label></th>
            <td><input type="url" id="lceep_linkedin" name="lceep_linkedin" value="<?php echo esc_attr( $linkedin ); ?>" class="regular-text" placeholder="https://www.linkedin.com/..." /></td>
        </tr>
        <tr>
            <th><label for="lceep_order"><?php _e( 'Orden', 'lceep-astra-child' ); ?></label></th>
            <td><input type="number" id="lceep_order" name="lceep_order" value="<?php echo esc_attr( $order ); ?>" class="small-text" min="0" /></td>
        </tr>
    </table>
    <?php
}

/**
 * Save team member meta data
 */
function lceep_save_team_details( $post_id ) {
    // Check nonce
    if ( ! isset( $_POST['lceep_team_details_nonce'] ) || ! wp_verify_nonce( $_POST['lceep_team_details_nonce'], 'lceep_save_team_details' ) ) {
        return;
    }

    // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save meta fields
    $fields = array( 'position', 'email', 'phone', 'orcid', 'researchgate', 'linkedin', 'order' );

    foreach ( $fields as $field ) {
        if ( isset( $_POST[ 'lceep_' . $field ] ) ) {
            update_post_meta( $post_id, '_lceep_' . $field, sanitize_text_field( $_POST[ 'lceep_' . $field ] ) );
        }
    }
}
add_action( 'save_post_team_member', 'lceep_save_team_details' );

/**
 * Shortcode: Team Carousel
 * Usage: [lceep_team_carousel category="doctorado"]
 */
function lceep_team_carousel_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'category' => '',
        'limit' => -1,
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
    ), $atts, 'lceep_team_carousel' );

    $args = array(
        'post_type' => 'team_member',
        'posts_per_page' => $atts['limit'],
        'orderby' => $atts['orderby'],
        'meta_key' => '_lceep_order',
        'order' => $atts['order'],
    );

    if ( ! empty( $atts['category'] ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'team_category',
                'field' => 'slug',
                'terms' => $atts['category'],
            ),
        );
    }

    $team_query = new WP_Query( $args );

    ob_start();

    if ( $team_query->have_posts() ) :
        ?>
        <div class="lceep-team-carousel swiper">
            <div class="swiper-wrapper">
                <?php while ( $team_query->have_posts() ) : $team_query->the_post(); ?>
                    <div class="swiper-slide">
                        <div class="lceep-team-member" data-aos="fade-up">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'medium' ); ?>" alt="<?php the_title(); ?>" class="lceep-team-photo">
                            <?php else : ?>
                                <img src="<?php echo LCEEP_CHILD_THEME_URI; ?>/assets/images/default-avatar.png" alt="<?php the_title(); ?>" class="lceep-team-photo">
                            <?php endif; ?>

                            <div class="lceep-team-info">
                                <h3 class="lceep-team-name"><?php the_title(); ?></h3>
                                <?php
                                $position = get_post_meta( get_the_ID(), '_lceep_position', true );
                                if ( $position ) : ?>
                                    <p class="lceep-team-role"><?php echo esc_html( $position ); ?></p>
                                <?php endif; ?>

                                <?php
                                $terms = get_the_terms( get_the_ID(), 'team_category' );
                                if ( $terms && ! is_wp_error( $terms ) ) :
                                    foreach ( $terms as $term ) : ?>
                                        <span class="lceep-team-category"><?php echo esc_html( $term->name ); ?></span>
                                    <?php endforeach;
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Navigation -->
            <div class="lceep-carousel-controls">
                <button class="lceep-carousel-btn prev">‹</button>
                <button class="lceep-carousel-btn next">›</button>
            </div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
        <?php
    endif;

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode( 'lceep_team_carousel', 'lceep_team_carousel_shortcode' );

/**
 * Shortcode: Hero Slider
 * Usage: [lceep_hero_slider]
 */
function lceep_hero_slider_shortcode() {
    $slides = array(
        array(
            'image' => 'https://lceep.cl/wp-content/uploads/2018/12/slide-1.jpg',
            'title' => 'Laboratorio de Conversión de Energía y Electrónica de Potencia',
            'subtitle' => 'Investigación de excelencia en energías renovables',
        ),
        array(
            'image' => 'https://lceep.cl/wp-content/uploads/2018/12/slide-2.jpg',
            'title' => 'Innovación en Energía Eólica',
            'subtitle' => 'Desarrollando soluciones sostenibles para el futuro',
        ),
        array(
            'image' => 'https://lceep.cl/wp-content/uploads/2018/12/slide-3.jpg',
            'title' => 'Excelencia Académica',
            'subtitle' => 'Formando profesionales líderes en energías renovables',
        ),
    );

    ob_start();
    ?>
    <div class="lceep-hero-slider">
        <?php foreach ( $slides as $index => $slide ) : ?>
            <div class="lceep-slide <?php echo $index === 0 ? 'active' : ''; ?>" style="background-image: url('<?php echo esc_url( $slide['image'] ); ?>');">
                <div class="lceep-slide-overlay">
                    <div class="lceep-slide-content">
                        <h1><?php echo esc_html( $slide['title'] ); ?></h1>
                        <p><?php echo esc_html( $slide['subtitle'] ); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="lceep-slider-nav">
            <?php foreach ( $slides as $index => $slide ) : ?>
                <span class="lceep-slider-dot <?php echo $index === 0 ? 'active' : ''; ?>" data-slide="<?php echo $index; ?>"></span>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'lceep_hero_slider', 'lceep_hero_slider_shortcode' );

/**
 * Theme Setup
 */
function lceep_theme_setup() {
    // Add theme support
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => __( 'Menú Principal', 'lceep-astra-child' ),
        'footer' => __( 'Menú Footer', 'lceep-astra-child' ),
    ));
}
add_action( 'after_setup_theme', 'lceep_theme_setup' );

/**
 * Register Widget Areas
 */
function lceep_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Footer 1', 'lceep-astra-child' ),
        'id'            => 'footer-1',
        'description'   => __( 'Widgets en footer columna 1', 'lceep-astra-child' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar( array(
        'name'          => __( 'Footer 2', 'lceep-astra-child' ),
        'id'            => 'footer-2',
        'description'   => __( 'Widgets en footer columna 2', 'lceep-astra-child' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar( array(
        'name'          => __( 'Footer 3', 'lceep-astra-child' ),
        'id'            => 'footer-3',
        'description'   => __( 'Widgets en footer columna 3', 'lceep-astra-child' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action( 'widgets_init', 'lceep_widgets_init' );

/**
 * Customize excerpt length
 */
function lceep_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'lceep_excerpt_length', 999 );

/**
 * Customize excerpt more
 */
function lceep_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'lceep_excerpt_more' );
